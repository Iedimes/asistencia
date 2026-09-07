@extends('brackets/admin-ui::admin.layout.master')

@section('header')

    @include('brackets/admin-ui::admin.partials.headerusersys')


@endsection

@section('content')

    <div class="app-body" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%); min-height: calc(100vh - 76px);">

        @if(View::exists('admin.layout.sidebar'))
            {{-- @include('admin.layout.sidebarusersys') --}}
        @endif

        <main class="main" style="margin-left: 0 !important; padding-left: 0 !important; width: 100%;">

            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>

                @yield('body')
            </div>
        </main>
    </div>

    <footer class="app-footer border-0 bg-transparent py-4">
        <div class="container-fluid">
            <div class="container-xl text-center">
                <p class="mb-0 small text-muted font-weight-bold" style="color: #64748b; font-size: 0.85rem;">
                    Desarrollado por la <strong>DGTI</strong> &copy; {{ date('Y') }} — Todos los derechos reservados
                </p>
            </div>
        </div>
    </footer>
@endsection

@section('bottom-scripts')
    @parent
@endsection
