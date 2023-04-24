<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reporte\BulkDestroyReporte;
use App\Http\Requests\Admin\Reporte\DestroyReporte;
use App\Http\Requests\Admin\Reporte\IndexReporte;
use App\Http\Requests\Admin\Reporte\StoreReporte;
use App\Http\Requests\Admin\Reporte\UpdateReporte;
use App\Models\Reporte;
use App\Models\DetailHelp;
use App\Models\AdminUser;
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
use PDF;

class ReporteController extends Controller
{

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
            ['inicio', 'fin', 'user_id'],

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
        $user = AdminUser::all();

        return view('admin.reporte.create', compact('user'));
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


    public function pdf(Request $request)
    {
        $request;

        $rules = [
            'inicio' => 'required',
            'fin' => 'required',
        ];

        $messages = [
            'inicio.required' => 'Debe cargar la fecha de inicio.',
            'fin.required' => 'Debe cargar la fecha de fin.',
        ];

        $this->validate($request, $rules, $messages);



        $inicio=$request->inicio;
        $fin=$request->fin;
        $user=$request->user_id;

        if ($user==0){
            $finalizados=DetailHelp::where('state_id', 4)
                                ->select('help_id')
                                // ->get();
                                ->pluck('help_id')->toArray();
            $id_help = $finalizados;
            //return $id_help;
            $dhelps=DetailHelp::whereBetween('updated_at', ["$inicio", "$fin"])
                               ->whereIn('help_id', $id_help)
                               ->where('state_id', '<>', 1)
                               ->where('user_id', '<>', 1)
                               ->orderby('user_id', 'ASC')
                               ->orderby('help_id', 'ASC')
                                ->get();
                                $contar = count($dhelps);
                                $pdf = PDF::loadView('admin.reporte.prueba', compact('dhelps' , 'contar'))->setPaper('a4', 'landscape');
                                return $pdf->download('ReporteAsistencias.pdf');
        }else{
            $finalizados=DetailHelp::where('state_id', 4)
                                ->select('help_id')
                                // ->get();
                                ->pluck('help_id')->toArray();
            $id_help = $finalizados;
            $dhelps=DetailHelp::whereBetween('updated_at', ["$inicio", "$fin"])
                                ->whereIn('help_id', $id_help)
                                ->where('state_id', '<>', 1)
                                ->where('user_id', '<>', 1)
                                ->where('user_id', $user)
                                ->orderby('help_id', 'ASC')
                                ->get();
                                //$visits = Visit::whereBetween('Exit_Datetime', ["$inicio", "$fin"])->get();
                                $contar = count($dhelps);
                                $pdf = PDF::loadView('admin.reporte.prueba', compact('dhelps' , 'contar'))->setPaper('a4', 'landscape');
                                return $pdf->download('ReporteAsistencias.pdf');
        }

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
