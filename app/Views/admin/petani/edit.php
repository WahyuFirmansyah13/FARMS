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
        <form action="<?= base_url('admin/petani/' . $petani['id_user']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $petani['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="pass_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('admin/petani') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>