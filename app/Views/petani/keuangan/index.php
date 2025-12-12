<?= $this->include('layout/header') ?>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('petani/keuangan/new') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
    </div>
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Kategori</th>
                <th>Tanaman</th>
                <th>Deskripsi</th>
                <th>Nominal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($keuangan as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td>
                        <?php if ($row['jenis_transaksi'] == 'pendapatan') : ?>
                            <span class="badge bg-success">Pendapatan</span>
                        <?php else : ?>
                            <span class="badge bg-danger">Pengeluaran</span>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($row['kategori']) ?></td>
                    <td><?= esc($row['nama_tanaman'] ?? '-') ?></td>
                    <td><?= esc($row['keterangan']) ?></td>
                    <td>Rp <?= esc(number_format($row['nominal'], 0, ',', '.')) ?></td>
                    <td>
                        <a href="<?= base_url('petani/keuangan/' . $row['id_keuangan'] . '/edit') ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="<?= base_url('petani/keuangan/' . $row['id_keuangan']) ?>" method="post" class="d-inline" onsubmit="confirmDelete(event);">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('layout/footer') ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>