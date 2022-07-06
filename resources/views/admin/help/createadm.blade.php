@extends('brackets/admin-ui::admin.layout.default')


@section('title', trans('admin.help.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <help-form
            {{-- :action="'{{ url('admin/helps') }}'" --}}
            {{-- :action="'{{ url('test') }}'" --}}
            :action="'{{ url('admin/helps/storeadm') }}'"
            :finddataurl = "'{{ url('cedula') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.help.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.help.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-pill" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}

                    </button>

                    <a class="btn btn-primary rounded-pill" href="{{ url()->previous() }}" role="button" placeholder="Volver"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.helps') }} </a>




                </div>

            </form>

        </help-form>

        </div>

        </div>


@endsection
