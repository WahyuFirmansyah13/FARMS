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
        <form action="<?= base_url('petani/aktivitas') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_musim" class="form-label">Musim Tanam</label>
                <select class="form-select" id="id_musim" name="id_musim" required>
                    <option value="">Pilih Musim Tanam</option>
                    <?php foreach ($musim_tanam as $musim) : ?>
                        <option value="<?= $musim['id_musim'] ?>" data-id-tanaman="<?= $musim['id_tanaman'] ?>" <?= (old('id_musim') == $musim['id_musim']) ? 'selected' : '' ?>><?= esc($musim['nama_tanaman']) ?> (<?= esc($musim['periode_awal']) ?> - <?= esc($musim['periode_akhir']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="id_tanaman" id="id_tanaman" value="<?= old('id_tanaman') ?>">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Aktivitas</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Jenis Aktivitas</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= old('kegiatan') ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= old('keterangan') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('petani/aktivitas') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const musimSelect = document.getElementById('id_musim');
    const tanamanInput = document.getElementById('id_tanaman');

    function updateTanamanId() {
        const selectedOption = musimSelect.options[musimSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            tanamanInput.value = selectedOption.getAttribute('data-id-tanaman');
        } else {
            tanamanInput.value = '';
        }
    }

    // Set initial value on page load
    updateTanamanId();

    // Update when selection changes
    musimSelect.addEventListener('change', updateTanamanId);
});
</script>

<?= $this->include('layout/footer') ?>
