<?= $this->include('layout/header') ?>

<style>
    .report-container {
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #333;
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
    }
    .report-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .report-header h2 {
        margin: 0;
        font-size: 24px;
        color: #2c3e50;
    }
    .report-header p {
        margin: 5px 0;
        font-size: 16px;
    }
    .report-content h3 {
        font-size: 18px;
        color: #3498db;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .summary-table {
        width: 100%;
        margin-bottom: 30px;
    }
    .summary-table td {
        padding: 10px;
        font-size: 16px;
    }
    .summary-table .label {
        font-weight: bold;
    }
    .profit { color: #27ae60; font-weight: bold; }
    .loss { color: #c0392b; font-weight: bold; }
    .total-row td {
        font-weight: bold;
        background-color: #f2f2f2;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4 no-print">
        <div class="card-body">
            <form method="get" action="<?= base_url('petani/laporan') ?>" class="d-flex flex-wrap align-items-end gap-3">
                
                <div class="flex-grow-1">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= esc($startDate) ?>">
                </div>

                <div class="flex-grow-1">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= esc($endDate) ?>">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Terapkan</button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button type="button" onclick="printReport()" class="btn btn-outline-secondary"><i class="fas fa-print"></i> Cetak</button>
                    <div class="btn-group">
                        <a href="<?= base_url('petani/laporan/export_pdf?start_date='.$startDate.'&end_date='.$endDate) ?>" target="_blank" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> PDF</a>
                        <a href="<?= base_url('petani/laporan/export_excel?start_date='.$startDate.'&end_date='.$endDate) ?>" class="btn btn-outline-success"><i class="fas fa-file-excel"></i> Excel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Report Display -->
    <div id="printable-area" class="report-container">
        <div class="report-header">
            <h2>Laporan Keuangan Pertanian</h2>
            <p>Periode: <?= esc(date('d F Y', strtotime($startDate))) ?> s/d <?= esc(date('d F Y', strtotime($endDate))) ?></p>
        </div>

        <div class="report-content">
            <h3>Ringkasan Keuangan</h3>
            <table class="table table-bordered summary-table">
                <tr>
                    <td class="label">Total Pendapatan</td>
                    <td>Rp <?= number_format($totalPendapatan, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="label">Total Pengeluaran</td>
                    <td>Rp <?= number_format($totalPengeluaran, 2, ',', '.') ?></td>
                </tr>
                <tr class="total-row">
                    <td class="label">Hasil Akhir (Profit/Loss)</td>
                    <td class="<?= $profit_loss >= 0 ? 'profit' : 'loss' ?>">Rp <?= number_format($profit_loss, 2, ',', '.') ?></td>
                </tr>
            </table>

            <h3>Rincian Pendapatan</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Tanaman</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendapatan)) : ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data pendapatan.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pendapatan as $item) : ?>
                            <tr>
                                <td><?= esc(date('d-m-Y', strtotime($item['tanggal']))) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td class="text-right">Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4">Total Pendapatan</td>
                        <td class="text-right">Rp <?= number_format($totalPendapatan, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>

            <h3>Rincian Pengeluaran</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Tanaman</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengeluaran)) : ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data pengeluaran.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pengeluaran as $item) : ?>
                            <tr>
                                <td><?= esc(date('d-m-Y', strtotime($item['tanggal']))) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td class="text-right">Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4">Total Pengeluaran</td>
                        <td class="text-right">Rp <?= number_format($totalPengeluaran, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>

            <h3>Ringkasan Pengeluaran per Tanaman</h3>
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Tanaman</th>
                        <th class="text-right">Total Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengeluaranByTanaman)) : ?>
                        <tr><td colspan="2" class="text-center">Tidak ada data pengeluaran per tanaman.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pengeluaranByTanaman as $tanaman => $total) : ?>
                            <tr>
                                <td><?= esc($tanaman) ?></td>
                                <td class="text-right">Rp <?= number_format($total, 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>

<script>
    function printReport() {
        window.print();
    }
</script>