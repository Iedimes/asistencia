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
use App\Models\Medium;
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
     * Display a listing of active tickets.
     */
    public function index(Help $help, IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->whereIn('state_id', [1, 2])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.id < dh2.id');
            });

        $data = AdminListing::create(Help::class)
            ->modifyQuery(function ($query) use ($detalleQuery) {
                $query->whereIn('id', $detalleQuery);
            })
            ->processRequestAndGet(
                $request,
                ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
                ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return ['bulkItems' => $data->pluck('id')];
            }
            return ['data' => $data];
        }

        return view('admin.help.index', ['data' => $data]);
    }

    /**
     * Display a listing of finished tickets.
     */
    public function finalizadas(Help $help, IndexHelp $request)
    {
        $detalleQuery = DetailHelp::select('help_id')
            ->where('state_id', 4)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.id < dh2.id');
            });

        $data = AdminListing::create(Help::class)
            ->modifyQuery(function ($query) use ($detalleQuery) {
                $query->whereIn('id', $detalleQuery);
            })
            ->processRequestAndGet(
                $request,
                ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
                ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return ['bulkItems' => $data->pluck('id')];
            }
            return ['data' => $data];
        }

        return view('admin.help.indexfinalizadas', ['data' => $data]);
    }

    /**
     * Show form for creating a new help ticket.
     */
    public function create()
    {
        $this->authorize('admin.help.create');
        return view('admin.help.create');
    }

    /**
     * Store a newly created help ticket.
     */
    
    /**
     * Store administrator help request.
     */
    public function storeadm(StoreHelp $request)
    {
        return $this->store($request);
    }

    public function store(StoreHelp $request)
    {
        $sanitized = $request->getSanitized();

        $state = State::first() ?? State::create(['name' => 'Abierto']);
        $category = Category::first() ?? Category::create(['name' => 'General']);

        $help = $this->service->registerTicket($sanitized, [
            'state_id'    => $state->id,
            'category_id' => $category->id,
            'solution'    => 'Ticket registrado',
            'user_id'     => auth()->id() ?? 1,
            'date'        => now(),
        ]);

        if ($request->hasFile('media')) {
            $help->addMediaFromRequest('media')->toMediaCollection('gallery');
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/helps'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/helps');
    }

    /**
     * Display specified ticket.
     */
    public function show(Help $help)
    {
        $this->authorize('admin.help.show', $help);
        return view('admin.help.show', compact('help'));
    }

    /**
     * Show edit form.
     */
    public function edit(Help $help)
    {
        $this->authorize('admin.help.edit', $help);

        return view('admin.help.edit', [
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
                : url('admin/helps/');

            return [
                'redirect'        => $redirectUrl,
                'ticket'          => $help->id,
                'showTicketModal' => true
            ];
        }

        return redirect('admin/helps');
    }

    /**
     * Remove specified ticket.
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
}
