<?php

namespace App\Services;

use App\Http\Requests\Admin\Funcionario\IndexFuncionario;
use App\Models\Funcionario;
use App\Repositories\FuncionarioRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FuncionarioService
{
    private FuncionarioRepository $repository;

    public function __construct(FuncionarioRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Buscar y paginar funcionarios combinando RRHH y SEGURIDAD.
     */
    public function searchAndPaginate(IndexFuncionario $request): LengthAwarePaginator
    {
        $search = $request->input('search');

        if ($search) {
            $rrhh = $this->repository->searchRrhh($search)->map(function ($item) {
                return [
                    'FuncNro' => $item->FuncNro,
                    'FuncNom' => trim($item->FuncNom),
                    'FUsuCod' => trim($item->FUsuCod),
                    'Origen'  => 'RRHH',
                ];
            });

            $seguridad = $this->repository->searchSeguridad($search)->map(function ($item) {
                return [
                    'FuncNro' => trim($item->UsuCed),
                    'FuncNom' => trim($item->UsuNombre),
                    'FUsuCod' => trim($item->UsuCod),
                    'Origen'  => 'SEGURIDAD',
                ];
            });
        } else {
            $rrhh = $this->repository->allRrhh()->map(function ($item) {
                return [
                    'FuncNro' => $item->FuncNro,
                    'FuncNom' => trim($item->FuncNom),
                    'FUsuCod' => trim($item->FUsuCod),
                    'Origen'  => 'RRHH',
                ];
            });

            $seguridad = collect();
        }

        $merged = collect($rrhh)->merge($seguridad)->values();

        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 10);
        $total = $merged->count();
        $results = $merged->forPage($page, $perPage)->values();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);
    }

    /**
     * Crear un nuevo funcionario.
     */
    public function createFuncionario(array $data): Funcionario
    {
        return $this->repository->create($data);
    }

    /**
     * Actualizar un funcionario.
     */
    public function updateFuncionario(Funcionario $funcionario, array $data): Funcionario
    {
        return $this->repository->update($funcionario, $data);
    }

    /**
     * Eliminar un funcionario.
     */
    public function deleteFuncionario(Funcionario $funcionario): bool
    {
        return $this->repository->delete($funcionario);
    }

    /**
     * Eliminar masivamente funcionarios por IDs.
     */
    public function bulkDeleteFuncionarios(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }
}
