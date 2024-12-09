@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.create'))

@section('body')
@include('admin.help.orden')

    <!-- Contenedor para Solicitud de Soporte TIC -->
    <div class="col-md-8"> <!-- Ajusta el tamaño según lo necesites -->
        <div class="card">
            <help-form
                :action="'{{ url('test') }}'"
                :finddataurl="'{{ url('cedula') }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center"><strong>SOLICITUD DE SOPORTE TIC</strong></h4>
                        <div class="alert alert-info" role="alert">
                            <h5 style="color: #365c72; font-weight: bold;">Formulario para solicitar soporte informático.</h5>
                            <ul>
                                <li style="color: #365c72;">Ingrese los datos solicitados, y una breve descripción del inconveniente o ayuda que necesite.</li>
                                <li style="color: #365c72;">Una vez enviado, puede consultar su solicitud dando clic en el botón consultar.</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <a href='http://intranet' class="btn btn-primary rounded-pill">
                                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-home'"></i> INICIO
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('admin.help.components.form-elements')
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary rounded-pill" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-paper-plane'"></i> ENVIAR
                        </button>
                        <a href='/consulta' class="btn btn-primary rounded-pill">
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
