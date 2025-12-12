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
        <form action="<?= base_url('petani/panen') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_tanaman" class="form-label">Tanaman</label>
                <select class="form-select" id="id_tanaman" name="id_tanaman" required>
                    <option value="">Pilih Tanaman</option>
                    <?php foreach ($jenis_tanaman as $tanaman) : ?>
                        <option value="<?= $tanaman['id_tanaman'] ?>" <?= (old('id_tanaman') == $tanaman['id_tanaman']) ? 'selected' : '' ?>><?= esc($tanaman['nama_tanaman']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_musim" class="form-label">Musim Tanam</label>
                <select class="form-select" id="id_musim" name="id_musim" required>
                    <option value="">Pilih Musim Tanam</option>
                    <?php foreach ($musim_tanam as $musim) : ?>
                        <option value="<?= $musim['id_musim'] ?>" <?= (old('id_musim') == $musim['id_musim']) ? 'selected' : '' ?>><?= esc($musim['periode_awal']) ?> - <?= esc($musim['periode_akhir']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Panen</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= old('tanggal') ?>" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Hasil (kg)</label>
                <input type="number" step="0.01" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga_per_kg" class="form-label">Harga per Kg (Rp)</label>
                <input type="number" step="0.01" class="form-control" id="harga_per_kg" name="harga_per_kg" value="<?= old('harga_per_kg') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('petani/panen') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>