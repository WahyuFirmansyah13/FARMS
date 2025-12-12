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
        <form action="<?= base_url('petani/laporan/generate') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= old('start_date') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= old('end_date') ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate Laporan</button>
            <a href="<?= base_url('petani/laporan') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>