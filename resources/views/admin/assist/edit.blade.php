@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.assist.actions.edit', ['name' => $assist->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <assist-form
                :action="'{{ $assist->resource_url }}'"
                :data="{{ $assist->toJson() }}"
                :state="{{$state->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.assist.actions.edit', ['name' => $assist->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.assist.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </assist-form>

        </div>

</div>

@endsection
