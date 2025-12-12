<?= $this->include('layout/header') ?>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('petani/panen/new') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Hasil Panen</a>
    </div>
    <table class="table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanaman</th>
                <th>Musim Tanam</th>
                <th>Tanggal Panen</th>
                <th>Jumlah (kg)</th>
                <th>Harga per Kg</th>
                <th>Total Pendapatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($hasil_panen as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_tanaman']) ?></td>
                    <td><?= esc($row['periode_awal']) ?> - <?= esc($row['periode_akhir']) ?></td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><?= esc($row['jumlah']) ?></td>
                    <td>Rp <?= number_format($row['harga_per_kg'], 2, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['total_pendapatan'], 2, ',', '.') ?></td>
                    <td>
                        <a href="<?= base_url('petani/panen/' . $row['id_panen'] . '/edit') ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="<?= base_url('petani/panen/' . $row['id_panen']) ?>" method="post" class="d-inline" onsubmit="confirmDelete(event);">
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