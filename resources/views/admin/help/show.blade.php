@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.help.actions.show'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <!-- Tarjeta Principal de Detalle del Ticket -->
    <div class="card shadow-sm mb-4 overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
        <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
            <div class="d-flex align-items-center gap-3">
                <i class="fa fa-ticket text-white fs-4"></i>
                <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.2rem;">SOLICITUD DE ASISTENCIA TÉCNICA #{{ $help->id }}</h4>
            </div>

            @if ($help->statuses->state_id != 4)
                <a class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm" href="{{ url('admin/helps') }}" role="button">
                    <i class="fa fa-undo me-1"></i> VOLVER A LISTADO
                </a>
            @else
                <a class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm" href="{{ url('admin/helps/finalizadas') }}" role="button">
                    <i class="fa fa-undo me-1"></i> VOLVER A FINALIZADAS
                </a>
            @endif
        </div>

        <div class="card-body p-4">
            <!-- Grid de Información del Ticket (Fila 1: Datos de Contacto) -->
            <div class="row g-3 mb-3">
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="p-3 rounded-3 h-100" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">CÉDULA / ID</small>
                        <span class="fs-6 fw-bold text-dark"><i class="fa fa-id-card-o me-2 text-primary"></i>{{ $help->ci }}</span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-6">
                    <div class="p-3 rounded-3 h-100" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">SOLICITANTE</small>
                        <span class="fs-6 fw-bold text-dark"><i class="fa fa-user-o me-2 text-primary"></i>{{ $help->name }}</span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="p-3 rounded-3 h-100" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">DEPENDENCIA / OFICINA</small>
                        <span class="fs-6 fw-bold text-dark"><i class="fa fa-building-o me-2 text-primary"></i>{{ $help->dependency }}</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-6">
                    <div class="p-3 rounded-3 h-100" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">TELÉFONO / INTERNO</small>
                        <span class="fs-6 fw-bold text-dark"><i class="fa fa-phone me-2 text-primary"></i>{{ $help->fone }}</span>
                    </div>
                </div>
            </div>

            <!-- Fila 2: Descripción y Estado Actual -->
            <div class="row g-3 align-items-stretch">
                <div class="col-md-9 col-sm-12">
                    <div class="p-3 rounded-3 h-100 d-flex flex-column justify-content-center" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">DESCRIPCIÓN DE LA SOLICITUD</small>
                        <span class="fs-6 fw-bold text-dark text-uppercase d-block" style="line-height: 1.5; white-space: pre-line; word-break: break-word;"><i class="fa fa-commenting-o me-2 text-primary"></i>{!! nl2br(e($help->problem)) !!}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="p-3 rounded-3 h-100 d-flex flex-column align-items-center justify-content-center text-center" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <small class="text-uppercase fw-bold text-muted d-block mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">ESTADO ACTUAL</small>
                        @if ($help->statuses->state->name == 'SOLICITADO')
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2 fw-bold fs-6">SOLICITADO</span>
                        @elseif ($help->statuses->state->name == 'ASIGNADO')
                            <span class="badge rounded-pill bg-success px-3 py-2 fw-bold fs-6">EN PROCESO / ASIGNADO</span>
                        @elseif ($help->statuses->state->name == 'FINALIZADO')
                            <span class="badge rounded-pill bg-primary px-3 py-2 fw-bold fs-6">FINALIZADO</span>
                        @elseif ($help->statuses->state->name == 'PENDIENTE')
                            <span class="badge rounded-pill bg-secondary px-3 py-2 fw-bold fs-6">EN ESPERA</span>
                        @else
                            <span class="badge rounded-pill bg-info px-3 py-2 fw-bold fs-6">{{ $help->statuses->state->name }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Componente y Tabla de Historial de Atención Técnica con Columnas Redimensionables y Selector de PDF -->
    <detail-help-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/detail-helps') }}'"
        inline-template>

        <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
            <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0 !important;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-wrench text-primary me-1 fs-5"></i>
                    <h5 class="mb-0 fw-bold text-dark">HISTORIAL DE ATENCIÓN TÉCNICA</h5>
                    <small class="text-muted ms-2 d-none d-md-inline" style="font-size: 0.78rem;">
                        <i class="fa fa-arrows-h text-info me-1"></i>Arrastre los bordes de la tabla para ajustar anchos
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if ($help->statuses->state_id != 4)
                        <a class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm font-weight-bold" href="{{ url('admin/helps/'.$help->id.'/createdetail') }}" role="button" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="fa fa-plus-circle me-1"></i> REGISTRAR ATENCIÓN TÉCNICA
                        </a>
                    @endif

                    <!-- Barra de Opciones de Impresión PDF -->
                    <div class="d-flex align-items-center gap-1 bg-white border rounded-pill px-2 py-1 shadow-sm" style="border-color: #cbd5e1 !important;">
                        <small class="fw-bold text-dark me-1" style="font-size: 0.78rem; padding-left: 6px;"><i class="fa fa-print text-primary me-1"></i>PDF:</small>
                        <select id="ticket_paper_size" class="form-select form-select-sm border-0 bg-transparent text-dark font-weight-bold" style="font-size: 0.8rem; cursor: pointer; width: auto;">
                            <option value="a4" selected>Hoja A4</option>
                            <option value="legal">Hoja Oficio / Legal</option>
                            <option value="letter">Hoja Carta</option>
                        </select>
                        <select id="ticket_orientation" class="form-select form-select-sm border-0 bg-transparent text-dark font-weight-bold" style="font-size: 0.8rem; cursor: pointer; width: auto;">
                            <option value="portrait" selected>Vertical</option>
                            <option value="landscape">Horizontal</option>
                        </select>
                        <button type="button" onclick="descargarPdfDetalleTicket('{{ url('admin/helps/'.$help->id.'/showdetallepdf') }}')" class="btn btn-sm btn-danger rounded-pill px-3 font-weight-bold text-white shadow-sm" style="background-color: #dc2626; border-color: #dc2626;">
                            <i class="fa fa-file-pdf-o me-1"></i> GENERAR PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4" v-cloak>
                <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                    <table class="table table-hover table-listing mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th is='sortable' :column="'user_id'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.user_id') }}</th>
                                <th width="45%" is='sortable' :column="'solution'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.solution') }}</th>
                                <th is='sortable' :column="'date'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.date') }}</th>
                                <th is='sortable' :column="'category_id'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.category_id') }}</th>
                                <th is='sortable' :column="'patrimony'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.patrimony') }}</th>
                                <th class="text-dark font-weight-bold text-center">ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-if="item.user.id !== 1" v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                <td><span class="font-weight-bold text-dark">@{{ item.user.full_name }}</span></td>
                                <td class="text-uppercase font-weight-bold text-dark" style="font-size: 0.88rem; white-space: pre-line; word-break: break-word;">@{{ item.solution }}</td>
                                <td class="text-nowrap text-dark" style="font-size: 0.85rem;">@{{ (item.created_at || item.date) | datetime }}</td>
                                <td><span class="badge bg-light text-dark border px-2 py-1">@{{ item.category ? item.category.name : '-' }}</span></td>
                                <td><span class="font-weight-bold text-secondary" style="white-space: pre-line; word-break: break-word;">@{{ item.patrimony || '-' }}</span></td>

                                <td class="text-center">
                                    @if ($help->statuses->state_id == 4)
                                        <a class="btn btn-sm btn-info rounded-circle shadow-sm text-white" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button" style="width: 32px; height: 32px; padding: 5px 0;">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a class="btn btn-sm btn-info rounded-circle shadow-sm text-white" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button" style="width: 32px; height: 32px; padding: 5px 0;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form @submit.prevent="deleteItem(item.resource_url)" class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm text-white" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}" style="width: 32px; height: 32px; padding: 5px 0;">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <tr v-if="!collection || collection.length === 0">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa fa-wrench fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                    <h6 class="fw-bold mb-1">Sin historial de atenciones registradas</h6>
                                    <p class="small text-muted mb-0">Haga clic en 'Registrar Atención Técnica' para agregar una entrada.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </detail-help-listing>
