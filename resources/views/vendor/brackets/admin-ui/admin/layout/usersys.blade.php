@extends('brackets/admin-ui::admin.layout.master')

@section('header')

    @include('brackets/admin-ui::admin.partials.headerusersys')


@endsection

@section('content')

    <div class="app-body">

        @if(View::exists('admin.layout.sidebar'))
            {{-- @include('admin.layout.sidebarusersys') --}}
        @endif

        <main class="main">

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

    <footer class="app-footer">
        <div class="container-fluid">
            <div class="container-xl">
            <span class="pull-right">
               <strong> Desarrollado por </strong><a href="http://intranet2/" target="_blank" style="color: #002555">MUVH-DGTIC 2022</a>
            </span>
            </div>
        </div>
    </footer>
@endsection

@section('bottom-scripts')
    @parent
@endsection
