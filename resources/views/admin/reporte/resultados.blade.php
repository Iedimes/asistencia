@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Resultados del Reporte')

@section('body')

<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <div class="row justify-content-center">
        <div class="col-12 mb-4">
            <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                
                <!-- Encabezado Principal con Degradado Moderno -->
                <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center gap-3">
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">RESULTADOS DE ASISTENCIAS TÉCNICAS</h4>
                        <span class="badge bg-info rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">INFORME / CONSULTA</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin/reportes/create') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm">
                            <i class="fa fa-arrow-left me-1"></i> NUEVA CONSULTA
                        </a>
                        <a href="{{ url('admin/reportes/imprimir?inicio=' . urlencode($filtros['inicio_raw']) . '&fin=' . urlencode($filtros['fin_raw']) . '&user_id=' . $filtros['user_id'] . '&state_id=' . $filtros['state_id']) }}" target="_blank" class="btn btn-sm rounded-pill px-3 font-weight-bold text-white shadow-sm" style="background-color: #dc2626; border-color: #dc2626;">
                            <i class="fa fa-file-pdf-o me-1"></i> IMPRIMIR / GENERAR PDF
                        </a>
                    </div>
                </div>

                <div class="card-body p-4" v-cloak>
                    <!-- Resumen de Filtros Aplicados -->
                    <div class="p-3 mb-4 rounded-3 border bg-light" style="border-color: #cbd5e1 !important;">
                        <div class="row align-items-center g-2">
                            <div class="col-md">
                                <span class="text-muted font-weight-bold me-1" style="font-size: 0.82rem;">PERIODO:</span>
                                <span class="badge bg-dark rounded-pill px-3 py-1 me-2" style="font-size: 0.82rem;">
                                    <i class="fa fa-calendar me-1 text-info"></i> {{ $filtros['inicio'] }} HASTA {{ $filtros['fin'] }}
                                </span>
                                <span class="text-muted font-weight-bold me-1 ms-2" style="font-size: 0.82rem;">TÉCNICO:</span>
                                <span class="badge bg-secondary rounded-pill px-3 py-1 me-2" style="font-size: 0.82rem;">
                                    <i class="fa fa-user-md me-1"></i> {{ $filtros['user_name'] }}
                                </span>
                                <span class="text-muted font-weight-bold me-1 ms-2" style="font-size: 0.82rem;">ESTADO:</span>
                                <span class="badge bg-primary rounded-pill px-3 py-1 me-2" style="font-size: 0.82rem;">
                                    <i class="fa fa-tasks me-1"></i> {{ $filtros['state_name'] }}
                                </span>
                            </div>
                            <div class="col-md-auto text-end">
                                <span class="badge rounded-pill bg-success px-3 py-2 font-weight-bold" style="font-size: 0.9rem;">
                                    TOTAL REGISTROS: {{ $contar }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Resultados -->
                    @if($dhelps->isEmpty())
                        <div class="no-items-found text-center py-5">
                            <i class="fa fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <h4 class="font-weight-bold text-dark">No se encontraron asistencias</h4>
                            <p class="text-muted">No existen registros que coincidan con el rango de fechas y filtros seleccionados.</p>
                        </div>
                    @else
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-dark font-weight-bold text-center" width="90px">TICKET</th>
                                        <th class="text-dark font-weight-bold">TÉCNICO ASIGNADO</th>
                                        <th class="text-dark font-weight-bold" width="40%">ACCIÓN REALIZADA / SOLUCIÓN</th>
                                        <th class="text-dark font-weight-bold">FECHA REGISTRO</th>
                                        <th class="text-dark font-weight-bold text-center">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dhelps as $item)
                                        <tr>
                                            <td class="text-center font-weight-bold">
                                                <a href="{{ url('admin/helps/' . $item->help_id . '/show') }}" target="_blank" class="badge bg-dark rounded-pill px-3 py-2 text-white text-decoration-none shadow-sm" style="font-size: 0.85rem;">
                                                    #{{ $item->help_id }}
                                                </a>
                                            </td>
                                            <td class="font-weight-bold text-dark">
                                                <i class="fa fa-user-md me-1 text-info"></i>
                                                {{ $item->user ? trim($item->user->first_name . ' ' . $item->user->last_name) : 'Sin asignar' }}
                                            </td>
                                            <td>
                                                <div class="text-dark font-weight-normal" style="white-space: pre-line; word-break: break-word; font-size: 0.88rem;">
                                                    {{ $item->solution }}
                                                </div>
                                            </td>
                                            <td class="text-secondary font-weight-bold" style="font-size: 0.85rem;">
                                                <i class="fa fa-calendar me-1 text-muted"></i> {{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if($item->state_id == 1)
                                                    <span class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #d97706; font-size: 0.78rem;">
                                                        {{ optional($item->state)->name ?? 'EN ESPERA' }}
                                                    </span>
                                                @elseif($item->state_id == 2)
                                                    <span class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #16a34a; font-size: 0.78rem;">
                                                        {{ optional($item->state)->name ?? 'EN PROCESO' }}
                                                    </span>
                                                @elseif($item->state_id == 4)
                                                    <span class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #2563eb; font-size: 0.78rem;">
                                                        {{ optional($item->state)->name ?? 'FINALIZADO' }}
                                                    </span>
                                                @elseif($item->state_id == 9)
                                                    <span class="badge rounded-pill px-3 py-1 font-weight-bold text-dark shadow-sm" style="background-color: #fde047; font-size: 0.78rem;">
                                                        {{ optional($item->state)->name ?? 'PENDIENTE' }}
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #64748b; font-size: 0.78rem;">
                                                        {{ optional($item->state)->name ?? '-' }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
