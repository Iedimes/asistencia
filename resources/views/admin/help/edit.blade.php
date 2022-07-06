@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.help.actions.edit', ['name' => $help->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <help-form
                :action="'{{ $help->resource_url }}'"
                :data="{{ $help->toJson() }}"
                :finddataurl = "'{{ url('cedula') }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        {{-- <i class="fa fa-pencil"></i> {{ trans('admin.help.actions.edit', ['name' => $help->name]) }} --}}
                        @if ($help->statuses->state_id != 4)
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps') }}" role="button"><i class="fa fa-undo"></i>&nbsp; VOLVER</a>
                        @else
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps/finalizadas') }}" role="button"><i class="fa fa-undo"></i>&nbsp; VOLVER</a>
                        @endif

                        <center>EDITAR ASISTENCIA</center>

                    </div>

                    <div class="card-body">
                        @include('admin.help.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </help-form>

        </div>

</div>

@endsection
