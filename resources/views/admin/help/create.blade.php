@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.create'))

@section('body')
@include('admin.help.orden')

    <!-- Contenedor para Solicitud de Soporte TIC -->
    <div class="col-md-8 mt-3">
        <div class="card">
            <help-form
                :action="'{{ url('test') }}'"
                :finddataurl="'{{ url('cedula') }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center" style="color: red;"><strong>SOLICITUD DE SOPORTE TIC</strong></h4>
                        <div class="alert alert-info rounded-0" role="alert">
                            <h5 style="color: #365c72; font-weight: bold;">FORMULARIO PARA SOLICITAR SOPORTE INFORMATICO.</h5>
                            <ul>
                                <li style="color: #365c72;">INGRESE LOS DATOS SOLICITADOS, Y UNA BREVE DESCRIPCION DEL INCONVENIENTE O AYUDA QUE NECESITE.</li>
                                <li style="color: #365c72;">EL SISTEMA GENERARA UN TICKET AUTOMATICO Y SE LE ASIGNARA EL NUMERO DE ORDEN DE ATENCION.</li>
                                <li style="color: #365c72;">UNA VEZ ENVIADO, PUEDE CONSULTAR SU SOLICITUD DANDO CLIC EN EL BOTÓN CONSULTAR.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Elementos del Formulario -->
                        @include('admin.help.components.form-elements')

                        <!-- Checkbox para Activar Documentos Adjuntos -->
                        <div class="form-check mb-4">
                            <input type="checkbox" id="require-docs" class="form-check-input" v-model="requiresDocuments">
                            <label for="require-docs" class="form-check-label" style="color: #365c72; font-weight: bold;">
                                ¿Va a solicitar usuario? Chequee aquí y adjunte el documento requerido.
                            </label>
                        </div>

                        <!-- Uploader de Documentos Adjuntos -->
                        <div v-if="requiresDocuments">
                            @include('brackets/admin-ui::admin.includes.media-uploader', [
                                'mediaCollection' => app(App\Models\Help::class)->getMediaCollection('gallery'),
                                'label' => 'Documentos Adjuntos'
                            ])
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn rounded-pill" style="background-color: #365c72; color: white;" :disabled="submiting">
                                <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-paper-plane'"></i> ENVIAR
                            </button>
                            <a href='/consulta' class="btn rounded-pill" style="background-color: #365c72; color: white;" :disabled="submiting">
                                <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-search'"></i> CONSULTAR
                            </a>
                            <button type="reset" class="btn rounded-pill" style="background-color: #365c72; color: white;" :disabled="submiting">
                                <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-times'"></i> CANCELAR
                            </button>
                        </div>
                        <a href='http://intranet' class="btn rounded-pill" style="background-color: #365c72; color: white;" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-home'"></i> INTRANET
                        </a>
                    </div>
                </form>
            </help-form>
        </div>
    </div>
</div>
@endsection
