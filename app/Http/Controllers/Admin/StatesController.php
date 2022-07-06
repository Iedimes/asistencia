<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\BulkDestroyState;
use App\Http\Requests\Admin\State\DestroyState;
use App\Http\Requests\Admin\State\IndexState;
use App\Http\Requests\Admin\State\StoreState;
use App\Http\Requests\Admin\State\UpdateState;
use App\Models\State;
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

class StatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexState $request
     * @return array|Factory|View
     */
    public function index(IndexState $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(State::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.state.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.state.create');

        return view('admin.state.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreState $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreState $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the State
        $state = State::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/states'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/states');
    }

    /**
     * Display the specified resource.
     *
     * @param State $state
     * @throws AuthorizationException
     * @return void
     */
    public function show(State $state)
    {
        $this->authorize('admin.state.show', $state);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param State $state
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(State $state)
    {
        $this->authorize('admin.state.edit', $state);


        return view('admin.state.edit', [
            'state' => $state,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateState $request
     * @param State $state
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateState $request, State $state)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values State
        $state->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/states'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/states');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyState $request
     * @param State $state
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyState $request, State $state)
    {
        $state->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyState $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyState $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    State::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
