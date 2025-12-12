<nav class="navbar navbar-expand navbar-light top-navbar">
    <div class="container-fluid">
        <button class="btn btn-light d-lg-none me-2" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?? 'Page' ?></li>
            </ol>
        </nav>

        <div class="flex-grow-1"></div>

        <ul class="navbar-nav align-items-center">
            <!-- Dark Mode Toggle Button -->
            <li class="nav-item">
                <button class="btn btn-light btn-circle" id="theme-toggle" type="button">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </button>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url('uploads/' . (session('foto') ?? 'default-profile.jpg')) ?>" alt="Profil" class="navbar-profile-img me-2">
                    <span class="d-none d-sm-inline"><?= esc(session('username')) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url((session('role') ?? 'petani') . '/profil') ?>"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
