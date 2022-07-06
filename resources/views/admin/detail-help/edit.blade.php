@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.detail-help.actions.edit', ['name' => $detailHelp->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <detail-help-form
                :action="'{{ $detailHelp->resource_url }}'"
                :data="{{ $detailHelp->toJson() }}"
                :state="{{$state->toJson()}}"
                :category="{{$category->toJson()}}"
                :user="{{$user->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        {{-- <i class="fa fa-pencil"></i> {{ trans('admin.detail-help.actions.edit', ['name' => $detailHelp->id]) }} --}}
                        <center>EDITAR DETALLE DE ASISTENCIA</center>
                    </div>

                    <div class="card-body">
                        @include('admin.detail-help.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>

                        <button class="btn btn-primary" href="{{ url()->previous() }}" role="button"><i class="fa fa-undo"></i>&nbsp;Cancelar
                        </button>
                    </div>

                </form>

        </detail-help-form>

        </div>

</div>

@endsection
