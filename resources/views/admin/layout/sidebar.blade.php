<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/helps') }}"><i class="nav-icon icon-pencil"></i> {{ trans('admin.help.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/helps/finalizadas') }}"><i class="nav-icon icon-check"></i>FINALIZADAS</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/states') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.state.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/categories') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.category.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/functionaries') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.functionary.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li> --}}
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
