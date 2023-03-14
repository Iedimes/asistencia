@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.funcionario.actions.edit', ['name' => $funcionario->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <funcionario-form
                :action="'{{ $funcionario->resource_url }}'"
                :data="{{ $funcionario->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.funcionario.actions.edit', ['name' => $funcionario->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.funcionario.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </funcionario-form>

        </div>
    
</div>

@endsection