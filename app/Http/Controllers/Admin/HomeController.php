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
use App\Models\AdminUser;
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
    // Verificar si el administrador está autenticado
    if (!Auth::guard('admin')->check()) {
        // Buscar el administrador con ID 30
        $admin = AdminUser::find(30);

        // Si el administrador existe, iniciar sesión automáticamente
        if ($admin) {
            Auth::guard('admin')->login($admin);
        }
    }

    // Consulta de los IDs de las ayudas que cumplen con el estado 1 o 2
    $detalleIds = DetailHelp::select('help_id')
        ->whereIn('state_id', [1, 2]) // Filtrar por los estados 1 y 2
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->pluck('help_id'); // Extraer los IDs como una colección

    // Obtener las órdenes filtradas por los detalles con estado 1 o 2
    $ordersBeingAttended = Help::whereIn('id', $detalleIds) // Filtrar solo los IDs válidos
        ->with(['detailsHelps' => function ($query) {
            $query->orderBy('updated_at', 'asc'); // Ordenar los detalles por fecha de actualización ascendente
        }])
        ->orderByRaw('(SELECT MAX(updated_at) FROM detail_helps WHERE help_id = helps.id AND state_id IN (1, 2)) asc') // Ordenar por la fecha de actualización del detalle donde el estado es 1 o 2
        ->limit(10) // Limitar a las 10 órdenes más recientes
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
    ->whereIn('state_id', [1, 2]) // Filtrar por los estados 1 y 2
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        })
        ->pluck('help_id');


    $ordersBeingAttended = Help::whereIn('id', $detalleIds)
        ->with(['detailsHelps']) // Incluye los detalles relacionados
        ->orderBy('created_at', 'asc') // Ordenar por la fecha más vieja de la cabecera
        ->limit(10)
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

    // Si hay un parámetro de búsqueda por CI o ID
    $ci = $request->search;
    if ($ci) {
        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            ['ci', 'id'],
            function ($query) use ($ci, $detalleIds) {
                $query->whereIn('helps.id', $detalleIds)
                      ->where(function ($q) use ($ci) {
                          $q->where('helps.ci', '=', $ci)
                            ->orWhere('helps.id', '=', $ci);
                      });
            }
        );

        // Encontrar la posición del ticket en la cola
        foreach ($data as $ticket) {
            $ticket->position = $ordersBeingAttended->where('id', $ticket->id)->first()->position ?? null;
        }
    } else {
        $ci = '-1';
        $data = collect([]);
    }

    // Retornar los datos con la posición
    if ($request->ajax()) {
        return response()->json([
            'orders' => $ordersBeingAttended,
            'data' => $data
        ]);
    }

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
