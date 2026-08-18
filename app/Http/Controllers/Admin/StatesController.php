<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\BulkDestroyState;
use App\Http\Requests\Admin\State\DestroyState;
use App\Http\Requests\Admin\State\IndexState;
use App\Http\Requests\Admin\State\StoreState;
use App\Http\Requests\Admin\State\UpdateState;
use App\Models\State;
use App\Services\StateService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class StatesController extends Controller
{
    private StateService $service;

    public function __construct(StateService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexState $request
     * @return array|Factory|View
     */
    public function index(IndexState $request)
    {
        $data = $this->service->listStates($request);

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
        $sanitized = $request->getSanitized();

        $this->service->createState($sanitized);

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
        $sanitized = $request->getSanitized();

        $this->service->updateState($state, $sanitized);

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
        $this->service->deleteState($state);

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
    public function bulkDestroy(BulkDestroyState $request): Response
    {
        $this->service->bulkDeleteStates($request->data['ids']);

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
