@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.r-h-m0066.actions.edit', ['name' => $rHM0066->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <r-h-m0066-form
                :action="'{{ $rHM0066->resource_url }}'"
                :data="{{ $rHM0066->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.r-h-m0066.actions.edit', ['name' => $rHM0066->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.r-h-m0066.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </r-h-m0066-form>

        </div>
    
</div>

@endsection