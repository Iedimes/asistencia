@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reporte.actions.create'))

@section('body')

<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                
                <!-- Encabezado Principal con Degradado Moderno -->
                <div class="card-header border-0 py-3 px-4 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-25" style="width: 42px; height: 42px; background-color: rgba(37, 99, 235, 0.2);">
                        <i class="fa fa-bar-chart text-info fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">GENERACIÓN DE REPORTES DE ASISTENCIA</h4>
                        <small class="text-white-50 font-weight-normal" style="font-size: 0.82rem;">Seleccione los criterios y rango de fechas para consultar o imprimir informes.</small>
                    </div>
                </div>

                <reporte-form
                    :action="'{{ url('admin/reportes') }}'"
                    v-cloak
                    inline-template>

                    <form class="form-horizontal form-create" action="{{ url('admin/reportes/resultados') }}" method="GET">
                        <div class="card-body p-4">
                            
                            <!-- Sección 1: Rango de Fechas -->
                            <div class="p-3 mb-4 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                    <i class="fa fa-calendar text-primary"></i> Rango de Fechas
                                </h6>
                                
                                <div class="row g-3">
                                    <!-- Fecha Inicio -->
                                    <div class="col-md-6">
                                        <label for="inicio" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            {{ trans('admin.reporte.columns.inicio') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <datetime :config="datePickerConfig" id="inicio" name="inicio" class="form-control rounded-end-pill text-dark font-weight-bold" style="border: 1px solid #cbd5e1; height: 44px;" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
                                        </div>
                                        @if(isset($errors) && $errors->has('inicio'))
                                            <div class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;">
                                                <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first('inicio') }}
                                            </div>
                                        @endif
                                        <div v-if="errors.has('inicio')" class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;" v-cloak>
                                            <i class="fa fa-exclamation-circle me-1"></i>@{{ errors.first('inicio') }}
                                        </div>
                                    </div>

                                    <!-- Fecha Fin -->
                                    <div class="col-md-6">
                                        <label for="fin" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            {{ trans('admin.reporte.columns.fin') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <datetime :config="datePickerConfig" id="fin" name="fin" class="form-control rounded-end-pill text-dark font-weight-bold" style="border: 1px solid #cbd5e1; height: 44px;" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
                                        </div>
                                        @if(isset($errors) && $errors->has('fin'))
                                            <div class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;">
                                                <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first('fin') }}
                                            </div>
                                        @endif
                                        <div v-if="errors.has('fin')" class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;" v-cloak>
                                            <i class="fa fa-exclamation-circle me-1"></i>@{{ errors.first('fin') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 2: Filtros Secundarios (Técnico y Estado) -->
                            <div class="p-3 mb-2 rounded-3 border" style="background-color: #ffffff; border-color: #e2e8f0 !important;">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                    <i class="fa fa-filter text-primary"></i> Filtros de Selección
                                </h6>
                                
                                <div class="row g-3">
                                    <!-- Campo Técnico -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            {{ trans('admin.reporte.columns.user_id') }}
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-user-md"></i>
                                            </span>
                                            <select name="user_id" id="user_id" v-model="form.user_id" class="form-select form-control rounded-end-pill text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px;">
                                                <option value="0">TODOS LOS TÉCNICOS</option>
                                                @foreach($user as $u)
                                                    <option value="{{ $u['id'] }}"> {{ $u->first_name }} {{ $u->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Campo Estado -->
                                    <div class="col-md-6">
                                        <label for="state_id" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            ESTADO
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-tasks"></i>
                                            </span>
                                            <select name="state_id" id="state_id" v-model="form.state_id" class="form-select form-control rounded-end-pill text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px;">
                                                <option value="0">TODOS LOS ESTADOS</option>
                                                @foreach($estado as $est)
                                                    <option value="{{ $est['id'] }}"> {{ mb_strtoupper($est->name, 'UTF-8') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección 3: Formato e Impresión (Tamaño de Hoja y Orientación) -->
                            <div class="p-3 mb-2 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0 !important;">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                                    <i class="fa fa-print text-primary"></i> Formato de Impresión (PDF)
                                </h6>
                                
                                <div class="row g-3">
                                    <!-- Tamaño de Hoja -->
                                    <div class="col-md-6">
                                        <label for="paper_size" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            TAMAÑO DE HOJA
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-file-text-o"></i>
                                            </span>
                                            <select name="paper_size" id="paper_size" class="form-select form-control rounded-end-pill text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px;">
                                                <option value="a4" selected>A4 (210 x 297 mm) - Estándar</option>
                                                <option value="legal">Oficio / Legal (216 x 356 mm)</option>
                                                <option value="letter">Carta / Letter (216 x 279 mm)</option>
                                                <option value="a3">A3 (297 x 420 mm)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Orientación -->
                                    <div class="col-md-6">
                                        <label for="orientation" class="form-label font-weight-bold text-dark" style="font-size: 0.88rem;">
                                            ORIENTACIÓN DE HOJA
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #cbd5e1; border-top-left-radius: 50rem; border-bottom-left-radius: 50rem; padding-left: 14px;">
                                                <i class="fa fa-refresh"></i>
                                            </span>
                                            <select name="orientation" id="orientation" class="form-select form-control rounded-end-pill text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px;">
                                                <option value="landscape" selected>Horizontal (Apaisado) - Recomendado</option>
                                                <option value="portrait">Vertical</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie de Tarjeta con Botones de Acción -->
                        <div class="card-footer bg-light border-0 py-3 px-4 d-flex flex-wrap justify-content-end gap-2">
                            <button type="submit" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white" style="background-color: #2563eb; border-color: #2563eb; height: 44px;" onclick="verResultados()">
                                <i class="fa fa-search me-1"></i> VER RESULTADOS
                            </button>
                            <button type="button" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white ms-2" style="background-color: #dc2626; border-color: #dc2626; height: 44px;" onclick="descargarPdfDirecto()">
                                <i class="fa fa-file-pdf-o me-1"></i> IMPRIMIR / DESCARGAR PDF
                            </button>
                        </div>
                    </form>
                </reporte-form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
function verResultados() {
    const form = document.querySelector('.form-create');
    form.action = "{{ url('admin/reportes/resultados') }}";
    form.method = "GET";
}

function descargarPdfDirecto() {
    const form = document.querySelector('.form-create');
    form.action = "{{ url('admin/reportes/imprimir') }}";
    form.method = "GET";
    form.target = "_blank";
    form.submit();
}
</script>
