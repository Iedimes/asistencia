<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Help\BulkDestroyHelp;
use App\Http\Requests\Admin\Help\DestroyHelp;
use App\Http\Requests\Admin\Help\IndexHelp;
use App\Http\Requests\Admin\Help\StoreHelp;
use App\Http\Requests\Admin\Help\UpdateHelp;
use App\Models\AdminUser;
use App\Models\Category;
use App\Models\DetailHelp;
use App\Models\Help;
use App\Models\State;
use App\Services\HelpService;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HelpsController extends Controller
{
    private HelpService $service;

    public function __construct(HelpService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of tickets (Activos / En Proceso).
     */
    public function index(Help $help, IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->where('state_id', '!=', 4)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            });

        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            function ($query) use ($detalleQuery) {
                $query->whereIn('id', $detalleQuery)->orderBy('id', 'ASC');
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.help.index', ['data' => $data]);
    }

    /**
     * Display a listing of finalizadas tickets.
     */
    public function finalizadas(IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->where('state_id', '=', 4)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            });

        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            function ($query) use ($detalleQuery) {
                $query->whereIn('id', $detalleQuery)->orderBy('id', 'DESC');
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.help.finalizadas', ['data' => $data]);
    }

    /**
     * Display a listing of pendientes tickets (state_id = 9).
     */
    public function pendientes(IndexHelp $request)
    {
        $data = $this->service->getPendientesTickets($request);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.help.pendientes', ['data' => $data]);
    }

    /**
     * Show form for public ticket creation.
     */
    public function create()
    {
        return view('admin.help.create');
    }

    /**
     * Show form for admin ticket creation.
     */
    public function createadm()
    {
        return view('admin.help.createadm');
    }

    /**
     * Show form for detail help creation.
     */
    public function createdetail($id)
    {
        $this->authorize('admin.detail-help.create');

        $state = State::all();
        $category = Category::all();
        $user = AdminUser::all();

        return view('admin.detail-help.create', compact('id', 'state', 'category', 'user'));
    }

    /**
     * Store a newly created public ticket.
     */
    public function store(StoreHelp $request)
    {
        $sanitized = $request->getSanitized();

        $stateId = State::first()->id ?? 1;
        $categoryId = Category::first()->id ?? 1;

        $initialDetail = [
            'user_id'     => '1',
            'state_id'    => $stateId,
            'solution'    => 'INICIO DE SOLUCION PROPUESTA',
            'date'        => date('Y-m-d H:i:s'),
            'category_id' => $categoryId,
            'patrimony'   => '1',
        ];

        $help = $this->service->registerTicket($sanitized, $initialDetail);

        if ($request->ajax()) {
            return [
                'redirect'        => url('/'),
                'ticket'          => $help->id,
                'showTicketModal' => true,
            ];
        }

        return redirect('/');
    }

    /**
     * Store a newly created admin ticket.
     */
    public function storeadm(StoreHelp $request)
    {
        $sanitized = $request->getSanitized();

        $stateId = State::first()->id ?? 1;
        $categoryId = Category::first()->id ?? 1;

        $initialDetail = [
            'user_id'     => '1',
            'state_id'    => $stateId,
            'solution'    => 'INICIO DE SOLUCION PROPUESTA',
            'date'        => date('Y-m-d H:i:s'),
            'category_id' => $categoryId,
            'patrimony'   => '1',
        ];

        $help = $this->service->registerTicket($sanitized, $initialDetail);

        if ($request->ajax()) {
            return [
                'redirect'        => url('admin/helps'),
                'ticket'          => $help->id,
                'showTicketModal' => true,
            ];
        }

        return redirect('admin/helps');
    }

    /**
     * Display specified ticket and its details/history.
     */
    public function show(Help $help, IndexHelp $request)
    {
        $id = $help->id;
        $data = AdminListing::create(DetailHelp::class)->processRequestAndGet(
            $request,
            ['id', 'help_id', 'user_id', 'state_id', 'solution', 'date', 'category_id', 'patrimony'],
            ['id', 'solution'],
            function ($query) use ($id) {
                $query->where('detail_helps.help_id', '=', $id);
            }
        );

        if ($request->ajax()) {
            return ['data' => $data];
        }

        return view('admin.help.show', compact('help', 'data'));
    }

    /**
     * Show edit form for admin users.
     */
    public function edit(Help $help)
    {
        $this->authorize('admin.help.edit', $help);

        return view('admin.help.edit', [
            'help' => $help,
        ]);
    }

    /**
     * Show edit form for public users (adjuntar documento).
     */
    public function editar(Help $help)
    {
        return view('admin.help.editar', [
            'help' => $help,
        ]);
    }

    /**
     * Update specified help ticket.
     */
    public function update(UpdateHelp $request, Help $help)
    {
        $sanitized = $request->getSanitized();

        $this->service->updateTicket($help, $sanitized);

        if ($request->ajax()) {
            $redirectUrl = ($help->statuses && $help->statuses->state_id == 4)
                ? url('admin/helps/finalizadas')
                : url('admin/helps');

            return [
                'redirect'        => $redirectUrl,
                'ticket'          => $help->id,
                'showTicketModal' => true,
            ];
        }

        return redirect('admin/helps');
    }

    /**
     * Guardar solicitud publica con documento adjunto.
     */
    public function guardarSolicitud(UpdateHelp $request, Help $help)
    {
        $sanitized = $request->getSanitized();

        if ($request->hasFile('media')) {
            $help->addMediaFromRequest('media')
                 ->toMediaCollection('gallery');
        }

        $this->service->updateTicket($help, $sanitized);

        if ($request->ajax()) {
            return [
                'redirect'        => '/',
                'ticket'          => $help->id,
                'showTicketModal' => true,
                'message'         => trans('brackets/admin-ui::admin.operation.succeeded')
            ];
        }

        return redirect('/');
    }

    /**
     * Remove specified help ticket.
     */
    public function destroy(DestroyHelp $request, Help $help)
    {
        $this->service->deleteTicket($help);

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Bulk destroy tickets.
     */
    public function bulkDestroy(BulkDestroyHelp $request): Response
    {
        $this->service->bulkDeleteTickets($request->data['ids']);

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
     * Endpoint AJAX para consultar cedula.
     */
    public function cedula($ced)
    {
        return response()->json($this->service->lookupPersonByCedula($ced));
    }

    /**
     * Endpoint API para obtener datos de funcionario por cedula.
     */
    public function api($ci = null)
    {
        return response()->json($this->service->getFuncionarioApiData($ci));
    }

    /**
     * Generar reporte PDF de ticket.
     */
    public function createPDF($id)
    {
        $pdf = $this->service->generateTicketPdf($id);
        return $pdf->download('ReporteDetalle.pdf');
    }

    /**
     * Ver/abrir documento adjunto a un ticket.
     */
    public function verdocumento($helpId)
    {
        return $this->service->viewDocument($helpId);
    }

    /**
     * Eliminar documento adjunto.
     */
    public function eliminardocumento($helpId)
    {
        $count = $this->service->deleteDocument($helpId);

        if ($count === 0) {
            session()->flash('error', 'No se encontraron documentos relacionados.');
        } else {
            session()->flash('success', 'El documento ha sido eliminado exitosamente.');
        }

        return back();
    }

    /**
     * Formulario para adjuntar documento a ticket.
     */
    public function documento($id)
    {
        $help = Help::findOrFail($id);
        return view('admin.help.createdocument', compact('help'));
    }

    /**
     * Guardar documento subido a ticket.
     */
    public function storeDocument(Request $request, $id)
    {
        $this->service->storeDocument($id, $request);
        return response()->json(['message' => 'Documento adjuntado con éxito.'], 200);
    }
}
