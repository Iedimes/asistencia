@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.funcionario.actions.index'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <funcionario-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/funcionarios') }}'"
        inline-template>

        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                    
                    <!-- Encabezado Principal con Degradado Moderno -->
                    <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">CONSULTA DE FUNCIONARIOS</h4>
                            <span class="badge bg-info rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">PERSONAL / RRHH</span>
                        </div>
                    </div>

                    <div class="card-body p-4" v-cloak>
                        <!-- Buscador y Controles de Paginación -->
                        <form @submit.prevent="">
                            <div class="row justify-content-between align-items-center mb-4 g-3">
                                <div class="col-lg-6 col-md-7">
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px; color: #0f172a; text-transform: uppercase;" placeholder="BUSCAR POR CÉDULA, NOMBRE O USUARIO..." v-model="search" @input="search = $event.target.value.toUpperCase()" @keyup.enter="filter('search', $event.target.value)" />
                                        <div class="input-group-append ms-2">
                                            <button type="button" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white" style="background-color: #2563eb; border-color: #2563eb; height: 44px;" @click="filter('search', search)">
                                                <i class="fa fa-search me-1"></i> {{ trans('brackets/admin-ui::admin.btn.search') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-items-center gap-2">
                                    <label class="mb-0 text-muted font-weight-bold me-2" style="font-size: 0.88rem;">Registros por página:</label>
                                    <select class="form-select form-control rounded-pill px-3 shadow-sm text-dark font-weight-bold" style="border: 1px solid #cbd5e1; height: 44px; width: 90px;" v-model="pagination.state.per_page">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla de Funcionarios -->
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th is='sortable' :column="'FuncNro'" class="text-dark font-weight-bold" width="130px">{{ trans('admin.funcionario.columns.FuncNro') }}</th>
                                        <th is='sortable' :column="'FuncNom'" class="text-dark font-weight-bold">{{ trans('admin.funcionario.columns.FuncNom') }}</th>
                                        <th is='sortable' :column="'FUsuCod'" class="text-dark font-weight-bold">{{ trans('admin.funcionario.columns.FUsuCod') }}</th>
                                        <th class="text-dark font-weight-bold text-center" width="140px">ORIGEN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id">
                                        <td class="font-weight-bold text-dark">
                                            <span class="badge bg-dark rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.82rem;">@{{ item.FuncNro }}</span>
                                        </td>
                                        <td class="font-weight-bold text-dark" style="font-size: 0.9rem;">
                                            <i class="fa fa-user me-1 text-primary"></i> @{{ item.FuncNom }}
                                        </td>
                                        <td class="text-secondary font-weight-bold" style="font-size: 0.88rem;">
                                            @{{ item.FUsuCod || '-' }}
                                        </td>
                                        <td class="text-center">
                                            <span v-if="item.Origen == 'SIG008'" class="badge rounded-pill bg-info px-3 py-1 font-weight-bold text-white shadow-sm" style="font-size: 0.78rem;">
                                                @{{ item.Origen }}
                                            </span>
                                            <span v-else-if="item.Origen == 'RHM006'" class="badge rounded-pill bg-primary px-3 py-1 font-weight-bold text-white shadow-sm" style="font-size: 0.78rem;">
                                                @{{ item.Origen }}
                                            </span>
                                            <span v-else class="badge rounded-pill bg-secondary px-3 py-1 font-weight-bold text-white shadow-sm" style="font-size: 0.78rem;">
                                                @{{ item.Origen || 'DB' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="row align-items-center mt-4" v-if="pagination.state.total > 0">
                            <div class="col-sm text-muted font-weight-bold" style="font-size: 0.88rem;">
                                {{ trans('brackets/admin-ui::admin.pagination.overview') }}
                            </div>
                            <div class="col-sm-auto">
                                <pagination></pagination>
                            </div>
                        </div>

                        <!-- Estado Sin Registros -->
                        <div class="no-items-found text-center py-5" v-if="!collection.length > 0">
                            <i class="fa fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <h4 class="font-weight-bold text-dark">{{ trans('brackets/admin-ui::admin.index.no_items') }}</h4>
                            <p class="text-muted">{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </funcionario-listing>
</div>
@endsection
