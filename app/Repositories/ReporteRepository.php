<?php

namespace App\Repositories;

use App\Models\DetailHelp;
use Carbon\Carbon;

class ReporteRepository
{
    /**
     * Obtener registros de DetailHelp filtrados por rango de fechas, técnico y estado.
     *
     * @param string $inicio
     * @param string $fin
     * @param int $userId
     * @param int $stateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReportData(string $inicio, string $fin, int $userId = 0, int $stateId = 0)
    {
        $inicioCarbon = Carbon::parse($inicio)->startOfDay()->toDateTimeString();
        $finCarbon    = Carbon::parse($fin)->endOfDay()->toDateTimeString();

        $query = DetailHelp::whereBetween('created_at', [$inicioCarbon, $finCarbon]);

        if ($userId > 0) {
            $query->where('user_id', $userId);
        } else {
            // Al seleccionar "TODOS LOS TÉCNICOS", se excluye user_id = 1 que corresponde a 'N/A' (Estado inicial sin asignar)
            $query->where('user_id', '!=', 1);
        }

        if ($stateId > 0) {
            $query->where('state_id', $stateId);
        }

        return $query->with(['user', 'state', 'help'])
                    ->orderBy('user_id', 'ASC')
                    ->orderBy('help_id', 'ASC')
                    ->get();
    }
}
