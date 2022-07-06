@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.detail-assist.actions.edit', ['name' => $detailAssist->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <detail-assist-form
                :action="'{{ $detailAssist->resource_url }}'"
                :data="{{ $detailAssist->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.detail-assist.actions.edit', ['name' => $detailAssist->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.detail-assist.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </detail-assist-form>

        </div>
    
</div>

@endsection