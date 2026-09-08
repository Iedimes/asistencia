@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.detail-help.actions.index'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <detail-help-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/detail-helps') }}'"
        inline-template>

        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                    <!-- Encabezado Principal con Degradado Moderno -->
                    <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">HISTORIAL DE ATENCIONES TÉCNICAS</h4>
                            <span class="badge bg-info rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">DETALLES / REGISTROS</span>
                        </div>
                    </div>

                    <div class="card-body p-4" v-cloak>
                        <!-- Buscador Unificado y Controles de Paginación -->
                        <form @submit.prevent="">
                            <div class="row justify-content-between align-items-center mb-4 g-3">
                                <div class="col-lg-7 col-md-8">
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px; color: #0f172a; text-transform: uppercase;" placeholder="BUSCAR POR NRO. TICKET, ACCIÓN REALIZADA O PATRIMONIO..." v-model="search" @input="search = $event.target.value.toUpperCase()" @keyup.enter="filter('search', $event.target.value)" />
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

                        <!-- Tabla de Detalles de Atenciones Técnicas -->
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th is='sortable' :column="'help_id'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.help_id') }}</th>
                                        <th is='sortable' :column="'user_id'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.user_id') }}</th>
                                        <th is='sortable' :column="'state_id'" class="text-dark font-weight-bold text-center">{{ trans('admin.detail-help.columns.state_id') }}</th>
                                        <th is='sortable' :column="'solution'" class="text-dark font-weight-bold" width="30%">{{ trans('admin.detail-help.columns.solution') }}</th>
                                        <th is='sortable' :column="'date'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.date') }}</th>
                                        <th is='sortable' :column="'category_id'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.category_id') }}</th>
                                        <th is='sortable' :column="'patrimony'" class="text-dark font-weight-bold">{{ trans('admin.detail-help.columns.patrimony') }}</th>
                                        <th class="text-center text-dark font-weight-bold" width="100px">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id">
                                        <td class="font-weight-bold text-dark">
                                            <a :href="'{{ url('admin/helps') }}/' + item.help_id + '/show'" class="badge bg-dark rounded-pill px-3 py-2 text-white text-decoration-none shadow-sm" style="font-size: 0.85rem;">
                                                #@{{ item.help_id }}
                                            </a>
                                        </td>
                                        <td class="font-weight-bold text-dark">
                                            <i class="fa fa-user-md me-1 text-info"></i>
                                            @{{ item.user ? (item.user.first_name + ' ' + item.user.last_name) : 'Sin asignar' }}
                                        </td>

                                        <td class="text-center">
                                            <span v-if="item.state_id == 1" class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #d97706; font-size: 0.78rem;">
                                                @{{ item.state ? item.state.name : 'EN ESPERA' }}
                                            </span>
                                            <span v-else-if="item.state_id == 2" class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #16a34a; font-size: 0.78rem;">
                                                @{{ item.state ? item.state.name : 'EN PROCESO' }}
                                            </span>
                                            <span v-else-if="item.state_id == 4" class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #2563eb; font-size: 0.78rem;">
                                                @{{ item.state ? item.state.name : 'FINALIZADO' }}
                                            </span>
                                            <span v-else-if="item.state_id == 9" class="badge rounded-pill px-3 py-1 font-weight-bold text-dark shadow-sm" style="background-color: #fde047; font-size: 0.78rem;">
                                                @{{ item.state ? item.state.name : 'PENDIENTE' }}
                                            </span>
                                            <span v-else class="badge rounded-pill px-3 py-1 font-weight-bold text-white shadow-sm" style="background-color: #64748b; font-size: 0.78rem;">
                                                @{{ item.state ? item.state.name : '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="text-dark font-weight-normal" style="white-space: pre-line; word-break: break-word; font-size: 0.9rem;">
                                                @{{ item.solution }}
                                            </div>
                                        </td>
                                        <td class="text-secondary font-weight-bold" style="font-size: 0.85rem;">
                                            <i class="fa fa-calendar me-1 text-muted"></i> @{{ item.date | date }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.78rem;">
                                                @{{ item.category ? item.category.name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-muted font-weight-bold" style="font-size: 0.85rem;">
                                            @{{ item.patrimony || '-' }}
                                        </td>

                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary rounded-circle shadow-sm text-white" :href="'{{ url('admin/helps') }}/' + item.help_id + '/show'" title="Ver Detalles del Ticket" role="button" style="width: 32px; height: 32px; padding: 5px 0; background-color: #2563eb; border-color: #2563eb; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                <i class="fa fa-eye text-white"></i>
                                            </a>
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
    </detail-help-listing>
</div>
@endsection
