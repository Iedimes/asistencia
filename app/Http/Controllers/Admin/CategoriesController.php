<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\BulkDestroyCategory;
use App\Http\Requests\Admin\Category\DestroyCategory;
use App\Http\Requests\Admin\Category\IndexCategory;
use App\Http\Requests\Admin\Category\StoreCategory;
use App\Http\Requests\Admin\Category\UpdateCategory;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    private CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCategory $request
     * @return array|Factory|View
     */
    public function index(IndexCategory $request)
    {
        $data = $this->service->listCategories($request);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.category.create');

        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategory $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCategory $request)
    {
        $sanitized = $request->getSanitized();

        $this->service->createCategory($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/categories'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @throws AuthorizationException
     * @return void
     */
    public function show(Category $category)
    {
        $this->authorize('admin.category.show', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Category $category)
    {
        $this->authorize('admin.category.edit', $category);

        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategory $request
     * @param Category $category
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCategory $request, Category $category)
    {
        $sanitized = $request->getSanitized();

        $this->service->updateCategory($category, $sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/categories'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCategory $request
     * @param Category $category
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCategory $request, Category $category)
    {
        $this->service->deleteCategory($category);

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCategory $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCategory $request): Response
    {
        $this->service->bulkDeleteCategories($request->data['ids']);

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
