<?= $this->include('layout/header') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Aktivitas Pertanian</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" value="<?= esc($aktivitas['tanggal']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" value="<?= esc($aktivitas['kegiatan']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" rows="3" readonly><?= esc($aktivitas['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <?php if ($aktivitas['foto']) : ?>
                    <div>
                        <img src="<?= base_url('uploads/' . $aktivitas['foto']) ?>" alt="Foto Aktivitas" width="200" class="img-thumbnail">
                    </div>
                <?php else : ?>
                    <p>Tidak ada foto.</p>
                <?php endif; ?>
            </div>
            <a href="<?= base_url('petani/aktivitas') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
