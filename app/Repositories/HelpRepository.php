<?php

namespace App\Repositories;

use App\Models\DetailHelp;
use App\Models\Funcionario;
use App\Models\Help;
use App\Models\Medium;
use App\Models\Usuario;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HelpRepository
{
    /**
     * Buscar un ticket por ID.
     */
    public function find(int $id): ?Help
    {
        return Help::find($id);
    }

    /**
     * Buscar un ticket por ID o fallar.
     */
    public function findOrFail(int $id): Help
    {
        return Help::findOrFail($id);
    }

    /**
     * Crear un nuevo ticket (Help).
     */
    public function createHelp(array $data): Help
    {
        return Help::create($data);
    }

    /**
     * Actualizar un ticket (Help).
     */
    public function updateHelp(Help $help, array $data): Help
    {
        $help->update($data);
        return $help->fresh();
    }

    /**
     * Eliminar un ticket.
     */
    public function deleteHelp(Help $help): bool
    {
        return (bool) $help->delete();
    }

    /**
     * Eliminar masivamente tickets por IDs.
     */
    public function bulkDeleteHelps(array $ids): int
    {
        return Help::whereIn('id', $ids)->delete();
    }

    /**
     * Crear un registro de detalle/historial (DetailHelp).
     */
    public function createDetailHelp(array $data): DetailHelp
    {
        return DetailHelp::create($data);
    }

    /**
     * Buscar funcionario en RRHH por cedula.
     */
    public function findPersonInRrhh(string $cedula)
    {
        return Funcionario::with('dpto')
            ->where('FuncNro', $cedula)
            ->where('FuncEst', 'A')
            ->first();
    }

    /**
     * Buscar usuario en Seguridad por cedula.
     */
    public function findPersonInUsuario(string $cedula)
    {
        return Usuario::with('dpto')
            ->where('UsuCed', $cedula)
            ->where('Usuest', 'A')
            ->first();
    }

    /**
     * Buscar y eliminar adjuntos de un ticket por ID de modelo.
     */
    public function deleteMediaForHelp(int $helpId): int
    {
        $media = Medium::where('model_id', $helpId)->get();
        $count = 0;
        foreach ($media as $medium) {
            $filePath = public_path("media/{$medium->id}/{$medium->file_name}");
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $medium->delete();
            $count++;
        }
        return $count;
    }
}
