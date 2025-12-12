<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('petani/profil/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $profil['nama'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $profil['alamat'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp', $profil['no_hp'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <?php if (!empty($profil['foto'])) : ?>
                    <img src="<?= base_url('uploads/' . $profil['foto']) ?>" alt="Foto Profil" class="img-thumbnail mt-2" width="150">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="pass_confirm" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm">
            </div>
            <button type="submit" class="btn btn-primary">Update Profil</button>
            <a href="<?= base_url('petani/profil') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>
