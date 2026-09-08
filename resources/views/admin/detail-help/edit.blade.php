@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.detail-help.actions.edit', ['name' => $detailHelp->id]))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto" style="max-width: 900px;">
    <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">

        <detail-help-form
            :action="'{{ $detailHelp->resource_url }}'"
            :data="{{ $detailHelp->toJson() }}"
            :state="{{$state->toJson()}}"
            :category="{{$category->toJson()}}"
            :user="{{$user->toJson()}}"
            v-cloak
            inline-template>

            <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa fa-pencil text-white fs-4"></i>
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.2rem;">EDITAR DETALLE DE ASISTENCIA TÉCNICA</h4>
                    </div>
                    <a class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm" href="{{ url()->previous() }}" role="button">
                        <i class="fa fa-undo me-1"></i> VOLVER
                    </a>
                </div>

                <div class="card-body p-4">
                    @include('admin.detail-help.components.form-elements')
                </div>

                <div class="card-footer bg-light border-0 p-4 d-flex justify-content-end gap-2">
                    <a class="btn rounded-pill px-4 font-weight-bold shadow-sm text-white" href="{{ url()->previous() }}" role="button" style="background-color: #475569 !important; border-color: #475569 !important; color: #ffffff !important;">
                        <i class="fa fa-undo me-1 text-white"></i> CANCELAR
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-bold" :disabled="submiting" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important;">
                        <i class="fa me-1" :class="submiting ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </detail-help-form>

    </div>
</div>
@endsection

