<header class="app-header navbar shadow-sm" style="height: 70px; background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%); border-bottom: 1px solid #334155; padding: 0 1.25rem;">
    <button class="navbar-toggler sidebar-toggler d-lg-none me-2" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler sidebar-toggler d-md-down-none me-3" type="button" data-toggle="sidebar-lg-show">
        <i class="fa fa-bars text-white" style="font-size: 1.2rem;"></i>
    </button>

    @if(View::exists('admin.layout.logo'))
        @include('admin.layout.logo')
    @endif

    <ul class="nav navbar-nav ml-auto d-flex align-items-center gap-2">
        <li class="nav-item dropdown">
            <a role="button" class="dropdown-toggle nav-link d-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #f8fafc; font-weight: 600; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.2s ease;">
                <span>
                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo rounded-circle shadow-sm" style="width: 36px; height: 36px; object-fit: cover;">
                    @elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span class="avatar-initials bg-primary text-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 36px; height: 36px; font-size: 0.88rem;">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials bg-primary text-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 36px; height: 36px; font-size: 0.88rem;">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::guard(config('admin-auth.defaults.guard'))->check() && Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name && Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name)
                        <span class="avatar-initials bg-primary text-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center font-weight-bold" style="width: 36px; height: 36px; font-size: 0.88rem;">{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials bg-secondary text-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="fa fa-user"></i></span>
                    @endif

                    @if(!is_null(config('admin-auth.defaults.guard')))
                        <span class="hidden-md-down ms-1 text-white font-weight-bold" style="font-size: 0.9rem;">{{ Auth::guard(config('admin-auth.defaults.guard'))->check() ? Auth::guard(config('admin-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</span>
                    @else
                        <span class="hidden-md-down ms-1 text-white font-weight-bold" style="font-size: 0.9rem;">{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</span>
                    @endif
                </span>
                <i class="fa fa-chevron-down ms-1 text-slate-300" style="font-size: 0.75rem; color: #cbd5e1;"></i>
            </a>
            @if(View::exists('admin.layout.profile-dropdown'))
                @include('admin.layout.profile-dropdown')
            @endif
        </li>
    </ul>
</header>
