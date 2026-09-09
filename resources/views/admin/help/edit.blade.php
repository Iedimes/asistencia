@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.help.actions.edit', ['name' => $help->name]))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto" style="max-width: 900px;">
    <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">

        <help-form
            :action="'{{ $help->resource_url }}'"
            :data="{{ $help->toJson() }}"
            :finddataurl="'{{ url('cedula') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa fa-pencil text-white fs-4"></i>
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.2rem;">EDITAR ASISTENCIA TÉCNICA #{{ $help->id }}</h4>
                    </div>
                    @if ($help->statuses->state_id != 4)
                        <a class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm" href="{{ url('admin/helps') }}" role="button">
                            <i class="fa fa-undo me-1"></i> VOLVER
                        </a>
                    @else
                        <a class="btn btn-sm btn-outline-light rounded-pill px-3 font-weight-bold shadow-sm" href="{{ url('admin/helps/finalizadas') }}" role="button">
                            <i class="fa fa-undo me-1"></i> VOLVER
                        </a>
                    @endif
                </div>

                <div class="card-body p-4">
                    @include('admin.help.components.form-elements')
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

        </help-form>

    </div>
</div>
@endsection

