<div class="sidebar">
    <div>
        <div class="logo">
            <i class="fas fa-tractor"></i> <span>FARMS 2.0</span>
        </div>
        <ul class="nav-links">
            <?php if (session('role') == 'admin'): ?>
                <li><a href="<?= base_url('admin/dashboard') ?>" class="<?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="<?= base_url('admin/petani') ?>" class="<?= (strpos(uri_string(), 'admin/petani') !== false) ? 'active' : '' ?>"><i class="fas fa-users"></i> <span>Data Petani</span></a></li>
                <li><a href="<?= base_url('admin/tanaman') ?>" class="<?= (strpos(uri_string(), 'admin/tanaman') !== false) ? 'active' : '' ?>"><i class="fas fa-seedling"></i> <span>Data Tanaman</span></a></li>
                <li><a href="<?= base_url('admin/laporan') ?>" class="<?= (strpos(uri_string(), 'admin/laporan') !== false) ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> <span>Laporan</span></a></li>
            <?php elseif (session('role') == 'petani'): ?>
                <li><a href="<?= base_url('petani/dashboard') ?>" class="<?= (uri_string() == 'petani/dashboard') ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="<?= base_url('petani/jenis_tanaman') ?>" class="<?= (strpos(uri_string(), 'petani/jenis_tanaman') !== false) ? 'active' : '' ?>"><i class="fas fa-seedling"></i> <span>Jenis Tanaman</span></a></li>
                <li><a href="<?= base_url('petani/musim') ?>" class="<?= (strpos(uri_string(), 'petani/musim') !== false) ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> <span>Musim Tanam</span></a></li>
                <li><a href="<?= base_url('petani/aktivitas') ?>" class="<?= (strpos(uri_string(), 'petani/aktivitas') !== false) ? 'active' : '' ?>"><i class="fas fa-tasks"></i> <span>Aktivitas</span></a></li>
                <li><a href="<?= base_url('petani/keuangan') ?>" class="<?= (strpos(uri_string(), 'petani/keuangan') !== false) ? 'active' : '' ?>"><i class="fas fa-money-bill-wave"></i> <span>Keuangan</span></a></li>
                <li><a href="<?= base_url('petani/panen') ?>" class="<?= (strpos(uri_string(), 'petani/panen') !== false) ? 'active' : '' ?>"><i class="fas fa-tractor"></i> <span>Hasil Panen</span></a></li>
                <li><a href="<?= base_url('petani/laporan') ?>" class="<?= (strpos(uri_string(), 'petani/laporan') !== false) ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> <span>Laporan</span></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
