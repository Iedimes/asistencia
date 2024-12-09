<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Subsidio;
use App\Models\City;
use App\Models\Mh;
use App\Models\Visit;
use App\Http\Requests\Admin\Visit\IndexVisit;
use App\Models\MediaDocument;
use App\Models\EducationLevel;
use App\Models\DocumentType;
use App\Models\ApplicantDocument;
use App\Models\ApplicantStatus;
use App\Models\ContactMethod;
use App\Models\ApplicantContactMethod;
use App\Http\Requests\StoreApplicantUser;
use App\Http\Requests\StoreApplicantUserDocument;
use App\Http\Requests\StoreApplicantUserConyuge;
use App\Http\Requests\UpdateApplicantUserConyuge;
use App\Http\Requests\UpdateApplicantUser;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Help\IndexHelp;
use App\Models\Help;
use App\Models\DetailHelp;
use Illuminate\Support\Facades\DB;

use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;


use Brackets\AdminListing\Facades\AdminListing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
{
    // Consulta de los IDs de las ayudas que cumplen con el estado 2
    $detalleIds = DetailHelp::select('help_id')
        ->where('state_id', '=', 2) // Filtrar por estado '2'
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->pluck('help_id'); // Extraer los IDs como una colección

    // Obtener las órdenes filtradas por los detalles con estado 2
    $ordersBeingAttended = Help::whereIn('id', $detalleIds) // Filtrar solo los IDs válidos
        ->with(['detailsHelps' => function ($query) {
            $query->orderBy('updated_at', 'asc'); // Ordenar por la fecha de actualización ascendente
        }])
        ->orderByRaw('(SELECT MAX(updated_at) FROM detail_helps WHERE help_id = helps.id AND state_id = 2) asc') // Ordenar por la fecha de actualización del detalle donde el estado es 2
        ->limit(10) // Limitar a las 5 órdenes más recientes
        ->get();

    // Asignar la posición de atención a cada orden
    $ordersBeingAttended = $ordersBeingAttended->map(function ($order, $index) {
        $order->position = $index + 1; // La posición es el índice + 1
        return $order;
    });

    // Retornar la vista con los datos obtenidos
    return view('admin.help.create', compact('ordersBeingAttended'));
}

public function fetchOrders()
{
    // Reutilizar la lógica de obtención de órdenes
    $detalleIds = DetailHelp::select('help_id')
        ->where('state_id', '=', 2)
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->pluck('help_id');

    $ordersBeingAttended = Help::whereIn('id', $detalleIds)
        ->with(['detailsHelps'])
        ->orderByRaw('(SELECT MAX(updated_at) FROM detail_helps WHERE help_id = helps.id AND state_id = 2) asc')
        ->limit(10) // Limitar a las 10 órdenes más recientes
        ->get();

    // Asignar la posición de atención a cada orden
    $ordersBeingAttended = $ordersBeingAttended->map(function ($order, $index) {
        $order->position = $index + 1;
        return $order;
    });

    return response()->json(['orders' => $ordersBeingAttended]);
}

    public function consulta(IndexHelp $request)
    {
        // Consulta de los IDs de las ayudas que cumplen con el estado 2
        $detalleIds = DetailHelp::select('help_id')
            ->where('state_id', '=', 2) // Filtrar por estado '2'
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('detail_helps as dh2')
                    ->whereRaw('detail_helps.help_id = dh2.help_id')
                    ->whereRaw('detail_helps.created_at < dh2.created_at');
            })
            ->pluck('help_id'); // Extraer los IDs como una colección

        // Obtener las órdenes filtradas por los detalles con estado 2
        $ordersBeingAttended = Help::whereIn('id', $detalleIds) // Filtrar solo los IDs válidos
            ->with(['detailsHelps' => function ($query) {
                $query->orderBy('updated_at', 'asc'); // Ordenar por la fecha de actualización ascendente
            }])
            ->orderByRaw('(SELECT MAX(updated_at) FROM detail_helps WHERE help_id = helps.id AND state_id = 2) asc') // Ordenar por la fecha de actualización del detalle donde el estado es 2
            // ->limit(15) // Limitar a las 5 órdenes más recientes
            ->get();

        // // Asignar la posición de atención a cada orden
        // $ordersBeingAttended = $ordersBeingAttended->map(function ($order, $index) {
        //     $order->position = $index + 1; // La posición es el índice + 1
        //     return $order;
        // });

        // Obtener el valor de `search` que es el CI o ID
        $ci = $request->search;

        // Consulta adicional si hay búsqueda por CI o ID
        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            ['ci', 'id'],
            function ($query) use ($ci, $detalleIds) {
                $query->whereIn('helps.id', $detalleIds) // Filtrar por los IDs válidos
                      ->where(function ($q) use ($ci) {
                          $q->where('helps.ci', '=', $ci)
                            ->orWhere('helps.id', '=', $ci); // Buscar por CI o ID
                      });
            }
        );

        // Si la solicitud es AJAX, retornar los datos en el formato esperado
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            if (!$request->search) {
                $ci = '-1';
                $data = AdminListing::create(Help::class)->processRequestAndGet(
                    $request,
                    ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
                    ['ci'],
                    function ($query) use ($ci, $detalleIds) {
                        $query->whereIn('helps.id', $detalleIds) // Filtrar por los IDs válidos
                              ->where('helps.ci', '=', $ci);
                    }
                );
            }

            return ['data' => $data];
        }

        // Retornar la vista con los datos obtenidos
        return view('admin.help.detalle', compact('data', 'ordersBeingAttended'));
    }






//   public function index(Request $request)
//     {
//         // create and AdminListing instance for a specific model and
//         $data = AdminListing::create(Mh::class)->processRequestAndGet(
//             // pass the request with params
//             $request,

//             // set columns to query
//             ['id', 'codigo', 'proyecto', 'documento', 'adjudicatario', 'fecha_ins', 'institucion_acreedora', 'obs', 'fecha_reins'],

//             // set columns to searchIn
//             ['codigo', 'proyecto', 'documento', 'adjudicatario', 'fecha_ins', 'institucion_acreedora', 'obs', 'fecha_reins']
//         );

//         if ($request->ajax()) {
//             if ($request->has('bulk')) {
//                 return [
//                     'bulkItems' => $data->pluck('id')
//                 ];
//             }
//             return ['data' => $data];
//         }

//         return view('formulario.mh.index', ['data' => $data]);

//     }




}
