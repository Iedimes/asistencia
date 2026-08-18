<?php

namespace App\Services;

use App\Models\Help;
use App\Repositories\HelpRepository;

class HelpService
{
    private HelpRepository $repository;

    public function __construct(HelpRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Registrar un nuevo ticket de ayuda.
     */
    public function registerTicket(array $data, ?array $initialDetail = null): Help
    {
        $help = $this->repository->createHelp($data);

        if ($initialDetail) {
            $initialDetail['help_id'] = $help->id;
            $this->repository->createDetailHelp($initialDetail);
        }

        return $help;
    }

    /**
     * Buscar persona por cedula en RRHH o Seguridad.
     */
    public function lookupPersonByCedula(string $ced): array
    {
        // 1. Buscar en RRHH (RHM006 / Funcionario)
        $ci = $this->repository->findPersonInRrhh($ced);

        if ($ci) {
            $dpto = $ci->dpto;
            return [
                'error'  => false,
                'cedula' => [
                    'FuncNom' => is_string($ci->FuncNom) ? trim($ci->FuncNom) : ($ci->FuncNom ?? ''),
                    'FUsuCod' => is_string($ci->FUsuCod) ? trim($ci->FUsuCod) : ($ci->FUsuCod ?? ''),
                    'dpto'    => [
                        'DepenDes' => $dpto ? (string) $dpto->DepenDes : '',
                        'DepenCod' => $dpto ? (string) $dpto->DepenCod : '',
                    ],
                ]
            ];
        }

        // 2. Buscar en SEGURIDAD (Usuario)
        $usuario = $this->repository->findPersonInUsuario($ced);

        if ($usuario) {
            $dpto = $usuario->dpto;
            return [
                'error'  => false,
                'cedula' => [
                    'FuncNom' => is_string($usuario->UsuNombre) ? trim($usuario->UsuNombre) : ($usuario->UsuNombre ?? ''),
                    'FUsuCod' => is_string($usuario->UsuCod) ? trim($usuario->UsuCod) : ($usuario->UsuCod ?? ''),
                    'dpto'    => [
                        'DepenDes' => $dpto ? (string) $dpto->DepenDes : '',
                        'DepenCod' => $dpto ? (string) $dpto->DepenCod : '',
                    ],
                ]
            ];
        }

        // 3. No encontrado
        return [
            'error'   => true,
            'message' => 'Cédula no se encuentra en ninguna tabla',
        ];
    }

    /**
     * Actualizar ticket de ayuda.
     */
    public function updateTicket(Help $help, array $data): Help
    {
        return $this->repository->updateHelp($help, $data);
    }

    /**
     * Eliminar un ticket.
     */
    public function deleteTicket(Help $help): bool
    {
        return $this->repository->deleteHelp($help);
    }

    /**
     * Eliminar masivamente tickets por IDs.
     */
    public function bulkDeleteTickets(array $ids): int
    {
        return $this->repository->bulkDeleteHelps($ids);
    }

    /**
     * Eliminar adjunto relacionado a un ticket.
     */
    public function deleteDocument(int $helpId): int
    {
        return $this->repository->deleteMediaForHelp($helpId);
    }
}