</div>

<script>
function descargarPdfDetalleTicket(baseUrl) {
    const paperSize = document.getElementById('ticket_paper_size').value || 'a4';
    const orientation = document.getElementById('ticket_orientation').value || 'portrait';

    const table = document.querySelector('.table-listing');
    let params = `paper_size=${paperSize}&orientation=${orientation}`;

    if (table) {
        const ths = table.querySelectorAll('thead th');
        if (ths.length >= 5) {
            const tableWidth = table.offsetWidth;
            const userPct = Math.round((ths[0].offsetWidth / tableWidth) * 100) + '%';
            const solutionPct = Math.round((ths[1].offsetWidth / tableWidth) * 100) + '%';
            const datePct = Math.round((ths[2].offsetWidth / tableWidth) * 100) + '%';
            const categoryPct = Math.round((ths[3].offsetWidth / tableWidth) * 100) + '%';
            const patrimonyPct = Math.round((ths[4].offsetWidth / tableWidth) * 100) + '%';

            params += `&col_user=${userPct}&col_solution=${solutionPct}&col_date=${datePct}&col_category=${categoryPct}&col_patrimony=${patrimonyPct}`;
        }
    }

    window.open(`${baseUrl}?${params}`, '_blank');
}

// Script para redimensionar columnas de la tabla en pantalla (Resizable Table Columns)
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const table = document.querySelector('.table-listing');
        if (!table) return;

        const ths = table.querySelectorAll('thead th');
        ths.forEach((th, index) => {
            if (index === ths.length - 1) return; // Omitir columna de acciones

            th.style.position = 'relative';
            const resizer = document.createElement('div');
            resizer.className = 'resizer';
            resizer.style.width = '6px';
            resizer.style.height = '100%';
            resizer.style.position = 'absolute';
            resizer.style.right = '0';
            resizer.style.top = '0';
            resizer.style.cursor = 'col-resize';
            resizer.style.userSelect = 'none';
            resizer.style.zIndex = '10';

            th.appendChild(resizer);

            let x = 0;
            let w = 0;

            const mouseDownHandler = function(e) {
                x = e.clientX;
                w = th.offsetWidth;

                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);
                resizer.style.background = '#2563eb';
            };

            const mouseMoveHandler = function(e) {
                const dx = e.clientX - x;
                const newWidth = Math.max(60, w + dx);
                th.style.width = newWidth + 'px';
            };

            const mouseUpHandler = function() {
                document.removeEventListener('mousemove', mouseMoveHandler);
                document.removeEventListener('mouseup', mouseUpHandler);
                resizer.style.background = 'transparent';
            };

            resizer.addEventListener('mousedown', mouseDownHandler);
        });
    }, 500);
});
</script>
@endsection
