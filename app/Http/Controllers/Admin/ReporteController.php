<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reporte\BulkDestroyReporte;
use App\Http\Requests\Admin\Reporte\DestroyReporte;
use App\Http\Requests\Admin\Reporte\IndexReporte;
use App\Http\Requests\Admin\Reporte\StoreReporte;
use App\Http\Requests\Admin\Reporte\UpdateReporte;
use App\Models\Reporte;
use App\Models\State;
use App\Models\DetailHelp;
use App\Models\AdminUser;
use App\Models\Help;
use Illuminate\Http\Request;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Services\ReporteService;

class ReporteController extends Controller
{
    protected $reporteService;

    public function __construct(ReporteService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexReporte $request
     * @return array|Factory|View
     */
    public function index(IndexReporte $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Reporte::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['inicio', 'fin', 'user_id', 'state_id'],

            // set columns to searchIn
            ['']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.reporte.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.reporte.create');
        $user = AdminUser::where('id', '<>', 1)->get();
        $estado = State::all();

        return view('admin.reporte.create', compact('user', 'estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReporte $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReporte $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Reporte
        $reporte = Reporte::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/reportes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/reportes');
    }

    /**
     * Procesar filtros de consulta del reporte mediante el servicio.
     */
    private function processReporteQuery(Request $request): array
    {
        $rules = [
            'inicio' => 'required|date',
            'fin'    => 'required|date',
        ];
        $messages = [
            'inicio.required' => 'Debe cargar la fecha de inicio.',
            'fin.required'    => 'Debe cargar la fecha de fin.',
        ];
        $this->validate($request, $rules, $messages);

        return $this->reporteService->generateReport($request->all());
    }

    public function pdf(Request $request)
    {
        [$dhelps, $contar, $filtros] = $this->processReporteQuery($request);

        $paperSize   = $filtros['paper_size'] ?? 'a4';
        $orientation = $filtros['orientation'] ?? 'landscape';

        // Generar PDF con el tamaño de hoja y orientación seleccionados por el usuario
        $pdf = Pdf::loadView('admin.reporte.prueba', compact('dhelps', 'contar', 'filtros'))
                  ->setPaper($paperSize, $orientation);

        return $pdf->download('ReporteAsistencias_' . date('Ymd_His') . '.pdf');
    }

    public function resultados(Request $request)
    {
        [$dhelps, $contar, $filtros] = $this->processReporteQuery($request);

        return view('admin.reporte.resultados', compact('dhelps', 'contar', 'filtros'));
    }





    /**
     * Display the specified resource.
     *
     * @param Reporte $reporte
     * @throws AuthorizationException
     * @return void
     */
    public function show(Reporte $reporte)
    {
        $this->authorize('admin.reporte.show', $reporte);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reporte $reporte
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Reporte $reporte)
    {
        $this->authorize('admin.reporte.edit', $reporte);


        return view('admin.reporte.edit', [
            'reporte' => $reporte,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReporte $request
     * @param Reporte $reporte
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReporte $request, Reporte $reporte)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Reporte
        $reporte->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/reportes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/reportes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReporte $request
     * @param Reporte $reporte
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReporte $request, Reporte $reporte)
    {
        $reporte->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReporte $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReporte $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Reporte::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
