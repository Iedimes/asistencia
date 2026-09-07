@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.index'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto" style="max-width: 1700px;">
    <help-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('consulta') }}'"
        inline-template>

        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                    <!-- Encabezado con Degradado Moderno -->
                    <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">CONSULTA DE ASISTENCIAS SOLICITADAS</h4>
                        <a class="btn btn-outline-light rounded-pill px-4 shadow-sm font-weight-bold" href="{{ url('/') }}" role="button">
                            <i class="fa fa-undo me-1"></i> VOLVER AL INICIO
                        </a>
                    </div>

                    <div class="card-body p-4" v-cloak>
                        <!-- Buscador por Cédula -->
                        <form @submit.prevent="">
                            <div class="row justify-content-md-center mb-4">
                                <div class="col-lg-6 col-md-8 form-group mb-0">
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 46px; color: #0f172a;" placeholder="INGRESE NRO. DE CÉDULA PARA CONSULTAR" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                        <div class="input-group-append ms-2">
                                            <button type="button" class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white" style="background-color: #2563eb; border-color: #2563eb; height: 46px;" @click="filter('search', search)">
                                                <i class="fa fa-search me-1"></i> BUSCAR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla de Resultados -->
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th is='sortable' :column="'id'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.id') }}</th>
                                        <th is='sortable' :column="'posicion'" class="text-dark font-weight-bold text-center">ORDEN</th>
                                        <th is='sortable' :column="'ci'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.ci') }}</th>
                                        <th is='sortable' :column="'name'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.name') }}</th>
                                        <th is='sortable' :column="'user'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.user') }}</th>
                                        <th is='sortable' :column="'dependency'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.dependency') }}</th>
                                        <th is='sortable' :column="'fone'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.fone') }}</th>
                                        <th is='sortable' :column="'problem'" class="text-dark font-weight-bold" style="min-width: 250px;">{{ trans('admin.help.columns.problem') }}</th>
                                        <th is='sortable' :column="'estado'" class="text-dark font-weight-bold text-center">{{ trans('admin.help.columns.estado') }}</th>
                                        <th is='sortable' :column="'tecnico'" class="text-dark font-weight-bold">{{ trans('admin.help.columns.tecnico') }}</th>
                                        <th class="text-dark font-weight-bold text-center" style="min-width: 130px;">ADJUNTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td><span class="fw-bold text-dark">#@{{ item.id }}</span></td>
                                        <td class="text-center">
                                            <span class="badge bg-success rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.82rem;">#@{{ item.position }}</span>
                                        </td>

                                        <td class="font-weight-bold text-dark">@{{ item.ci }}</td>
                                        <td>@{{ item.name }}</td>
                                        <td><span class="badge bg-light text-dark border">@{{ item.user }}</span></td>
                                        <td>@{{ item.dependency }}</td>
                                        <td>@{{ item.fone }}</td>
                                        <td style="font-size: 0.88rem;">@{{ item.problem }}</td>

                                        <!-- Estados -->
                                        <td class="text-center">
                                            <span v-if="item.statuses && item.statuses.state && item.statuses.state.id == 1" class="badge rounded-pill bg-warning text-dark px-3 py-1 font-weight-bold">@{{ item.statuses.state.name }}</span>
                                            <span v-else-if="item.statuses && item.statuses.state && item.statuses.state.id == 2" class="badge rounded-pill bg-success px-3 py-1 font-weight-bold">@{{ item.statuses.state.name }}</span>
                                            <span v-else-if="item.statuses && item.statuses.state && item.statuses.state.id == 9" class="badge rounded-pill bg-secondary px-3 py-1 font-weight-bold">@{{ item.statuses.state.name }}</span>
                                            <span v-else-if="item.statuses && item.statuses.state" class="badge rounded-pill bg-primary px-3 py-1 font-weight-bold">@{{ item.statuses.state.name }}</span>
                                        </td>

                                        <td>@{{ item.statuses && item.statuses.user ? item.statuses.user.full_name : '-' }}</td>

                                        <!-- Adjuntos -->
                                        <td class="text-center align-middle" style="min-width: 130px;">
                                            <div v-if="!item.documento">
                                                <a class="btn btn-sm rounded-pill px-3 py-1 font-weight-bold shadow-sm d-inline-flex align-items-center justify-content-center" :href="item.id + '/editar'" title="Adjuntar Documento" role="button" style="background-color: #2563eb; border-color: #2563eb; color: #ffffff !important; font-size: 0.82rem; text-decoration: none;">
                                                    <i class="fa fa-paperclip me-1"></i> Adjuntar
                                                </a>
                                            </div>
                                            <div v-else>
                                                <a class="btn btn-sm rounded-pill px-3 py-1 font-weight-bold shadow-sm d-inline-flex align-items-center justify-content-center" :href="item.resource_url + '/documento'" title="Ver Documento Adjunto" role="button" target="_blank" style="background-color: #d97706; border-color: #d97706; color: #ffffff !important; font-size: 0.82rem; text-decoration: none;">
                                                    <i class="fa fa-eye me-1"></i> Ver
                                                </a>
                                            </div>
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
