<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pertanian</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .content {
            margin-top: 30px;
        }
        h2 {
            font-size: 18px;
            color: #3498db;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .summary-table th, .summary-table td {
            border: none;
            padding: 10px;
            font-size: 14px;
        }
        .summary-table .label {
            font-weight: bold;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .profit {
            color: #27ae60;
        }
        .loss {
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Keuangan Pertanian</h1>
            <p>Periode: <?= esc(explode('_', $laporan['periode'])[0]) ?> s/d <?= esc(explode('_', $laporan['periode'])[1]) ?></p>
        </div>

        <div class="content">
            <h2>Ringkasan Keuangan</h2>
            <table class="summary-table">
                <tr>
                    <td class="label">Total Pendapatan</td>
                    <td>:</td>
                    <td>Rp <?= number_format($totalPendapatan, 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="label">Total Pengeluaran</td>
                    <td>:</td>
                    <td>Rp <?= number_format($totalPengeluaran, 2, ',', '.') ?></td>
                </tr>
                <tr class="total-row">
                    <td class="label">Hasil Akhir (Profit/Loss)</td>
                    <td>:</td>
                    <td class="<?= $profit_loss >= 0 ? 'profit' : 'loss' ?>">Rp <?= number_format($profit_loss, 2, ',', '.') ?></td>
                </tr>
            </table>

            <h2>Rincian Pendapatan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tanaman</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendapatan)) : ?>
                        <tr><td colspan="5" style="text-align:center;">Tidak ada data pendapatan.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pendapatan as $item) : ?>
                            <tr>
                                <td><?= esc($item['tanggal']) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td>Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4">Total Pendapatan</td>
                        <td>Rp <?= number_format($totalPendapatan, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>

            <h2>Rincian Pengeluaran</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tanaman</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengeluaran)) : ?>
                        <tr><td colspan="5" style="text-align:center;">Tidak ada data pengeluaran.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pengeluaran as $item) : ?>
                            <tr>
                                <td><?= esc($item['tanggal']) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td>Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4">Total Pengeluaran</td>
                        <td>Rp <?= number_format($totalPengeluaran, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>

            <h2>Ringkasan Pengeluaran per Tanaman</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanaman</th>
                        <th>Total Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengeluaranByTanaman)) : ?>
                        <tr><td colspan="2" style="text-align:center;">Tidak ada data pengeluaran per tanaman.</td></tr>
                    <?php else : ?>
                        <?php foreach ($pengeluaranByTanaman as $tanaman => $total) : ?>
                            <tr>
                                <td><?= esc($tanaman) ?></td>
                                <td>Rp <?= number_format($total, 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
