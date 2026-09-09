@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.create'))

@section('body')
<div class="container-xl py-3 px-2 mx-auto">
    <div class="row g-4 justify-content-center align-items-start">
        @include('admin.help.orden')

        <!-- Contenedor para Solicitud de Soporte TIC -->
        <div class="col-xl-9 col-lg-9 col-md-8 mb-4">
            <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                <help-form
                    :action="'{{ url('test') }}'"
                    :finddataurl="'{{ url('cedula') }}'"
                    v-cloak
                    inline-template>

                    <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                        <!-- Encabezado -->
                        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                            <h4 class="mb-0 fw-bold text-white text-center tracking-tight" style="font-size: 1.3rem; letter-spacing: 0.5px;">SOLICITUD DE SOPORTE</h4>
                        </div>

                        <div class="card-body p-4">
                            <!-- Caja Informativa / Instrucciones -->
                            <div class="alert border-0 p-3 mb-4 shadow-sm" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 5px solid #0284c7 !important; border-radius: 0.85rem;">
                                <h6 class="fw-bold mb-1 text-dark" style="color: #0369a1;">¿Cómo solicitar asistencia técnica?</h6>
                                <ul class="mb-0 text-dark ps-3" style="font-size: 0.88rem; line-height: 1.6; color: #1e293b;">
                                    <li>Ingrese su <strong>Número de Cédula</strong> para consultar sus datos en el sistema.</li>
                                    <li>Proporcione un número de teléfono o interno válido y describa detalladamente su solicitud.</li>
                                    <li>Al enviar, se generará su número de ticket y se le asignará una <strong>posición en el orden de atención</strong>.</li>
                                </ul>
                            </div>

                            <!-- Elementos del Formulario -->
                            @include('admin.help.components.form-elements')

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Checkbox para Activar Documentos Adjuntos -->
                            <div class="p-3 rounded-3 border bg-light mb-4">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" id="require-docs" class="form-check-input mt-0" v-model="requiresDocuments" style="width: 1.2rem; height: 1.2rem;">
                                    <label for="require-docs" class="form-check-label fw-bold text-dark mb-0 ms-2" style="cursor: pointer;">
                                        <i class="fa fa-paperclip text-primary me-1"></i> Clic aquí si requiere adjuntar un documento o nota de respaldo
                                    </label>
                                </div>
                            </div>

                            <!-- Uploader de Documentos Adjuntos -->
                            <div v-if="requiresDocuments" class="p-3 border rounded-3 bg-white mb-4">
                                @include('brackets/admin-ui::admin.includes.media-uploader', [
                                    'mediaCollection' => app(App\Models\Help::class)->getMediaCollection('gallery'),
                                    'label' => 'Adjuntar Archivos / Notas de Respaldo'
                                ])
                            </div>
                        </div>

                        <!-- Botones de Acción Estilizados -->
                    <div class="card-footer bg-light border-top-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-bold" :disabled="submiting" style="background-color: #2563eb; border-color: #2563eb; color: #ffffff;">
                                <i class="fa me-1" :class="submiting ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i> ENVIAR SOLICITUD
                            </button>

                            <a href='/consulta' class="btn rounded-pill px-3 shadow-sm font-weight-bold text-white" :disabled="submiting" style="background-color: #1e293b; border-color: #1e293b; color: #ffffff !important;">
                                <i class="fa fa-search me-1"></i> CONSULTAR TICKET
                            </a>

                            <button type="reset" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm font-weight-bold" :disabled="submiting" style="color: #475569; border-color: #cbd5e1;">
                                <i class="fa fa-eraser me-1"></i> LIMPIAR
                            </button>
                        </div>

                        <a href='http://intranet' class="btn rounded-pill px-4 shadow-sm font-weight-bold" :disabled="submiting" style="background-color: #0284c7; border-color: #0284c7; color: #ffffff !important;">
                            <i class="fa fa-globe me-1"></i> INTRANET
                        </a>
                    </div>
                    </form>
                </help-form>
            </div>
        </div>
    </div>
</div>
@endsection
