<?php

namespace App\Repositories;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

class StateRepository
{
    /**
     * Obtener todos los estados.
     */
    public function all(array $columns = ['*']): Collection
    {
        return State::all($columns);
    }

    /**
     * Buscar un estado por ID.
     */
    public function find(int $id): ?State
    {
        return State::find($id);
    }

    /**
     * Crear un nuevo estado.
     */
    public function create(array $data): State
    {
        return State::create($data);
    }

    /**
     * Actualizar un estado existente.
     */
    public function update(State $state, array $data): State
    {
        $state->update($data);
        return $state->fresh();
    }

    /**
     * Eliminar un estado por instancia.
     */
    public function delete(State $state): bool
    {
        return (bool) $state->delete();
    }

    /**
     * Eliminar masivamente estados por IDs.
     */
    public function bulkDelete(array $ids): int
    {
        return State::whereIn('id', $ids)->delete();
    }
}
