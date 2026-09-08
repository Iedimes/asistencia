@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.category.actions.edit', ['name' => $category->name]))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                
                <!-- Encabezado Principal con Degradado Moderno -->
                <div class="card-header border-0 py-3 px-4 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-info bg-opacity-25" style="width: 42px; height: 42px; background-color: rgba(2, 132, 199, 0.2);">
                        <i class="fa fa-pencil text-info fs-5"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">EDITAR CATEGORÍA: {{ mb_strtoupper($category->name, 'UTF-8') }}</h4>
                        <small class="text-white-50 font-weight-normal" style="font-size: 0.82rem;">Modifique el nombre o atributos de la categoría de atención técnica.</small>
                    </div>
                </div>

                <category-form
                    :action="'{{ $category->resource_url }}'"
                    :data="{{ $category->toJson() }}"
                    v-cloak
                    inline-template>

                    <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                        
                        <div class="card-body p-4">
                            @include('admin.category.components.form-elements')
                        </div>
                                        
                        <div class="card-footer bg-light border-0 py-3 px-4 d-flex justify-content-end gap-2">
                            <a href="{{ url('admin/categories') }}" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white" style="background-color: #64748b; border-color: #64748b; height: 44px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                <i class="fa fa-times me-1"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white ms-2" style="background-color: #2563eb; border-color: #2563eb; height: 44px;" :disabled="submiting">
                                <i class="fa" :class="submiting ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                                &nbsp; {{ trans('brackets/admin-ui::admin.btn.save') }}
                            </button>
                        </div>
                        
                    </form>
                </category-form>
            </div>
        </div>
    </div>
</div>
@endsection