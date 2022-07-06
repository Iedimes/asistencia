@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.functionary.actions.edit', ['name' => $functionary->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <functionary-form
                :action="'{{ $functionary->resource_url }}'"
                :data="{{ $functionary->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.functionary.actions.edit', ['name' => $functionary->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.functionary.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </functionary-form>

        </div>
    
</div>

@endsection