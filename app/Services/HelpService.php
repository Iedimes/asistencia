<?php

namespace App\Services;

use App\Http\Requests\Admin\Help\IndexHelp;
use App\Http\Requests\Admin\DetailHelp\IndexDetailHelp;
use App\Models\DetailHelp;
use App\Models\Help;
use App\Models\SIG008;
use App\Repositories\HelpRepository;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HelpService
{
    private HelpRepository $repository;

    public function __construct(HelpRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Registrar un nuevo ticket de ayuda.
     */
    public function registerTicket(array $data, ?array $initialDetail = null): Help
    {
        $help = $this->repository->createHelp($data);

        if ($initialDetail) {
            $initialDetail['help_id'] = $help->id;
            $this->repository->createDetailHelp($initialDetail);
        }

        return $help;
    }

    /**
     * Buscar persona por cedula en RRHH o Seguridad.
     */
    public function lookupPersonByCedula(string $ced): array
    {
        // 1. Buscar en RRHH (RHM006 / Funcionario)
        $ci = $this->repository->findPersonInRrhh($ced);

        if ($ci) {
            $dpto = $ci->dpto;
            if (!$dpto && !empty($ci->UniOrgCod)) {
                $dpto = SIG008::where('DepenCod', trim($ci->UniOrgCod))->first();
            }

            $depenDes = $dpto ? trim($dpto->DepenDes) : '';
            $depenCod = $dpto ? trim($dpto->DepenCod) : trim($ci->UniOrgCod ?? '');

            return [
                'error'  => false,
                'cedula' => [
                    'FuncNom' => is_string($ci->FuncNom) ? trim($ci->FuncNom) : ($ci->FuncNom ?? ''),
                    'FUsuCod' => is_string($ci->FUsuCod) ? trim($ci->FUsuCod) : ($ci->FUsuCod ?? ''),
                    'dpto'    => [
                        'DepenDes' => $depenDes,
                        'DepenCod' => $depenCod,
                    ],
                ]
            ];
        }

        // 2. Buscar en SEGURIDAD (Usuario)
        $usuario = $this->repository->findPersonInUsuario($ced);

        if ($usuario) {
            $dpto = $usuario->dpto;
            if (!$dpto && !empty($usuario->DepenCod)) {
                $dpto = SIG008::where('DepenCod', trim($usuario->DepenCod))->first();
            }

            $depenDes = $dpto ? trim($dpto->DepenDes) : '';
            $depenCod = $dpto ? trim($dpto->DepenCod) : trim($usuario->DepenCod ?? '');

            return [
                'error'  => false,
                'cedula' => [
                    'FuncNom' => is_string($usuario->UsuNombre) ? trim($usuario->UsuNombre) : ($usuario->UsuNombre ?? ''),
                    'FUsuCod' => is_string($usuario->UsuCod) ? trim($usuario->UsuCod) : ($usuario->UsuCod ?? ''),
                    'dpto'    => [
                        'DepenDes' => $depenDes,
                        'DepenCod' => $depenCod,
                    ],
                ]
            ];
        }

        // 3. No encontrado
        return [
            'error'   => true,
            'message' => 'Cédula no se encuentra en ninguna tabla',
        ];
    }

    /**
     * Actualizar ticket de ayuda.
     */
    public function updateTicket(Help $help, array $data): Help
    {
        return $this->repository->updateHelp($help, $data);
    }

    /**
     * Eliminar un ticket.
     */
    public function deleteTicket(Help $help): bool
    {
        return $this->repository->deleteHelp($help);
    }

    /**
     * Eliminar masivamente tickets por IDs.
     */
    public function bulkDeleteTickets(array $ids): int
    {
        return $this->repository->bulkDeleteHelps($ids);
    }

    /**
     * Aplicar filtro de búsqueda avanzada para Asistencias (index, finalizadas, pendientes).
     * Soporta 2 buscadores independientes e insensibles a mayúsculas/minúsculas:
     * - 'search': Solicitante, Cédula, Nro. Ticket, Dependencia, Problema.
     * - 'tecnico' / 'filters.tecnico': Técnico Asignado.
     */
    private function applyAdvancedSearch($query, Request $request): void
    {
        // 1. Buscador por Solicitante / Cédula / Nro. Ticket / Dependencia / Problema
        if ($request->has('search') && trim((string) $request->input('search')) !== '') {
            $search = trim((string) $request->input('search'));
            $searchLower = mb_strtolower($search, 'UTF-8');

            $query->where(function ($q) use ($search, $searchLower) {
                $q->where('helps.id', 'like', "%{$search}%")
                  ->orWhere('helps.ci', 'like', "%{$search}%")
                  ->orWhere(DB::raw("LOWER(helps.name)"), 'like', "%{$searchLower}%")
                  ->orWhere(DB::raw("LOWER(helps.dependency)"), 'like', "%{$searchLower}%")
                  ->orWhere(DB::raw("LOWER(helps.problem)"), 'like', "%{$searchLower}%")
                  ->orWhere('helps.fone', 'like', "%{$search}%");
            });
        }

        // 2. Buscador separado por Técnico Asignado (excluyendo usuario sistema ID 1 y filtrando solo por el ÚLTIMO detalle/estado del ticket)
        $tecnicoSearch = trim((string) ($request->input('tecnico') ?? $request->input('filters.tecnico') ?? $request->input('search_tecnico') ?? ''));
        if ($tecnicoSearch !== '') {
            $tecnicoLower = mb_strtolower($tecnicoSearch, 'UTF-8');
            $query->whereExists(function ($subQuery) use ($tecnicoLower) {
                $subQuery->select(DB::raw(1))
                    ->from('detail_helps as dh')
                    ->whereRaw('dh.help_id = helps.id')
                    ->where('dh.user_id', '!=', 1)
                    ->whereNotExists(function ($dh2Query) {
                        $dh2Query->select(DB::raw(1))
                            ->from('detail_helps as dh2')
                            ->whereRaw('dh2.help_id = dh.help_id')
                            ->where(function ($q) {
                                $q->whereRaw('dh2.created_at > dh.created_at')
                                  ->orWhere(function ($q2) {
                                      $q2->whereRaw('dh2.created_at = dh.created_at')
                                         ->whereRaw('dh2.id > dh.id');
                                  });
                            });
                    })
                    ->whereExists(function ($userQuery) use ($tecnicoLower) {
                        $userQuery->select(DB::raw(1))
                            ->from('admin_users as au')
                            ->whereRaw('au.id = dh.user_id')
                            ->where(function ($uq) use ($tecnicoLower) {
                                $uq->where(DB::raw("LOWER(au.first_name)"), 'like', "%{$tecnicoLower}%")
                                   ->orWhere(DB::raw("LOWER(au.last_name)"), 'like', "%{$tecnicoLower}%")
                                   ->orWhere(DB::raw("LOWER(CONCAT(au.first_name, ' ', au.last_name))"), 'like', "%{$tecnicoLower}%");
                            });
                    });
            });
        }
    }

    /**
     * Obtener listado de tickets activos/en proceso (state_id NOT IN (4, 9) en ultimo detalle).
     */
    public function getIndexTickets(IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->whereNotIn('state_id', [4, 9])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            });

        $ordersBeingAttended = Help::whereIn('id', $detalleQuery)
            ->select('id', 'created_at')
            ->without(['statuses', 'tecnico', 'detailsHelps', 'documento'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->values()
            ->map(function ($order, $index) {
                $order->position = $index + 1;
                return $order;
            });

        $positionMap = $ordersBeingAttended->pluck('position', 'id');

        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            [],
            function ($query) use ($detalleQuery, $request) {
                $query->whereIn('id', $detalleQuery);
                $this->applyAdvancedSearch($query, $request);
                $query->orderBy('id', 'ASC');
            }
        );

        $data->getCollection()->transform(function ($item) use ($positionMap) {
            $item->position = $positionMap[$item->id] ?? null;
            $item->order = $positionMap[$item->id] ?? null;
            return $item;
        });

        return $data;
    }

    /**
     * Obtener listado de tickets finalizados (state_id = 4 en ultimo detalle).
     */
    public function getFinalizadasTickets(IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->where('state_id', '=', 4)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            });

        return AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            [],
            function ($query) use ($detalleQuery, $request) {
                $query->whereIn('id', $detalleQuery);
                $this->applyAdvancedSearch($query, $request);
                $query->orderBy('id', 'DESC');
            }
        );
    }

    /**
     * Obtener listado de tickets pendientes (state_id = 9 en ultimo detalle).
     */
    public function getPendientesTickets(IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->where('state_id', '=', 9)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            })
            ->orderBy('help_id', 'desc');

        return AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            [],
            function ($query) use ($detalleQuery, $request) {
                $query->whereIn('id', $detalleQuery);
                $this->applyAdvancedSearch($query, $request);
                $query->orderBy('id', 'DESC');
            }
        );
    }

    /**
     * Obtener listado paginado de historial de detalles de atenciones técnicas.
     * Búsqueda única por Nro. de Ticket, Solución o Nombre de Técnico (insensible a mayúsculas/minúsculas).
     */
    public function getDetailHelpsList(IndexDetailHelp $request)
    {
        return AdminListing::create(DetailHelp::class)->processRequestAndGet(
            $request,
            ['id', 'help_id', 'user_id', 'state_id', 'solution', 'date', 'category_id', 'patrimony', 'created_at'],
            [],
            function ($query) use ($request) {
                $query->where('user_id', '!=', 1);

                if ($request->has('search') && trim((string) $request->input('search')) !== '') {
                    $search = trim((string) $request->input('search'));
                    $searchLower = mb_strtolower($search, 'UTF-8');

                    $query->where(function ($q) use ($search, $searchLower) {
                        $q->where('help_id', 'like', "%{$search}%")
                          ->orWhere(DB::raw("LOWER(solution)"), 'like', "%{$searchLower}%")
                          ->orWhere(DB::raw("LOWER(patrimony)"), 'like', "%{$searchLower}%");
                    });
                }

                $query->orderBy('date', 'desc');
            }
        );
    }

    /**
     * Generar reporte PDF de un ticket con opciones personalizadas de papel, orientación y anchos de columna.
     */
    public function generateTicketPdf(int $helpId, array $params = [])
    {
        $help = $this->repository->findOrFail($helpId);
        $detalle = $this->repository->getHelpDetails($helpId);

        $paperSizeRaw = strtolower($params['paper_size'] ?? 'a4');
        $allowedPaperSizes = ['a4', 'legal', 'letter', 'a3'];
        $paperSize = in_array($paperSizeRaw, $allowedPaperSizes, true) ? $paperSizeRaw : 'a4';

        $orientationRaw = strtolower($params['orientation'] ?? 'portrait');
        $allowedOrientations = ['portrait', 'landscape'];
        $orientation = in_array($orientationRaw, $allowedOrientations, true) ? $orientationRaw : 'portrait';

        // Anchos de columna dinámicos pasados desde la pantalla (o valores por defecto)
        $colWidths = [
            'user'      => $params['col_user'] ?? '22%',
            'solution'  => $params['col_solution'] ?? '44%',
            'date'      => $params['col_date'] ?? '14%',
            'category'  => $params['col_category'] ?? '10%',
            'patrimony' => $params['col_patrimony'] ?? '10%',
        ];

        return Pdf::loadView('admin.help.pdf.prueba', compact('help', 'detalle', 'colWidths'))
                  ->setPaper($paperSize, $orientation);
    }

    /**
     * Ver/abrir documento de un ticket.
     */
    public function viewDocument(int $helpId)
    {
        $media = $this->repository->getMediaForHelp($helpId);

        if ($media->isEmpty()) {
            abort(404, 'No se encontraron documentos relacionados.');
        }

        foreach ($media as $medium) {
            $filePath = public_path("media/{$medium->id}/{$medium->file_name}");

            if (file_exists($filePath)) {
                $mimeType = mime_content_type($filePath);
                $headers = [
                    'Content-Type' => $mimeType,
                ];

                return response()->file($filePath, $headers);
            }
        }

        abort(404, 'No se encontró ningún archivo válido.');
    }

    /**
     * Obtener datos API de funcionario.
     */
    public function getFuncionarioApiData(?string $ci)
    {
        return $this->repository->getFuncionarioApiData($ci);
    }

    /**
     * Guardar archivo adjunto a un ticket.
     */
    public function storeDocument(int $helpId, Request $request): Help
    {
        $help = $this->repository->findOrFail($helpId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $help->addMedia($file)->toMediaCollection('gallery');
        }

        return $help;
    }

    /**
     * Eliminar adjunto relacionado a un ticket.
     */
    public function deleteDocument(int $helpId): int
    {
        return $this->repository->deleteMediaForHelp($helpId);
    }
}
