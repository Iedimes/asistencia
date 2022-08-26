@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.create'))

@section('body')

    <div class="container-xl">


    <div class="card">



        <help-form
            {{-- :action="'{{ url('admin/helps') }}'" --}}
            :action="'{{ url('test') }}'"
            :finddataurl = "'{{ url('cedula') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                {{-- <div v-if="show" class="btn btn-primary rounded-pill" role="alert">
                    <center><strong><h1>Ticket N° # @{{ ticket }} # Creado Correctamente.</h1></strong></center>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}

                <div class="card-header">
                    {{-- <i class="fa fa-plus"></i> {{ trans('admin.help.actions.create') }} --}}

                    <h4  class="d-flex justify-content-center"> <strong>SOLICITUD DE SOPORTE TIC</strong></h4>
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Formulario para solicitar soporte informatico.</h4>
                        <p>Ingrese los datos solicitados, y una breve descripción del incoveniente o ayuda que necesite.</p>
                        <hr>
                        <p class="mb-0">Una vez enviado,puede consultar su solicitud dando click en el boton consultar.</p>
                      </div>
                    <div class="row">

                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"> <a href='http://intranet' class="btn btn-primary rounded-pill"> <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-home'"></i> INICIO </a></div>
                             </div>


                </div>

                <div class="card-body">
                    @include('admin.help.components.form-elements')
                </div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-pill" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-paper-plane'"></i>
                   ENVIAR

                    </button>

                    <a href='/consulta' class="btn btn-primary rounded-pill"> <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-search'"></i> CONSULTAR </a>

                        <button type="reset" class="btn btn-danger rounded-pill" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa fa-times'"></i> CANCELAR</button>
                </div>

            </form>

        </help-form>

        </div>

        </div>


@endsection
