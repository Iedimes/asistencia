<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    // Subquery sin ejecutar
    $detalleQuery = DetailHelp::select('help_id')
        ->whereIn('state_id', [1, 2])
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        });

    // Obtener solo id + created_at (sin relaciones innecesarias)
    $ordersBeingAttended = Help::whereIn('id', $detalleQuery)
        ->select('id', 'created_at')
        ->without(['statuses', 'tecnico', 'detailsHelps', 'documento'])
        ->orderByRaw('(SELECT MAX(updated_at) FROM detail_helps WHERE help_id = helps.id AND state_id IN (1, 2)) asc')
        ->limit(10)
        ->get()
        ->map(function ($order, $index) {
            $order->position = $index + 1;
            return $order;
        });

    return view('admin.help.create', compact('ordersBeingAttended'));
}

public function fetchOrders()
{
    $detalleQuery = DetailHelp::select('help_id')
        ->whereIn('state_id', [1, 2])
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
        ->limit(10)
        ->get()
        ->values()
        ->map(function ($order, $index) {
            $order->position = $index + 1;
            return $order;
        });

    return response()->json(['orders' => $ordersBeingAttended]);
}

public function consulta(IndexHelp $request)
{
    // Subquery sin ejecutar
    $detalleQuery = DetailHelp::select('help_id')
        ->whereIn('state_id', [1, 2])
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('detail_helps as dh2')
                ->whereRaw('detail_helps.help_id = dh2.help_id')
                ->whereRaw('detail_helps.created_at < dh2.created_at');
        });

    // Obtener solo id para la cola (sin relaciones)
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

    // Mapa posición por id para lookup O(1)
    $positionMap = $ordersBeingAttended->pluck('position', 'id');

    $ci = $request->search;
    if ($ci) {
        $data = AdminListing::create(Help::class)->processRequestAndGet(
            $request,
            ['id', 'ci', 'name', 'user', 'dependency', 'fone', 'problem'],
            ['ci', 'id'],
            function ($query) use ($ci, $detalleQuery) {
                $query->whereIn('helps.id', $detalleQuery)
                      ->where(function ($q) use ($ci) {
                          $q->where('helps.ci', '=', $ci)
                            ->orWhere('helps.id', '=', $ci);
                      });
            }
        );

        // Asignar posición usando el mapa (O(1) por ticket)
        foreach ($data as $ticket) {
            $ticket->position = $positionMap[$ticket->id] ?? null;
        }
    } else {
        $ci = '-1';
        $data = collect([]);
    }

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
