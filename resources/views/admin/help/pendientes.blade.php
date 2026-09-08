@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.help.actions.index'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <help-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/helps/pendientes') }}'"
        inline-template>

        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                    <!-- Encabezado Principal con Degradado Moderno -->
                    <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">ASISTENCIAS PENDIENTES / EN ESPERA</h4>
                            <span class="badge bg-secondary rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">EN ESPERA</span>
                        </div>
                    </div>

                    <div class="card-body p-4" v-cloak>
                        <!-- Buscadores Independientes y Controles de Paginación -->
                        <form @submit.prevent="">
                            <div class="row align-items-end mb-4 g-3">
                                <!-- Buscador Solicitante / Cédula / Ticket -->
                                <div class="col-lg-5 col-md-6">
                                    <label class="form-label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                        <i class="fa fa-user me-1 text-primary"></i> Solicitante, Cédula o Ticket:
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 42px; color: #0f172a; text-transform: uppercase;" placeholder="BUSCAR POR SOLICITANTE, CÉDULA, ID..." v-model="search" @focus="filters.tecnico = ''" @input="filters.tecnico = ''; search = $event.target.value.toUpperCase()" @keyup.enter="filter('search', $event.target.value)" />
                                        <div class="input-group-append ms-2">
                                            <button type="button" class="btn rounded-pill px-3 shadow-sm font-weight-bold text-white" style="background-color: #2563eb; border-color: #2563eb; height: 42px;" @click="filters.tecnico = ''; filter('search', search)">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buscador Técnico Asignado -->
                                <div class="col-lg-5 col-md-6">
                                    <label class="form-label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                        <i class="fa fa-user-md me-1 text-info"></i> Técnico Asignado:
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 42px; color: #0f172a; text-transform: uppercase;" placeholder="BUSCAR POR NOMBRE DEL TÉCNICO..." v-model="filters.tecnico" @focus="search = ''" @input="search = ''; filters.tecnico = $event.target.value.toUpperCase()" @keyup.enter="filter('tecnico', $event.target.value)" />
                                        <div class="input-group-append ms-2">
                                            <button type="button" class="btn rounded-pill px-3 shadow-sm font-weight-bold text-white" style="background-color: #0284c7; border-color: #0284c7; height: 42px;" @click="search = ''; filter('tecnico', filters.tecnico)">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Controles por página -->
                                <div class="col-lg-2 col-md-12 text-lg-end">
                                    <label class="form-label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">Por página:</label>
                                    <select class="form-select form-control rounded-pill px-3 shadow-sm text-dark font-weight-bold d-inline-block" style="border: 1px solid #cbd5e1; height: 42px; width: 90px;" v-model="pagination.state.per_page">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla de Asistencias Pendientes -->
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th is='sortable' :column="'id'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.id') }}</th>
                                        <th is='sortable' :column="'ci'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.ci') }}</th>
                                        <th is='sortable' :column="'name'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.name') }}</th>
                                        <th width="240px" is='sortable' :column="'dependency'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.dependency') }}</th>
                                        <th is='sortable' :column="'fone'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.fone') }}</th>
                                        <th width="260px" is='sortable' :column="'problem'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.problem') }}</th>
                                        <th is='sortable' :column="'estado'" class="text-dark font-weight-bold text-center">{{ trans('admin.help.columns.estado') }}</th>
                                        <th is='sortable' :column="'tecnico'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.tecnico') }}</th>
                                        <th is='sortable' :column="'fechahora'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.fechahora') }}</th>
                                        <th class="text-dark font-weight-bold text-center" style="min-width: 140px;">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td><span class="fw-bold text-dark">#@{{ item.id }}</span></td>
                                        <td class="font-weight-bold text-dark">@{{ item.ci }}</td>
                                        <td><span class="fw-bold text-dark">@{{ item.name }}</span></td>
                                        <td>@{{ item.dependency }}</td>
                                        <td>@{{ item.fone }}</td>
                                        <td style="font-size: 0.85rem; text-transform: uppercase;">@{{ item.problem }}</td>

                                        <!-- Estado -->
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-secondary px-3 py-1 font-weight-bold">@{{ item.statuses && item.statuses.state ? item.statuses.state.name : 'PENDIENTE' }}</span>
                                        </td>

                                        <td><span class="font-weight-bold text-secondary">@{{ item.statuses && item.statuses.user ? item.statuses.user.full_name : '-' }}</span></td>
                                        <td style="font-size: 0.82rem;" class="text-nowrap">@{{ item.tecnico && item.tecnico.updated_at ? item.tecnico.updated_at : item.created_at | datetime }}</td>

                                        <!-- Botones de Acción -->
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a class="btn btn-sm btn-primary rounded-circle shadow-sm" :href="item.resource_url + '/show'" title="{{ trans('brackets/admin-ui::admin.btn.show') }}" role="button" style="width: 32px; height: 32px; padding: 5px 0; background-color: #2563eb; border-color: #2563eb;">
                                                    <i class="fa fa-search text-white"></i>
                                                </a>
                                                <a class="btn btn-sm btn-info rounded-circle shadow-sm text-white" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button" style="width: 32px; height: 32px; padding: 5px 0; background-color: #0284c7; border-color: #0284c7;">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                <a v-if="item.documento != null" class="btn btn-sm btn-warning rounded-circle shadow-sm text-dark" :href="item.resource_url + '/documento'" title="Ver Documento Adjunto" role="button" target="_blank" style="width: 32px; height: 32px; padding: 5px 0;">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a v-if="item.documento != null" class="btn btn-sm btn-danger rounded-circle shadow-sm text-white" :href="item.resource_url + '/eliminar'" title="Eliminar Documento" role="button" style="width: 32px; height: 32px; padding: 5px 0;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="!collection || collection.length === 0">
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            <i class="fa fa-clock-o fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                            <h6 class="fw-bold mb-1">No hay asistencias pendientes en este momento</h6>
                                            <p class="small text-muted mb-0">Todas las asistencias están activas o han sido finalizadas.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="row mt-3 align-items-center" v-if="pagination && pagination.state && pagination.state.total > 0">
                            <div class="col-sm">
                                <span class="pagination-caption text-muted font-weight-bold">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                            </div>
                            <div class="col-sm-auto">
                                <pagination></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </help-listing>
</div>
@endsection
