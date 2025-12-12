<?= $this->include('layout/header') ?>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('petani/aktivitas/new') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Aktivitas</a>
    </div>
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Musim Tanam</th>
                <th>Tanggal</th>
                <th>Jenis Aktivitas</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($aktivitas as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_tanaman']) ?> (<?= esc($row['periode_awal']) ?> - <?= esc($row['periode_akhir']) ?>)</td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><?= esc($row['kegiatan']) ?></td>
                    <td><?= esc($row['keterangan']) ?></td>
                    <td>
                        <a href="<?= base_url('petani/aktivitas/' . $row['id_aktivitas'] . '/edit') ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="<?= base_url('petani/aktivitas/' . $row['id_aktivitas']) ?>" method="post" class="d-inline" onsubmit="confirmDelete(event);">
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