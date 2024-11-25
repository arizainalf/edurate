<div class="navbar-bg" style="background-color: #104064;"></div>
<nav class="navbar navbar-expand-lg main-navbar" style="background-color: #104064;">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars text-white"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">
                <!-- Profile Image -->
                <div 
                    class="img-navbar mr-2"
                    style="
                        background-image: url('{{ asset(Auth::user()->image != 'default.png' ? '/storage/img/user/' . Auth::user()->image : '/images/default.png') }}'); 
                        width: 40px; 
                        height: 40px; 
                        border-radius: 50%; 
                        background-size: cover; 
                        background-position: center;">
                </div>
                <!-- User Name -->
                <span class="text-white d-sm-none d-lg-inline-block">
                    {{ auth()->user()->name ?? 'Login Terlebih Dahulu!' }}
                </span>
            </a>
            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ url('admin/profil') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
