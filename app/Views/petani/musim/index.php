<?= $this->include('layout/header') ?>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('petani/musim/new') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Musim Tanam</a>
    </div>
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Tanaman</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($musim as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_tanaman']) ?></td>
                    <td><?= esc($row['periode_awal']) ?></td>
                    <td><?= esc($row['periode_akhir']) ?></td>
                    <td>
                        <?php
                            $status = 'Aktif';
                            $badge_class = 'bg-success';
                            if (strtotime($row['periode_akhir']) < time()) {
                                $status = 'Selesai';
                                $badge_class = 'bg-secondary';
                            } elseif (strtotime($row['periode_awal']) > time()) {
                                $status = 'Mendatang';
                                $badge_class = 'bg-warning text-dark';
                            }
                        ?>
                        <span class="badge <?= $badge_class ?>"><?= $status ?></span>
                    </td>
                    <td>
                        <a href="<?= base_url('petani/musim/' . $row['id_musim'] . '/edit') ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="<?= base_url('petani/musim/' . $row['id_musim']) ?>" method="post" class="d-inline" onsubmit="confirmDelete(event);">
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