@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.edit', ['name' => $help->name]))

@section('body')

    <div class="container-xl">
        <div class="card m-3" >

            <help-form
                {{-- :action="'{{ $help->resource_url }}'" --}}
                :action="'{{ route('admin.helps.guardar', $help) }}'"
                :data="{{ $help->toJson() }}"
                :finddataurl = "'{{ url('cedula') }}'"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                    @method('PUT') <!-- Esto simula el método PUT -->
                    @csrf <!-- Para proteger la solicitud contra ataques CSRF -->
                    <div class="card-header">
                        {{-- <i class="fa fa-pencil"></i> {{ trans('admin.help.actions.edit', ['name' => $help->name]) }} --}}
                        @if ($help->statuses->state_id != 4)
                        <a class="btn btn-danger btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps') }}" role="button"><i class="fa fa-undo"></i>&nbsp; VOLVER</a>
                        @else
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 rounded-pill" href="{{ url('admin/helps/finalizadas') }}" role="button"><i class="fa fa-undo"></i>&nbsp; VOLVER</a>
                        @endif
                        <h4 style="color: red; font-weight: bold; text-transform: uppercase; margin-bottom: 0px;" class="d-flex justify-content-center">ADJUNTAR DOCUMENTO</h4>


                    </div>

                    <div class="card-body">
                        {{-- @include('admin.help.components.form-elements') --}}
                         <!-- Uploader de Documentos Adjuntos -->
                         <div>
                            @include('brackets/admin-ui::admin.includes.media-uploader', [
                                'mediaCollection' => app(App\Models\Help::class)->getMediaCollection('gallery'),
                                'label' => 'Adjuntar documento'
                            ])
                        </div>
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger rounded-pill" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </help-form>

        </div>

</div>

@endsection
