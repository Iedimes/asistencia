<?php

namespace App\Services;

use App\Http\Requests\Admin\Category\IndexCategory;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Brackets\AdminListing\Facades\AdminListing;

class CategoryService
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Procesar listado paginado/busqueda para Craftable AdminListing.
     */
    public function listCategories(IndexCategory $request)
    {
        return AdminListing::create(Category::class)->processRequestAndGet(
            $request,
            ['id', 'name'],
            ['id', 'name']
        );
    }

    /**
     * Crear una categoria.
     */
    public function createCategory(array $data): Category
    {
        return $this->repository->create($data);
    }

    /**
     * Actualizar una categoria.
     */
    public function updateCategory(Category $category, array $data): Category
    {
        return $this->repository->update($category, $data);
    }

    /**
     * Eliminar una categoria.
     */
    public function deleteCategory(Category $category): bool
    {
        return $this->repository->delete($category);
    }

    /**
     * Eliminar masivamente categorias por IDs.
     */
    public function bulkDeleteCategories(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }
}
