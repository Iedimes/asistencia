@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.state.actions.index'))

@section('body')
<div class="container-fluid px-lg-4 px-3 py-3 mx-auto">
    <state-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/states') }}'"
        inline-template>

        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="card shadow-sm overflow-hidden" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
                    
                    <!-- Encabezado Principal con Degradado Moderno -->
                    <div class="card-header border-0 py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-0 fw-bold text-white tracking-tight" style="font-size: 1.25rem;">ADMINISTRACIÓN DE ESTADOS</h4>
                            <span class="badge bg-warning rounded-pill px-3 py-1 font-weight-bold text-dark" style="font-size: 0.75rem; letter-spacing: 0.5px;">CONFIGURACIÓN</span>
                        </div>
                        <div>
                            <a class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white" href="{{ url('admin/states/create') }}" role="button" style="background-color: #2563eb; border-color: #2563eb;">
                                <i class="fa fa-plus me-1"></i> {{ trans('admin.state.actions.create') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4" v-cloak>
                        <!-- Buscador y Controles de Paginación -->
                        <form @submit.prevent="">
                            <div class="row justify-content-between align-items-center mb-4 g-3">
                                <div class="col-lg-6 col-md-7">
                                    <div class="input-group">
                                        <input class="form-control rounded-pill shadow-sm text-dark font-weight-bold px-3" style="border: 1px solid #cbd5e1; height: 44px; color: #0f172a; text-transform: uppercase;" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @input="search = $event.target.value.toUpperCase()" @keyup.enter="filter('search', $event.target.value)" />
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

                        <!-- Tabla de Estados -->
                        <div class="table-responsive rounded-3 border" style="border-color: #e2e8f0 !important;">
                            <table class="table table-hover table-listing mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="bulk-checkbox text-center" width="50px">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">#</label>
                                        </th>
                                        <th is='sortable' :column="'id'" class="text-dark font-weight-bold" width="100px">{{ trans('admin.state.columns.id') }}</th>
                                        <th is='sortable' :column="'name'" class="text-dark font-weight-bold">{{ trans('admin.state.columns.name') }}</th>
                                        <th class="text-center text-dark font-weight-bold" width="120px">ACCIONES</th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="4">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/states')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>
                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger rounded-pill px-3" @click="bulkDelete('/admin/states/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox text-center">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id" :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id"></label>
                                        </td>
                                        <td class="font-weight-bold text-dark">
                                            <span class="badge bg-dark rounded-pill px-3 py-1 font-weight-bold" style="font-size: 0.82rem;">#@{{ item.id }}</span>
                                        </td>
                                        <td class="font-weight-bold text-dark" style="font-size: 0.9rem;">
                                            @{{ item.name }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a class="btn btn-sm btn-info rounded-circle shadow-sm text-white" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button" style="width: 32px; height: 32px; padding: 5px 0; background-color: #0284c7; border-color: #0284c7; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                <form @submit.prevent="deleteItem(item.resource_url)" class="d-inline">
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm text-white" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}" style="width: 32px; height: 32px; padding: 5px 0; background-color: #dc2626; border-color: #dc2626; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fa fa-trash text-white"></i>
                                                    </button>
                                                </form>
                                            </div>
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
                            <a class="btn rounded-pill px-4 shadow-sm font-weight-bold text-white mt-2" href="{{ url('admin/states/create') }}" role="button" style="background-color: #2563eb; border-color: #2563eb;">
                                <i class="fa fa-plus me-1"></i> {{ trans('admin.state.actions.create') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </state-listing>
</div>
@endsection