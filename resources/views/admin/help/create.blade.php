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

                    <center><H4>SOLICITUD DE ASISTENCIA</H4></center>

                      <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight"></div>
                        <div class="p-2 bd-highlight"></div>
                        <div class="p-2 bd-highlight"><a href='/consulta' class="btn btn-primary rounded-pill"> <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-search'"></i> CONSULTAR </a></div>
                      </div>

                </div>

                <div class="card-body">
                    @include('admin.help.components.form-elements')
                </div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-pill" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}

                    </button>
                    <a href='http://intranet2/' class="btn btn-warning rounded-pill">  <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-undo'"></i> CANCELAR</a>
                </div>

            </form>

        </help-form>

        </div>

        </div>


@endsection
