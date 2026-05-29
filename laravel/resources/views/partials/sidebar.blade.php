<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('input') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bank Sampah</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('/input*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('input') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Admin
    </div>

    <li class="nav-item {{ Request::is('admin/riwayat*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.riwayat') }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Input</span></a>
    </li>

    <li class="nav-item {{ Request::is('admin/rekap*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.rekap') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Rekap Data</span></a>
    </li>

    <li class="nav-item {{ Request::is('admin/sampah*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.sampah.index') }}">
            <i class="bi bi-box2-fill"></i>
            <span>Sampah</span></a>
    </li>

    <li class="nav-item {{ Request::is('admin/user*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.user.index') }}">
            <i class="bi bi-person-fill"></i>
            <span>User</span></a>
    </li>

    <li class="nav-item {{ Request::is('admin/role*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.role.index') }}">
            <i class="bi bi-person-gear"></i>
            <span>Role</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
