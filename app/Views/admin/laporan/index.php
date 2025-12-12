<?= $this->include('layout/header') ?>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('admin/laporan/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Laporan Baru</a>
    </div>
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>ID User</th>
                <th>Periode</th>
                <th>Total Pengeluaran</th>
                <th>Total Pendapatan</th>
                <th>File Laporan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($laporan as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['id_user']) ?></td>
                    <td><?= esc($row['periode']) ?></td>
                    <td>Rp <?= esc(number_format($row['total_pengeluaran'], 0, ',', '.')) ?></td>
                    <td>Rp <?= esc(number_format($row['total_pendapatan'], 0, ',', '.')) ?></td>
                    <td><?= esc($row['file_laporan']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/laporan/export_pdf/' . $row['id_laporan']) ?>" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a>
                        <a href="<?= base_url('admin/laporan/export_excel/' . $row['id_laporan']) ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i></a>
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