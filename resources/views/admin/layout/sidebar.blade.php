<div class="sidebar shadow-sm">
    <nav class="sidebar-nav" style="background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);">
        <ul class="nav py-3 px-2">
            <li class="nav-title text-white-50 font-weight-bold px-3 mb-2" style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase;">
                MENÚ PRINCIPAL
            </li>

            <!-- Asistencias Técnicas (En Proceso) -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ (request()->is('admin/helps') && !request()->is('admin/helps/finalizadas') && !request()->is('admin/helps/pendientes')) ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/helps') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-id-card me-2 text-info" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>{{ trans('admin.help.title') }}</span>
                </a>
            </li>

            <!-- Finalizadas -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/helps/finalizadas') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/helps/finalizadas') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-check-circle me-2 text-success" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>FINALIZADAS</span>
                </a>
            </li>

            <!-- Pendientes -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/helps/pendientes') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/helps/pendientes') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-clock-o me-2 text-warning" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>PENDIENTES</span>
                </a>
            </li>

            <!-- Buscar Detalle -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/detail-helps*') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/detail-helps') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-search me-2 text-primary" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>BUSCAR DETALLE</span>
                </a>
            </li>

            <!-- Reportes -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/reportes*') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/reportes/create') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-book me-2 text-info" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>{{ trans('admin.reporte.title') }}</span>
                </a>
            </li>

            <!-- Estados -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/states*') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/states') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-line-chart me-2 text-warning" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>{{ trans('admin.state.title') }}</span>
                </a>
            </li>

            <!-- Categorías -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/categories*') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/categories') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-tags me-2 text-success" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>{{ trans('admin.category.title') }}</span>
                </a>
            </li>

            <!-- Funcionarios -->
            <li class="nav-item mb-1">
                <a class="nav-link rounded-pill px-3 py-2 text-white font-weight-bold d-flex align-items-center {{ request()->is('admin/funcionarios*') ? 'active-menu-item' : 'inactive-menu-item' }}" href="{{ url('admin/funcionarios') }}" style="font-size: 0.88rem; transition: all 0.2s;">
                    <i class="fa fa-users me-2 text-primary" style="font-size: 1.1rem; width: 22px;"></i>
                    <span>{{ trans('admin.funcionario.title') }}</span>
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

<style>
.active-menu-item {
    background-color: #2563eb !important;
    color: #ffffff !important;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.4);
}
.inactive-menu-item:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}
.sidebar-minimizer {
    background-color: #0f172a !important;
    border-top: 1px solid #1e293b !important;
    transition: all 0.2s ease !important;
}
.sidebar-minimizer:hover {
    background-color: #1e293b !important;
}
.sidebar-minimizer::before {
    color: #cbd5e1 !important;
}
</style>
