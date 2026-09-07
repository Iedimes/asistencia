<?php

namespace App\Services;

use App\Http\Requests\Admin\Help\IndexHelp;
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
            if (!$dpto && !empty($ci->FuncADpto)) {
                $dpto = SIG008::where('DepenCod', trim($ci->FuncADpto))->first();
            }

            $depenDes = $dpto ? trim($dpto->DepenDes) : '';
            $depenCod = $dpto ? trim($dpto->DepenCod) : trim($ci->FuncADpto ?? '');

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
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            function ($query) use ($detalleQuery) {
                $query->whereIn('id', $detalleQuery)->orderBy('id', 'DESC');
            }
        );
    }

    /**
     * Generar reporte PDF de un ticket.
     */
    public function generateTicketPdf(int $helpId)
    {
        $help = $this->repository->findOrFail($helpId);
        $detalle = $this->repository->getHelpDetails($helpId);

        return Pdf::loadView('admin.help.pdf.prueba', compact('help', 'detalle'));
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
