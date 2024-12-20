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
use App\Models\Medium;
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
    public function index(Help $help, IndexHelp $request)
{
    // Consulta de los IDs de las ayudas que cumplen con el estado 1 o 2
    $detalleIds = DetailHelp::select('help_id')
        ->whereIn('state_id', [1, 2]) // Filtrar por los estados 1 y 2
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->pluck('help_id');

    // Obtener las órdenes atendidas con su posición en la cola
    $ordersBeingAttended = Help::whereIn('id', $detalleIds)
    ->with(['detailsHelps']) // Incluye los detalles relacionados
    ->orderBy('created_at', 'asc') // Ordenar por la fecha más vieja de la cabecera
    ->get();


    // Asignar la posición en la cola
    $ordersBeingAttended = $ordersBeingAttended->map(function ($order, $index) {
        $order->position = $index + 1; // La posición es el índice + 1
        return $order;
    });

    // Procesar la consulta de AdminListing
    $data = AdminListing::create(Help::class)->processRequestAndGet(
        $request,
        ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
        ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
        function ($query) use ($detalleIds) {
            $query->whereIn('id', $detalleIds)->orderBy('id', 'ASC');
        }
    );

    // Encontrar la posición del ticket en la cola
     // Encontrar la posición del ticket en la cola
     foreach ($data as $ticket) {
        $ticket->position = $ordersBeingAttended->where('id', $ticket->id)->first()->position ?? null;
    }


    // Retornar los datos con la posición
    if ($request->ajax()) {
        return response()->json([
            'orders' => $ordersBeingAttended,
            'data' => $data
        ]);
    }

    return view('admin.help.index', [
        'data' => $data,
        'help' => $help,
        'ordersBeingAttended' => $ordersBeingAttended
    ]);
}



    public function finalizadas(Help $help,IndexHelp $request)
    {
            // create and AdminListing instance for a specific model and

            //return $help::find(21813);

            // $id = $help->id;
            // $busqueda = $request->search;

            // // return $busqueda;
            // $data = AdminListing::create(Help::class)->processRequestAndGet(
            //  // pass the request with params

            // $request,

            //  // set columns to query
            //  ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem','created_at'],

            //  // set columns to searchIn
            //  ['id'],

            // function ($query) use ($busqueda) {

            //     //    ->where('helps.id', '=', $id);

            //         $aux = $busqueda;
            //         $query->whereHas('tecnico.user', function($tecnico) use($aux) {

            //             //$tecnico->where('first_name', $aux);
            //             $tecnico->where('first_name', 'LIKE', '%'.$aux.'%');
            //     });
            //  }


             //$id = $help->id;

        $detalle = $detalle = DetailHelp::select('help_id')
        ->where('state_id', '=', 4)
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->orderBy('help_id', 'desc')
        ->pluck('help_id');

        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem', 'created_at'],
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            function ($query) use ($detalle) {
                $query->whereIn('id', $detalle)->orderBy('id', 'DESC');
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
            return [
                'redirect' => url('/'),
                'ticket' => $help['id'],
                'showTicketModal' => true // Indicador de que debe mostrarse el modal
            ];
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
            return [
                'redirect' => url('admin/helps'),
                'ticket' => $help['id'],
                'showTicketModal' => true // Indicador para mostrar el modal
            ];
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

        //return $detalle = DetailHelp::all()->where('help_id', '=', $id)->sortBy('id');
        //$detalle = DetailHelp::where('help_id', '=', $id)->orderBy('id', 'asc')->get();
        $detalle = DetailHelp::where('help_id', '=', $id)
                     ->orderBy('id', 'asc')
                     ->orderBy('help_id', 'asc')
                     ->get();


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

    public function editar(Help $help)
    {
        // $this->authorize('admin.help.editar', $help);

        return view('admin.help.editar', [
            'help' => $help,
        ]);
    }




    public function verdocumento($helpId)
    {
        // Encuentra todos los archivos relacionados con el helpId
        $media = Medium::where('model_id', $helpId)->get();


        if ($media->isEmpty()) {
            abort(404, 'No se encontraron documentos relacionados.');
        }

        // Itera sobre los archivos para encontrar uno válido
        foreach ($media as $medium) {
            $filePath = public_path("media/{$medium->id}/{$medium->file_name}");
            // dd(public_path("media/{$medium->id}/{$medium->file_name}"));
            // Opcional: Depura la ruta para verificar si es correcta


            if (file_exists($filePath)) {
                // Obtén el tipo MIME del archivo para definir su comportamiento
                $mimeType = mime_content_type($filePath);
                $headers = [
                    'Content-Type' => $mimeType,
                ];

                // Retorna el archivo para abrirlo en el navegador si es compatible
                return response()->file($filePath, $headers);
            }
        }

        // Si ningún archivo es válido, lanza un error 404
        abort(404, 'No se encontró ningún archivo válido.');
    }



    public function eliminardocumento($helpId)
{
    // Encuentra todos los archivos relacionados con el modelo de 'help'
    $media = Medium::where('model_id', $helpId)->get();

    if ($media->isEmpty()) {
        // Si no se encuentra ningún archivo relacionado, muestra un mensaje de error
        session()->flash('error', 'No se encontraron documentos relacionados.');
        return back(); // Regresa a la misma página
    }

    // Itera sobre los archivos y elimina el primero que exista
    foreach ($media as $medium) {
        // Construye la ruta del archivo
        $filePath = public_path("media/{$medium->id}/{$medium->file_name}");

        if (file_exists($filePath)) {
            // Elimina el archivo físico
            unlink($filePath);

            // Elimina el registro de la base de datos
            $medium->delete();
        }
    }

    // Después de eliminar, muestra un mensaje de éxito
    session()->flash('success', 'El documento ha sido eliminado exitosamente.');
    return back(); // Regresa a la misma página
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
            // Condicional basado en el estado del ticket
            if ($help->statuses->state->id == 4) {
                return [
                    'redirect' => url('admin/helps/finalizadas'),
                    'ticket' => $help['id'],
                    'showTicketModal' => true // Indicador para mostrar el modal
                ];
            } else {
                return [
                    'redirect' => url('admin/helps/'),
                    'ticket' => $help['id'],
                    'showTicketModal' => true // Indicador para mostrar el modal
                ];
            }
        }

        return redirect('admin/helps');
    }


    public function guardarSolicitud(UpdateHelp $request, Help $help)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Si el archivo se ha cargado, asociarlo con el modelo Help
        if ($request->hasFile('media')) { // 'media' es el nombre del campo en el formulario
            $help->addMediaFromRequest('media')
                 ->toMediaCollection('gallery');
        }

        // Actualiza los valores cambiados
        $help->update($sanitized);

        // Redirige directamente a /home
        return ['redirect' => '/', 'showTicketModal' => false];

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

    public function api($ci = null)
{
    if ($ci) {
        $x = RHM006::select('FuncNombr', 'FuncApell', 'FunFecNac')
            ->where('FuncEst', 'A')
            ->where('FuncNro', $ci)
            ->orderBy('FunFecNac')
            ->first();

        // Eliminar los espacios en blanco de los campos FuncNombr y FuncApell
        $x->FuncNombr = trim($x->FuncNombr);
        $x->FuncApell = trim($x->FuncApell);
    } else {
        $x = RHM006::select('FuncNombr', 'FuncApell', 'FunFecNac')
            ->where('FuncEst', 'A')
            ->orderBy('FunFecNac')
            ->get();

        // Eliminar los espacios en blanco de los campos FuncNombr y FuncApell en cada registro
        $x->transform(function ($item) {
            $item->FuncNombr = trim($item->FuncNombr);
            $item->FuncApell = trim($item->FuncApell);
            return $item;
        });
    }

    return response()->json($x);
}

public function documento($id)
    {
        $help = Help::findOrFail($id); // Busca el 'help' específico
        return view('admin.help.createdocument', compact('help'));
    }

    // Método para manejar la carga del archivo
    public function storeDocument(Request $request, $id)
    {
        $help = Help::findOrFail($id); // Asegúrate de que el 'help' exista

        // Verificar que el archivo esté presente
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('help_documents'); // Guarda el archivo en el directorio de documentos

            // Asocia el archivo al modelo Help (si estás usando media)
            $help->addMedia($file)->toMediaCollection('gallery'); // Guarda en la colección de medios

            // Puedes devolver una respuesta de éxito o redirigir
            return response()->json(['message' => 'Documento adjuntado con éxito.'], 200);
        }

        return response()->json(['message' => 'No se adjuntó ningún documento.'], 400);
    }
}
