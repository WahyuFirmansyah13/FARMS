<?= $this->include('layout/header') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Hasil Panen</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" value="<?= esc($panen['tanggal']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="id_tanaman" class="form-label">Jenis Tanaman</label>
                <input type="text" class="form-control" id="id_tanaman" value="<?= esc($panen['id_tanaman']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="id_musim" class="form-label">Musim Tanam</label>
                <input type="text" class="form-control" id="id_musim" value="<?= esc($panen['id_musim']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah (kg)</label>
                <input type="number" class="form-control" id="jumlah" value="<?= esc($panen['jumlah']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="harga_per_kg" class="form-label">Harga per Kg</label>
                <input type="text" class="form-control" id="harga_per_kg" value="Rp <?= esc(number_format($panen['harga_per_kg'], 0, ',', '.')) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="total_pendapatan" class="form-label">Total Pendapatan</label>
                <input type="text" class="form-control" id="total_pendapatan" value="Rp <?= esc(number_format($panen['total_pendapatan'], 0, ',', '.')) ?>" readonly>
            </div>
            <a href="<?= base_url('petani/panen') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
