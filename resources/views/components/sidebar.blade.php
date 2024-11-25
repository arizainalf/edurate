<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sidebar Menu</title>
    <!-- Tambahkan pustaka Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Gaya umum untuk sidebar */
        .main-sidebar {
            width: 250px;
            background-color: #f8f9fa;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            background-color: white; /* Latar belakang putih */
            text-align: center;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
        }

        .sidebar-brand img {
            max-height: 50px;
            display: block;
            margin: 0 auto;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu .nav-item {
            display: block;
        }

        .sidebar-menu .nav-item .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar-menu .nav-item .nav-link i {
            margin-right: 10px;
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .sidebar-menu .nav-item.active .nav-link {
            background-color: #e9ecef;
            color: #104064;
        }

        .sidebar-menu .nav-item.active .nav-link i {
            color: #104064;
        }

        .hide-sidebar-mini {
            padding: 1rem 20px;
        }

        .hide-sidebar-mini a {
            text-decoration: none;
            font-size: 14px;
            color: white;
            background-color: #104064;
            padding: 10px 15px;
            display: block;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .hide-sidebar-mini a:hover {
            background-color: #082c4a;
        }
    </style>
</head>

<body>
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <!-- Ganti dengan logo -->
                <img src="{{ asset('img/logo3.png') }}" alt="logo" class="img-fluid" style="max-height: 30px;">
            </div>
            <ul class="sidebar-menu">
                <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                    <a href="{{ url('/admin') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/jabatan') ? 'active' : '' }}">
                    <a href="{{ url('admin/jabatan') }}" class="nav-link">
                        <i class="fas fa-briefcase"></i> <span>Jabatan</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/guru') ? 'active' : '' }}">
                    <a href="{{ url('admin/guru') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher"></i><span>Guru</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/kriteria') ? 'active' : '' }}">
                    <a href="{{ url('admin/kriteria') }}" class="nav-link">
                        <i class="fas fa-tasks"></i><span>Kriteria</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/kegiatan') ? 'active' : '' }}">
                    <a href="{{ url('admin/kegiatan') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i><span>Kegiatan</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/mapel') ? 'active' : '' }}">
                    <a href="{{ url('admin/mapel') }}" class="nav-link">
                        <i class="fas fa-book-open"></i><span>Mata Pelajaran</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/nilai*') ? 'active' : '' }}">
                    <a href="{{ url('admin/nilai') }}" class="nav-link">
                        <i class="fas fa-graduation-cap"></i> <span>Nilai</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                    <a href="{{ url('admin/user') }}" class="nav-link">
                        <i class="fas fa-user-cog"></i> <span>User</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('admin/profil') ? 'active' : '' }}">
                    <a href="{{ url('admin/profil') }}" class="nav-link">
                        <i class="fas fa-user"></i><span>Profile</span>
                    </a>
                </li>
            </ul>
            <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                <a href="{{ url('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </aside>
    </div>
</body>

</html>
