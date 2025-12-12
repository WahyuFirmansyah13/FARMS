<?= $this->include('layout/header') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="row">
    <!-- Left Column: Profile Picture and Edit Button -->
    <div class="col-md-4 mb-4">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                <img src="<?= base_url('uploads/' . ($profil['foto'] ?? 'default.jpg')) ?>" alt="Foto Profil" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                <h5 class="card-title mb-1"><?= esc($profil['nama'] ?? 'Nama Belum Diisi') ?></h5>
                <p class="text-muted mb-3">@<?= esc($user['username']) ?></p>
                <a href="<?= base_url(session('role') . '/profil/edit') ?>" class="btn btn-primary">
                    <i class="fas fa-pencil-alt me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Detailed Information -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Informasi Detail
            </div>
            <div class="card-body p-4">
                <dl class="row">
                    <dt class="col-sm-3 text-muted">Alamat</dt>
                    <dd class="col-sm-9"><?= esc($profil['alamat'] ?? 'Belum diisi') ?></dd>
                </dl>
                <hr>
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">No. HP</dt>
                    <dd class="col-sm-9 mb-0"><?= esc($profil['no_hp'] ?? 'Belum diisi') ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
