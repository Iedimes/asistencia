<?php

namespace App\Repositories;

use App\Models\Funcionario;
use App\Models\Usuario;
use Illuminate\Support\Collection;

class FuncionarioRepository
{
    /**
     * Buscar funcionarios en RRHH (RHM006 / sqlsrv o pgsql).
     */
    public function searchRrhh(string $search): Collection
    {
        if (is_numeric($search)) {
            return Funcionario::where('FuncEst', 'A')
                ->where('FuncNro', $search)
                ->get();
        }

        $words = array_filter(explode(' ', trim($search)));

        return Funcionario::where('FuncEst', 'A')
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('FuncNom', 'like', "%{$word}%")
                          ->orWhere('FUsuCod', 'like', "%{$word}%");
                }
            })
            ->get();
    }

    /**
     * Buscar usuarios en SEGURIDAD (Usuario).
     */
    public function searchSeguridad(string $search): Collection
    {
        if (is_numeric($search)) {
            return Usuario::where('Usuest', 'A')
                ->where('UsuCed', $search)
                ->get();
        }

        $words = array_filter(explode(' ', trim($search)));

        return Usuario::where('Usuest', 'A')
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('UsuNombre', 'like', "%{$word}%")
                          ->orWhere('UsuCod', 'like', "%{$word}%");
                }
            })
            ->get();
    }

    /**
     * Obtener listado por defecto de RRHH.
     */
    public function allRrhh(): Collection
    {
        return Funcionario::where('FuncEst', 'A')
            ->where('FuncNro', '>', 99)
            ->orderBy('FuncNom')
            ->get();
    }

    /**
     * Buscar un funcionario por su clave primaria.
     */
    public function find($id): ?Funcionario
    {
        return Funcionario::find($id);
    }

    /**
     * Crear un nuevo funcionario.
     */
    public function create(array $data): Funcionario
    {
        return Funcionario::create($data);
    }

    /**
     * Actualizar un funcionario.
     */
    public function update(Funcionario $funcionario, array $data): Funcionario
    {
        $funcionario->update($data);
        return $funcionario->fresh();
    }

    /**
     * Eliminar un funcionario.
     */
    public function delete(Funcionario $funcionario): bool
    {
        return (bool) $funcionario->delete();
    }

    /**
     * Eliminar masivamente funcionarios por IDs.
     */
    public function bulkDelete(array $ids): int
    {
        return Funcionario::whereIn('FuncNro', $ids)->delete();
    }
}
