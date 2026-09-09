<?php

namespace App\Services;

use App\Http\Requests\Admin\State\IndexState;
use App\Models\State;
use App\Repositories\StateRepository;
use Brackets\AdminListing\Facades\AdminListing;

class StateService
{
    private StateRepository $repository;

    public function __construct(StateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Procesar listado paginado/busqueda para Craftable AdminListing.
     */
    public function listStates(IndexState $request)
    {
        return AdminListing::create(State::class)->processRequestAndGet(
            $request,
            ['id', 'name'],
            ['id', 'name']
        );
    }

    /**
     * Crear un estado.
     */
    public function createState(array $data): State
    {
        return $this->repository->create($data);
    }

    /**
     * Actualizar un estado.
     */
    public function updateState(State $state, array $data): State
    {
        return $this->repository->update($state, $data);
    }

    /**
     * Eliminar un estado.
     */
    public function deleteState(State $state): bool
    {
        return $this->repository->delete($state);
    }

    /**
     * Eliminar masivamente estados por IDs.
     */
    public function bulkDeleteStates(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }
}
