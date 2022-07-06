<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Help\BulkDestroyHelp;
use App\Http\Requests\Admin\Help\DestroyHelp;
use App\Http\Requests\Admin\Help\IndexHelp;
use App\Http\Requests\Admin\Help\StoreHelp;
use App\Http\Requests\Admin\Help\UpdateHelp;
use App\Models\AdminUser;
use App\Models\Help;
use App\Models\State;
use App\Models\Category;
use App\Models\SIG008;
use App\Models\RHM006;
use App\Models\DetailHelp;
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

class HelpsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexHelp $request
     * @return array|Factory|View
     */
    public function index(Help $help ,IndexHelp $request)
    {
            // create and AdminListing instance for a specific model and

            $id = $help->id;
            $data = AdminListing::create(Help::class)->processRequestAndGet(
             // pass the request with params

             $request,
             // set columns to query
             ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem','created_at'],

             // set columns to searchIn
             ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],


            function ($query) use ($id) {
                 $query
                    //  ->where('helps.id', '=', $id);
                   ->orderBy('id', 'DESC');
             }

         );




        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data,'help' => $help];
        }

        return view('admin.help.index', ['data' => $data, 'help' => $help]);
    }


    public function finalizadas(Help $help,IndexHelp $request)
    {
            // create and AdminListing instance for a specific model and

            //return $help::find(21813);

            $id = $help->id;
            $busqueda = $request->search;

            // return $busqueda;
            $data = AdminListing::create(Help::class)->processRequestAndGet(
             // pass the request with params

            $request,

             // set columns to query
             ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem','created_at'],

             // set columns to searchIn
             ['id'],

            function ($query) use ($busqueda) {

                //    ->where('helps.id', '=', $id);

                    $aux = $busqueda;
                    $query->whereHas('tecnico.user', function($tecnico) use($aux) {

                        //$tecnico->where('first_name', $aux);
                        $tecnico->where('first_name', 'LIKE', '%'.$aux.'%');
                });
             }

    );



        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            //return $request;
            return ['data' => $data,'help' => $help];
        }

        return view('admin.help.finalizadas', ['data' => $data, 'help' => $help]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.help.create');

        // return view('admin.help.create');

        return view('admin.help.create');
    }

    public function createadm()
    {
        // $this->authorize('admin.help.create');

        // return view('admin.help.create');

        return view('admin.help.createadm');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHelp $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreHelp $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Help
        $help = Help::create($sanitized);

        $status = new DetailHelp();

        $status->help_id = $help->id;
        $status->user_id = '1';
        $status->state_id = '1';
        $status->solution = 'INICIO DE SOLUCION PROPUESTA';
        $status->date = date('Y-m-d h:i:s');
        $status->category_id = '1';
        $status->patrimony = '1';
        $status->save();

        if ($request->ajax()) {
            return ['redirect' => url('/'), 'ticket' => $help['id'] ];
        }

        return redirect('/');
    }


    public function storeadm(StoreHelp $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Help
        $help = Help::create($sanitized);

        $status = new DetailHelp();

        $status->help_id = $help->id;
        $status->user_id = '1';
        $status->state_id = '1';
        $status->solution = 'INICIO DE SOLUCION PROPUESTA';
        $status->date = date('Y-m-d h:i:s');
        $status->category_id = '1';
        $status->patrimony = '1';
        $status->save();

        if ($request->ajax()) {
            return ['redirect' => url('admin/helps'), 'ticket' => $help['id'] ];

        }

        return redirect('admin/helps');
    }



    /**
     * Display the specified resource.
     *
     * @param Help $help
     * @throws AuthorizationException
     * @return void
     */
    public function show(Help $help, IndexHelp $request)
    {
        //$this->authorize('admin.help.show', $help);
        $id = $help->id;
        $data = AdminListing::create(DetailHelp::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'help_id', 'user_id', 'state_id', 'solution', 'date', 'category_id', 'patrimony'],

            // set columns to searchIn
            ['id', 'solution'],
            function ($query) use ($id) {
                $query
                    ->where('detail_helps.help_id', '=', $id);
                //->orderBy('requirements.requirement_type_id');
            }
        );


        return view('admin.help.show', compact('help', 'data') );


        // TODO your code goes here
    }

    public function createPDF($id)
    {

        // return $help = Help::find(1024);

        $help = Help::where('id', $id)->first();
        $detalle = DetailHelp::all()->where('help_id', '=', $id);


        $pdf = PDF::loadView('admin.help.pdf.prueba', compact('help' , 'detalle'));
        return $pdf->download('ReporteDetalle.pdf');
        //return 'pdf';
        // retreive all records from db
        /*$data = Resume::all();

        // share data to view
        view()->share('employee', $data);
        $pdf = PDF::loadView('pdf_view', $data);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');*/
    }





    public function createdetail($id)
    {

        $this->authorize('admin.detail-help.create');

        $state = State::all();
        $category = category::all();
        $user = AdminUser::all();

        return view('admin.detail-help.create', compact('id', 'state', 'category', 'user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Help $help
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Help $help)
    {
        $this->authorize('admin.help.edit', $help);


        return view('admin.help.edit', [
            'help' => $help,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHelp $request
     * @param Help $help
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateHelp $request, Help $help)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Help
        $help->update($sanitized);

        if ($request->ajax()) {
            // return [
            //     'redirect' => url('admin/helps'),
            //     'message' => trans('brackets/admin-ui::admin.operation.succeeded'),];
            if ($help->statuses->state->id == 4){
                return ['redirect' => url('admin/helps/finalizadas'), 'ticket' => $help['id'] ];
            }else{
            return ['redirect' => url('admin/helps/'), 'ticket' => $help['id'] ];
            }

        }

        return redirect('admin/helps');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyHelp $request
     * @param Help $help
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyHelp $request, Help $help)
    {
        $help->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyHelp $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyHelp $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Help::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function cedula($ced)
    {
        $ci = RHM006::where('FuncNro', $ced)
                ->first();
                if ($ci) {
                    return response()->json([
                        'error' => false,
                        'cedula' => $ci
                    ]);
                }else{
                    return response()->json([
                        'error' => true,
                        //'cedula' => $ci
                    ]);
                }

        //return $ci;
        //return json_encode($ci, JSON_FORCE_OBJECT);
        //return json_encode($ci, JSON_UNESCAPED_UNICODE);
    }
    // public function username($username)
    // {
    //     $usr = RHM006::where('FUsucod', $username)
    //             ->first();
    //             if ($usr) {
    //                 return response()->json([
    //                     'error' => false,
    //                     'username' => $usr
    //                 ]);
    //             }else{
    //                 return response()->json([
    //                     'error' => true,
    //                     //'cedula' => $ci
    //                 ]);
    //             }

    //     //return $ci;
    //     //return json_encode($ci, JSON_FORCE_OBJECT);
    //     //return json_encode($ci, JSON_UNESCAPED_UNICODE);
    // }

}
