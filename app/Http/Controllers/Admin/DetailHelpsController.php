<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DetailHelp\BulkDestroyDetailHelp;
use App\Http\Requests\Admin\DetailHelp\DestroyDetailHelp;
use App\Http\Requests\Admin\DetailHelp\IndexDetailHelp;
use App\Http\Requests\Admin\DetailHelp\StoreDetailHelp;
use App\Http\Requests\Admin\DetailHelp\UpdateDetailHelp;
use App\Models\DetailHelp;
use App\Models\State;
use App\Models\Category;
use App\Models\AdminUser;
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

class DetailHelpsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDetailHelp $request
     * @return array|Factory|View
     */
    public function index(IndexDetailHelp $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(DetailHelp::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'help_id', 'user_id', 'state_id', 'solution', 'date', 'category_id', 'patrimony'],

            // set columns to searchIn
            ['id', 'solution']
        );


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.detail-help.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.detail-help.create');

        $state = State::all();
        $category = Category::all();
        $user = AdminUser::all();



        return view('admin.detail-help.create', compact('state', 'category', 'user'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDetailHelp $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDetailHelp $request)
    {
        // Sanitize input
        //return $request;
        $sanitized = $request->getSanitized();
        $sanitized ['state_id']=  $request->getStateId();
        $sanitized ['category_id']=  $request->getCategoryId();
        $sanitized ['user_id']=  $request->getUserId();
        //return $sanitized;
        // Store the DetailHelp
        $detailHelp = DetailHelp::create($sanitized);



        if ($request->ajax()) {
            return ['redirect' => url('admin/helps/'.$request->help_id.'/show'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/detail-helps');
    }

    /**
     * Display the specified resource.
     *
     * @param DetailHelp $detailHelp
     * @throws AuthorizationException
     * @return void
     */
    public function show(DetailHelp $detailHelp)
    {
        $this->authorize('admin.detail-help.show', $detailHelp);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DetailHelp $detailHelp
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(DetailHelp $detailHelp)
    {
        $this->authorize('admin.detail-help.edit', $detailHelp);

        $state = State::all();
        $category = Category::all();
        $user = AdminUser::all();
        return view('admin.detail-help.edit', [
            'detailHelp' => $detailHelp,
            'state' => $state,
            'category' => $category,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDetailHelp $request
     * @param DetailHelp $detailHelp
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDetailHelp $request, DetailHelp $detailHelp)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized ['state_id']=  $request->getStateId();
        $sanitized ['category_id']=  $request->getCategoryId();
        $sanitized ['user_id']=  $request->getUserId();

        // Update changed values DetailHelp
        $detailHelp->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/helps/'.$request->help_id.'/show'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/detail-helps');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDetailHelp $request
     * @param DetailHelp $detailHelp
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDetailHelp $request, DetailHelp $detailHelp)
    {
        $detailHelp->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDetailHelp $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDetailHelp $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DetailHelp::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
