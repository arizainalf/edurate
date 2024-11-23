<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">EduRate</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">NL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item  {{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/jabatan') ? 'active' : '' }}">
                <a href="{{ url('admin/jabatan') }}" class="nav-link"><i class="fas fa-book"></i> <span>Jabatan</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/guru') ? 'active' : '' }}">
                <a href="{{ url('admin/guru') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Guru</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/kriteria') ? 'active' : '' }}">
                <a href="{{ url('admin/kriteria') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Kriteria</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/kegiatan') ? 'active' : '' }}">
                <a href="{{ url('admin/kegiatan') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Kegiatan</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/mapel') ? 'active' : '' }}">
                <a href="{{ url('admin/mapel') }}" class="nav-link"><i class="fas fa-columns"></i>
                    <span>Mata Pelajaran</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/nilai*') ? 'active' : '' }}">
                <a href="{{ url('admin/nilai') }}" class="nav-link"><i class="fas fa-book"></i> <span>Nilai</span></a>
            </li>
            <li class="nav-item {{ Request::is('admin/profill') ? 'active' : '' }}">
                <a href="{{ url('admin/profil') }}" class="nav-link"><i class="fa-solid fa-id-badge"></i>
                    <span>Profile</span></a>
            </li>
        </ul>
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="{{ url('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>
</div>
