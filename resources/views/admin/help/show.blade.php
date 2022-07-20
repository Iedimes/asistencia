@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.help.actions.show'))

@section('body')

<div class="card">
    <div class="card-header text-center">
         SOLICITUD DE ASISTENCIA
         @if ($help->statuses->state_id != 4)
         <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps') }}" role="button"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.help.show') }}</a>
         {{-- <a href='admin/helps' class="btn btn-primary"> VOLVER <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-undo'"></i></a> --}}<br>
         @else
         <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps/finalizadas') }}" role="button"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.help.show') }}</a>
        @endif
    </div>

    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-2">
            <p class="card-text"><strong>TICKET NUMERO:</strong>  {{ $help->id }}</p>
            </div>
            <div class="form-group col-sm-3">
                <p class="card-text"><strong>NOMBRE:</strong>  {{ $help->name }}</p>
            </div>
            <div class="form-group col-sm-3">
                <p class="card-text"><strong>CEDULA:</strong> {{ $help->ci }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>DEPENDENCIA:</strong> {{ $help->dependency }} </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2">
                <p class="card-text"><strong>TELEFONO:</strong> {{ $help->fone }}</p>
            </div>
            <div class="form-group col-sm-3">
                <p class="card-text"><strong>DESCRIPCION SOLICITUD:</strong> {{ $help->problem }}</p>
            </div>
            <div class="form-group col-sm-4">

                <td style="text-align:center;">
                    @if ($help->statuses->state->name == 'SOLICITADO')
                        <span class="badge bg-warning">
                            <td ><strong>ESTADO:</strong><span style="text-align:center;"> {{ $help->statuses->state->name }} </span></td>

                    @endif
                    @if ($help->statuses->state->name == 'ASIGNADO')
                        <span class="badge bg-success">
                            <td ><strong>ESTADO:</strong><span style="text-align:center;" > {{ $help->statuses->state->name }}</span></td>
                    @endif
                    @if ($help->statuses->state->name == 'FINALIZADO')
                        <span class="badge bg-primary">
                            <td ><strong>ESTADO:</strong><span style="text-align:center;" > {{ $help->statuses->state->name }}</span></td>
                    @endif

                    @if ($help->statuses->state->name == 'PENDIENTE')
                        <span class="badge"style="color:gray; background:yellow">
                            <td ><strong>ESTADO:</strong><span style="text-align:center;" > {{ $help->statuses->state->name }}</span></td>
                    @endif
                        </span>
                </td>
            </div>

        </div>




    </div>
  </div>

  <detail-help-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/detail-helps') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.detail-help.actions.index') }}
                        @if ($help->statuses->state_id == 4)

                        @else
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps/'.$help->id.'/createdetail') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.detail-help.actions.create') }}</a>

                        @endif
                        <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" href="{{ url('admin/helps/'.$help->id.'/showdetallepdf/') }}" title="{{ trans('brackets/admin-ui::admin.btn.show') }}" role="button"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">


                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>


                                        {{-- <th is='sortable' :column="'id'">{{ trans('admin.detail-help.columns.id') }}</th>
                                        <th is='sortable' :column="'help_id'">{{ trans('admin.detail-help.columns.help_id') }}</th> --}}
                                        <th is='sortable' :column="'user_id'">{{ trans('admin.detail-help.columns.user_id') }}</th>
                                        {{-- <th is='sortable' :column="'state_id'">{{ trans('admin.detail-help.columns.state_id') }}</th> --}}
                                        <th width="850px" is='sortable' :column="'solution'">{{ trans('admin.detail-help.columns.solution') }}</th>
                                        <th is='sortable' :column="'date'">{{ trans('admin.detail-help.columns.date') }}</th>
                                        <th is='sortable' :column="'category_id'">{{ trans('admin.detail-help.columns.category_id') }}</th>
                                        <th is='sortable' :column="'patrimony'">{{ trans('admin.detail-help.columns.patrimony') }}</th>

                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr V-if="item.user.id !== 1" v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">


                                    {{-- <td>@{{ item.id }}</td>
                                        <td>@{{ item.help_id }}</td> --}}
                                        <td>@{{ item.user.full_name }}</td>
                                        {{-- <td>@{{ item.state_id }}</td> --}}
                                        <td>@{{ item.solution }}</td>
                                        <td>@{{ item.date | date }}</td>
                                        <td>@{{ item.category.name }}</td>
                                        <td>@{{ item.patrimony }}</td>

                                        <td>
                                            @if ($help->statuses->state_id == 4)
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info rounded-pill" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>

                                            </div>
                                            @else
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info rounded-pill" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>

                                            @endif

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div> --}}

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                {{-- <a class="btn btn-primary btn-spinner" href="{{ url('admin/detail-helps/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.detail-help.actions.create') }}</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </detail-help-listing>



@endsection
