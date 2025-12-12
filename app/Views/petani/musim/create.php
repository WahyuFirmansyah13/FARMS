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
        <form action="<?= base_url('petani/musim') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_tanaman" class="form-label">Jenis Tanaman</label>
                <select class="form-select" id="id_tanaman" name="id_tanaman" required>
                    <option value="">Pilih Jenis Tanaman</option>
                    <?php foreach ($jenis_tanaman as $tanaman) : ?>
                        <option value="<?= $tanaman['id_tanaman'] ?>" <?= (old('id_tanaman') == $tanaman['id_tanaman']) ? 'selected' : '' ?>><?= esc($tanaman['nama_tanaman']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="periode_awal" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="periode_awal" name="periode_awal" value="<?= old('periode_awal') ?>" required>
            </div>
            <div class="mb-3">
                <label for="periode_akhir" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="periode_akhir" name="periode_akhir" value="<?= old('periode_akhir') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('petani/musim') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>