@extends('brackets/admin-ui::admin.layout.usersys')

@section('title', trans('admin.help.actions.edit', ['name' => $help->name]))

@section('body')

<div class="container-xl py-3 px-2 mx-auto" style="max-width: 1000px;">
    <div class="card shadow-sm overflow-hidden my-4" style="border: 1px solid #cbd5e1 !important; border-radius: 1rem !important; background: #ffffff;">
        <help-form
            :action="'{{ route('admin.helps.guardar', $help) }}'"
            :data="{{ $help->toJson() }}"
            :finddataurl="'{{ url('cedula') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                @method('PUT')
                @csrf

                <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-paperclip text-white fa-lg me-2"></i>
                        <h5 class="mb-0 fw-bold text-white text-uppercase" style="font-size: 1.1rem; letter-spacing: 0.5px;">Adjuntar Documento al Ticket #{{ $help->id }}</h5>
                    </div>

                    <a class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm font-weight-bold" href="{{ url('consulta') }}" role="button">
                        <i class="fa fa-arrow-left me-1"></i> VOLVER A CONSULTA
                    </a>
                </div>

                <div class="card-body p-4">
                    <!-- Caja Informativa Estilizada -->
                    <div class="p-3.5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 5px solid #0284c7 !important; border-radius: 0.85rem; padding: 1.1rem 1.25rem;">
                        <div class="d-flex align-items-center">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-3 flex-shrink-0" style="min-width: 34px;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #0369a1; font-size: 1.05rem;">Documento o Nota de Respaldo</h6>
                                <p class="mb-0 text-dark" style="font-size: 0.9rem; color: #1e293b; line-height: 1.55;">
                                    Seleccione el archivo <strong>PDF</strong> o imagen de respaldo correspondiente a la solicitud del funcionario <strong>{{ $help->name }}</strong> (C.I. {{ $help->ci }}).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Uploader de Documentos Adjuntos -->
                    <div class="p-3 border rounded-3 bg-white" style="border-color: #cbd5e1 !important;">
                        @include('brackets/admin-ui::admin.includes.media-uploader', [
                            'mediaCollection' => app(App\Models\Help::class)->getMediaCollection('gallery'),
                            'label' => 'Seleccionar Archivo de Respaldo'
                        ])
                    </div>
                </div>

                <div class="card-footer bg-light border-top-0 py-3 px-4 text-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-bold" :disabled="submiting" style="background-color: #2563eb; border-color: #2563eb; color: #ffffff;">
                        <i class="fa me-1" :class="submiting ? 'fa-spinner fa-spin' : 'fa-upload'"></i>
                        GUARDAR ADJUNTO
                    </button>
                </div>
            </form>
        </help-form>
    </div>
</div>

@endsection
