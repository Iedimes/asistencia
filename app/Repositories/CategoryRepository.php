<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Obtener todas las categorias.
     */
    public function all(array $columns = ['*']): Collection
    {
        return Category::all($columns);
    }

    /**
     * Buscar una categoria por ID.
     */
    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Crear una nueva categoria.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Actualizar una categoria existente.
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }

    /**
     * Eliminar una categoria por instancia.
     */
    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }

    /**
     * Eliminar masivamente categorias por IDs.
     */
    public function bulkDelete(array $ids): int
    {
        return Category::whereIn('id', $ids)->delete();
    }
}
