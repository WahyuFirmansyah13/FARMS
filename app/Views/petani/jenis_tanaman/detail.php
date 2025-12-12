<?= $this->include('layout/header') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Jenis Tanaman</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="nama_tanaman" class="form-label">Nama Tanaman</label>
                <input type="text" class="form-control" id="nama_tanaman" value="<?= esc($jenis_tanaman['nama_tanaman']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" rows="3" readonly><?= esc($jenis_tanaman['deskripsi']) ?></textarea>
            </div>
            <a href="<?= base_url('petani/jenis_tanaman') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
