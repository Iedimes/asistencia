<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Funcionario\BulkDestroyFuncionario;
use App\Http\Requests\Admin\Funcionario\DestroyFuncionario;
use App\Http\Requests\Admin\Funcionario\IndexFuncionario;
use App\Http\Requests\Admin\Funcionario\StoreFuncionario;
use App\Http\Requests\Admin\Funcionario\UpdateFuncionario;
use App\Models\Funcionario;
use App\Services\FuncionarioService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class FuncionariosController extends Controller
{
    private FuncionarioService $service;

    public function __construct(FuncionarioService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexFuncionario $request
     * @return array|Factory|View
     */
    public function index(IndexFuncionario $request)
    {
        $data = $this->service->searchAndPaginate($request);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return ['bulkItems' => $data->pluck('FuncNro')];
            }
            return ['data' => $data];
        }

        return view('admin.funcionario.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.funcionario.create');

        return view('admin.funcionario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFuncionario $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFuncionario $request)
    {
        $sanitized = $request->getSanitized();

        $this->service->createFuncionario($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/funcionarios'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/funcionarios');
    }

    /**
     * Display the specified resource.
     *
     * @param Funcionario $funcionario
     * @throws AuthorizationException
     * @return void
     */
    public function show(Funcionario $funcionario)
    {
        $this->authorize('admin.funcionario.show', $funcionario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Funcionario $funcionario
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Funcionario $funcionario)
    {
        $this->authorize('admin.funcionario.edit', $funcionario);

        return view('admin.funcionario.edit', [
            'funcionario' => $funcionario,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFuncionario $request
     * @param Funcionario $funcionario
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFuncionario $request, Funcionario $funcionario)
    {
        $sanitized = $request->getSanitized();

        $this->service->updateFuncionario($funcionario, $sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/funcionarios'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/funcionarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFuncionario $request
     * @param Funcionario $funcionario
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyFuncionario $request, Funcionario $funcionario)
    {
        $this->service->deleteFuncionario($funcionario);

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFuncionario $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyFuncionario $request): Response
    {
        $this->service->bulkDeleteFuncionarios($request->data['ids']);

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
