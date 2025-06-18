<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/helps') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-id-card" style="font-size: 24px;"></i>&nbsp;&nbsp; {{ trans('admin.help.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/helps/finalizadas') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-check-circle" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FINALIZADAS</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/helps/pendientes') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-times" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PENDIENTES</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/detail-helps') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-search" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUSCAR DETALLE</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/reportes/create') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-book" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp; {{ trans('admin.reporte.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/states') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-line-chart" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp; {{ trans('admin.state.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/categories') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-refresh" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ trans('admin.category.title') }}</a></li>
           {{-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/functionaries') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.functionary.title') }}</a></li> --}}

           <li class="nav-item"><a class="nav-link" href="{{ url('admin/funcionarios') }}" style="font-size: 15px;font-weight: bold"><i class="fa fa-users" style="font-size: 24px;"></i>&nbsp;&nbsp;&nbsp;&nbsp; {{ trans('admin.funcionario.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            {{-- <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li> --}}
            {{-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li> --}}
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
