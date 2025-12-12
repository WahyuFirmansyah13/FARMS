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
        <form action="<?= base_url('petani/keuangan/' . $keuangan['id_keuangan']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
               <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                <select class="form-select" id="jenis_transaksi" name="jenis_transaksi" required>
                    <option value="">Pilih Jenis Transaksi</option>
                    <option value="pendapatan" <?= (old('jenis_transaksi', $keuangan['jenis_transaksi']) == 'pendapatan') ? 'selected' : '' ?>>Pendapatan</option>
                    <option value="pengeluaran" <?= (old('jenis_transaksi', $keuangan['jenis_transaksi']) == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <!-- Options populated by JS -->
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tanaman" class="form-label">Tanaman</label>
                <select class="form-select" id="id_tanaman" name="id_tanaman">
                    <option value="">Pilih Tanaman (Opsional)</option>
                    <?php foreach ($jenis_tanaman as $tanaman) : ?>
                        <option value="<?= $tanaman['id_tanaman'] ?>" <?= (old('id_tanaman', $keuangan['id_tanaman']) == $tanaman['id_tanaman']) ? 'selected' : '' ?>><?= esc($tanaman['nama_tanaman']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= old('keterangan', $keuangan['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal</label>
                <input type="number" class="form-control" id="nominal" name="nominal" value="<?= old('nominal', $keuangan['nominal']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('petani/keuangan') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisTransaksiSelect = document.getElementById('jenis_transaksi');
    const kategoriSelect = document.getElementById('kategori');
    const oldKategori = '<?= old('kategori', $keuangan['kategori']) ?>';

    const kategoriOptions = {
        pendapatan: [
            { value: 'penjualan', text: 'Penjualan' }
        ],
        pengeluaran: [
            { value: 'benih', text: 'Benih' },
            { value: 'pupuk', text: 'Pupuk' },
            { value: 'pestisida', text: 'Pestisida' },
            { value: 'upah', text: 'Upah' },
            { value: 'lainnya', text: 'Lainnya' }
        ]
    };

    function updateKategoriOptions() {
        const selectedJenis = jenisTransaksiSelect.value;
        kategoriSelect.innerHTML = ''; // Clear existing options

        if (kategoriOptions[selectedJenis]) {
            kategoriOptions[selectedJenis].forEach(optionData => {
                const option = new Option(optionData.text, optionData.value);
                if (optionData.value === oldKategori) {
                    option.selected = true;
                }
                kategoriSelect.add(option);
            });
            kategoriSelect.parentElement.style.display = 'block';
        } else {
            kategoriSelect.parentElement.style.display = 'none';
        }
    }

    jenisTransaksiSelect.addEventListener('change', updateKategoriOptions);

    // Set initial state on page load
    updateKategoriOptions();
});
</script>

<?= $this->include('layout/footer') ?>