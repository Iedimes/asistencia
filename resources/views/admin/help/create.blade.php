@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.create'))

@section('body')
@include('admin.help.orden')

    <!-- Contenedor para Solicitud de Soporte TIC -->
    <div class="col-md-8">
        <div class="card">
            <help-form
                :action="'{{ url('test') }}'"
                :finddataurl="'{{ url('cedula') }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center" style="color: red;"><strong>SOLICITUD DE SOPORTE TIC</strong></h4>
                        <div class="alert alert-info" role="alert">
                            <h5 style="color: #365c72; font-weight: bold;">FORMULARIO PARA SOLICITAR SOPORTE INFORMATICO.</h5>
                            <ul>
                                <li style="color: #365c72;">INGRESE LOS DATOS SOLICITADOS, Y UNA BREVE DESCRIPCION DEL INCONVENIENTE O AYUDA QUE NECESITE.</li>
                                <li style="color: #365c72;">EL SISTEMA GENERARA UN TICKET AUTOMATICO Y SE LE ASIGNARA EL NUMERO DE ORDEN DE ATENCION.</li>
                                <li style="color: #365c72;">UNA VEZ ENVIADO, PUEDE CONSULTAR SU SOLICITUD DANDO CLIC EN LE BOTON CONSULTAR.</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <a href='http://intranet' class="btn btn-danger rounded-pill">
                                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-home'"></i> INICIO
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('admin.help.components.form-elements')
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn rounded-pill" style="background-color: #365c72; color: white;" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-paper-plane'"></i> ENVIAR
                        </button>
                        <a href='/consulta' class="btn btn-warning rounded-pill" style="background-color: #e9ad07; color: white;" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-search'"></i> CONSULTAR
                        </a>
                        <button type="reset" class="btn btn-danger rounded-pill" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-times'"></i> CANCELAR
                        </button>
                    </div>
                </form>
            </help-form>
        </div>
    </div>
</div>
@endsection
