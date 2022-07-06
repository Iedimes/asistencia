@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.s-i-g008.actions.edit', ['name' => $sIG008->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <s-i-g008-form
                :action="'{{ $sIG008->resource_url }}'"
                :data="{{ $sIG008->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.s-i-g008.actions.edit', ['name' => $sIG008->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.s-i-g008.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </s-i-g008-form>

        </div>
    
</div>

@endsection