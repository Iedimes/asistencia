<div class="dropdown-menu dropdown-menu-right py-2 mt-2 shadow-2xl border-0" style="min-width: 220px; background-color: #0f172a; border: 1px solid #334155 !important; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;">
    <div class="dropdown-header text-center text-uppercase font-weight-bold py-2 px-3 mb-1" style="font-size: 0.72rem; letter-spacing: 1px; color: #94a3b8; border-bottom: 1px solid #1e293b;">
        {{ trans('brackets/admin-ui::admin.profile_dropdown.account') }}
    </div>
    
    <a href="{{ url('admin/profile') }}" class="dropdown-item py-2.5 px-3 d-flex align-items-center gap-2 font-weight-600 custom-profile-item" style="color: #f1f5f9; transition: all 0.2s;">
        <i class="fa fa-user-circle text-info" style="font-size: 1.1rem; width: 22px;"></i>
        <span>{{ trans('brackets/admin-auth::admin.profile_dropdown.profile') }}</span>
    </a>
    
    <a href="{{ url('admin/password') }}" class="dropdown-item py-2.5 px-3 d-flex align-items-center gap-2 font-weight-600 custom-profile-item" style="color: #f1f5f9; transition: all 0.2s;">
        <i class="fa fa-key text-warning" style="font-size: 1.1rem; width: 22px;"></i>
        <span>{{ trans('brackets/admin-auth::admin.profile_dropdown.password') }}</span>
    </a>
    
    <div class="my-1" style="border-top: 1px solid #1e293b;"></div>
    
    <a href="{{ url('admin/logout') }}" class="dropdown-item py-2.5 px-3 d-flex align-items-center gap-2 font-weight-600 custom-profile-logout" style="color: #f87171; transition: all 0.2s;">
        <i class="fa fa-power-off text-danger" style="font-size: 1.1rem; width: 22px;"></i>
        <span>{{ trans('brackets/admin-auth::admin.profile_dropdown.logout') }}</span>
    </a>
</div>

<style>
.custom-profile-item:hover {
    background-color: #1e293b !important;
    color: #38bdf8 !important;
}
.custom-profile-logout:hover {
    background-color: rgba(239, 68, 68, 0.15) !important;
    color: #ef4444 !important;
}
</style>