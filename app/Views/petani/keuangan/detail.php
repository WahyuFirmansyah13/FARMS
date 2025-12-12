<?= $this->include('layout/header') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Transaksi Keuangan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" value="<?= esc($keuangan['tanggal']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                <input type="text" class="form-control" id="jenis_transaksi" value="<?= esc($keuangan['jenis_transaksi']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="kategori" value="<?= esc($keuangan['kategori']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal</label>
                <input type="text" class="form-control" id="nominal" value="Rp <?= esc(number_format($keuangan['nominal'], 0, ',', '.')) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" rows="3" readonly><?= esc($keuangan['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="id_aktivitas" class="form-label">Terkait Aktivitas</label>
                <input type="text" class="form-control" id="id_aktivitas" value="<?= esc($keuangan['id_aktivitas'] ? 'Aktivitas ID: ' . $keuangan['id_aktivitas'] : 'Tidak ada') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="id_panen" class="form-label">Terkait Hasil Panen</label>
                <input type="text" class="form-control" id="id_panen" value="<?= esc($keuangan['id_panen'] ? 'Panen ID: ' . $keuangan['id_panen'] : 'Tidak ada') ?>" readonly>
            </div>
            <a href="<?= base_url('petani/keuangan') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
