@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reporte.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

                    <reporte-form
                    :action="'{{ url('admin/reportes') }}'"
                    v-cloak
                    inline-template>

                    <form class="form-horizontal form-create" action="imprimir">
                        <div class="card-header">
                            <center><h4>REPORTE DE ASISTENCIAS</h4></center>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="inicio" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reporte.columns.inicio') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <div class="input-group input-group--custom">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <datetime :config="datetimePickerConfig"  class="flatpickr" id="inicio" name="inicio" class="@error('inicio') is-invalid @enderror"></datetime>
                                    </div>
                                    @error('inicio')
                                    <div class="input-group input-group--custom" style="color: red">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="fin" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reporte.columns.fin') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <div class="input-group input-group--custom">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <datetime :config="datetimePickerConfig" class="flatpickr" id="fin" name="fin" class="@error('fin') is-invalid @enderror"></datetime>
                                    </div>
                                    @error('fin')
                                    <div class="input-group input-group--custom" style="color: red">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo Técnico -->
                            <div v-if="form.state_id != 1" class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
                                <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reporte.columns.user_id') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <select name="user_id" id="user_id" v-model="form.user_id" class="form-control">
                                        <option value="0">TODOS</option>
                                        @foreach($user as $user)
                                            <option value="{{ $user['id']}}"> {{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
                                </div>
                            </div>

                            <!-- Campo Estado -->
                            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('state_id'), 'has-success': fields.state_id && fields.state_id.valid }">
                                <label for="state_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('ESTADO') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <select name="state_id" id="state_id" v-model="form.state_id" class="form-control">
                                        <option value="0">TODOS</option>
                                        @foreach($estado as $estado)
                                            <option value="{{ $estado['id']}}"> {{ $estado->name }}</option>
                                        @endforeach
                                    </select>
                                    <div v-if="errors.has('state_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state_id') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            {{-- <button type="submit" class="btn btn-danger" :disabled="submiting">
                                <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-file-pdf-o'"></i>
                                GENERAR INFORME
                            </button> --}}
                            <button type="button" class="btn btn-primary" onclick="verResultados()">
                                <i class="fa fa-eye"></i> VER RESULTADOS
                            </button>

                        </div>
                    </form>
                </reporte-form>

        </div>

        </div>


@endsection
<script>

function verResultados() {
    const form = document.querySelector('.form-create');
    form.action = "{{ route('admin/reportes/resultados') }}";
    form.method = "GET"; // O el método adecuado
    form.submit();
}


</script>
