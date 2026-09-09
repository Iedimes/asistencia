<?php

namespace App\Services;

use App\Models\AdminUser;
use App\Models\State;
use App\Repositories\ReporteRepository;
use Carbon\Carbon;
use Exception;

class ReporteService
{
    protected $repository;

    public function __construct(ReporteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Procesar la consulta de reportes y estructurar los datos y metadatos del informe.
     *
     * @param array $data
     * @return array [$dhelps, $contar, $filtros]
     * @throws Exception
     */
    public function generateReport(array $data): array
    {
        $inicioRaw = $data['inicio'] ?? null;
        $finRaw    = $data['fin'] ?? null;

        if (!$inicioRaw || !$finRaw) {
            throw new Exception('Las fechas de inicio y fin son obligatorias.');
        }

        $userId  = (int) ($data['user_id'] ?? 0);
        $stateId = (int) ($data['state_id'] ?? 0);

        // Obtener colección desde la capa Repository
        $dhelps = $this->repository->getReportData($inicioRaw, $finRaw, $userId, $stateId);

        // Mapear nombres para visualización
        $userName = 'TODOS LOS TÉCNICOS';
        if ($userId > 0) {
            $u = AdminUser::find($userId);
            if ($u) {
                $userName = trim($u->first_name . ' ' . $u->last_name);
            }
        }

        $stateName = 'TODOS LOS ESTADOS';
        if ($stateId > 0) {
            $s = State::find($stateId);
            if ($s) {
                $stateName = mb_strtoupper($s->name, 'UTF-8');
            }
        }

        $inicioDisplay = Carbon::parse($inicioRaw)->format('d/m/Y');
        $finDisplay    = Carbon::parse($finRaw)->format('d/m/Y');

        $filtros = [
            'inicio'     => $inicioDisplay,
            'fin'        => $finDisplay,
            'inicio_raw' => $inicioRaw,
            'fin_raw'    => $finRaw,
            'user_id'    => $userId,
            'state_id'   => $stateId,
            'user_name'  => $userName,
            'state_name' => $stateName,
        ];

        return [$dhelps, $dhelps->count(), $filtros];
    }
}
