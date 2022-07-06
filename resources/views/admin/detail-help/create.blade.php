@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.detail-help.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <detail-help-form
            :action="'{{ url('admin/detail-helps') }}'"
            :state="{{$state->toJson()}}"
            :category="{{$category->toJson()}}"
            :user="{{$user->toJson()}}"
            :help={{$id}}
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.detail-help.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.detail-help.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </detail-help-form>

        </div>

        </div>


@endsection
