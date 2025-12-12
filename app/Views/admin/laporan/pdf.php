<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Admin</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .content {
            margin-top: 20px;
        }
        h2 {
            font-size: 18px;
            color: #3498db;
            border-bottom: 1px solid #3498db;
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        h3 {
            font-size: 15px;
            color: #2980b9;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #bdc3c7;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .summary-table {
            width: 60%;
            border: none;
        }
        .summary-table td {
            border: none;
            padding: 6px;
            font-size: 13px;
        }
        .summary-table .label {
            font-weight: bold;
            width: 40%;
        }
        .total-row td {
            font-weight: bold;
            background-color: #ecf0f1;
        }
        .grand-total td {
            font-size: 15px;
            padding: 10px;
            border-top: 2px solid #3498db;
        }
        .profit {
            color: #27ae60;
            font-weight: bold;
        }
        .loss {
            color: #c0392b;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
            font-size: 10px;
            color: #7f8c8d;
        }
        .footer .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>
    <div class="footer">
        <span class="page-number"></span>
    </div>

    <div class="header">
        <h1>Laporan Keuangan Pertanian (Admin)</h1>
        <p>Periode: <?= esc(explode('_', $laporan['periode'])[0]) ?> s/d <?= esc(explode('_', $laporan['periode'])[1]) ?></p>
    </div>

    <div class="content">
        <h2>Ringkasan Total</h2>
        <table class="summary-table">
            <tr>
                <td class="label">Total Pendapatan (Semua Petani)</td>
                <td>:</td>
                <td>Rp <?= number_format($laporanData['grandTotalPendapatan'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="label">Total Pengeluaran (Semua Petani)</td>
                <td>:</td>
                <td>Rp <?= number_format($laporanData['grandTotalPengeluaran'], 2, ',', '.') ?></td>
            </tr>
            <tr class="total-row grand-total">
                <td class="label">Hasil Akhir (Profit/Loss)</td>
                <td>:</td>
                <td class="<?= ($laporanData['grandTotalPendapatan'] - $laporanData['grandTotalPengeluaran']) >= 0 ? 'profit' : 'loss' ?>">
                    Rp <?= number_format($laporanData['grandTotalPendapatan'] - $laporanData['grandTotalPengeluaran'], 2, ',', '.') ?>
                </td>
            </tr>
        </table>

        <?php 
        $userCount = 0;
        foreach ($laporanData['users'] as $userId => $userData) : 
            $userCount++;
        ?>
            <div class="page-break"></div>
            <h2>Rincian Petani: <?= esc($userData['username']) ?></h2>
            
            <h3>Ringkasan Keuangan Petani</h3>
            <table class="summary-table">
                <tr>
                    <td class="label">Total Pendapatan</td>
                    <td>:</td>
                    <td>Rp <?= number_format($userData['totalPendapatan'], 2, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="label">Total Pengeluaran</td>
                    <td>:</td>
                    <td>Rp <?= number_format($userData['totalPengeluaran'], 2, ',', '.') ?></td>
                </tr>
                <tr class="total-row">
                    <td class="label">Hasil Akhir Petani</td>
                    <td>:</td>
                    <td class="<?= ($userData['totalPendapatan'] - $userData['totalPengeluaran']) >= 0 ? 'profit' : 'loss' ?>">
                        Rp <?= number_format($userData['totalPendapatan'] - $userData['totalPengeluaran'], 2, ',', '.') ?>
                    </td>
                </tr>
            </table>

            <h3>Rincian Pendapatan</h3>
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
                    <?php if (empty($userData['pendapatan'])) : ?>
                        <tr><td colspan="5" style="text-align:center;">Tidak ada data.</td></tr>
                    <?php else : ?>
                        <?php foreach ($userData['pendapatan'] as $item) : ?>
                            <tr>
                                <td><?= esc($item['tanggal']) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td style="text-align: right;">Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3>Rincian Pengeluaran</h3>
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
                     <?php if (empty($userData['pengeluaran'])) : ?>
                        <tr><td colspan="5" style="text-align:center;">Tidak ada data.</td></tr>
                    <?php else : ?>
                        <?php foreach ($userData['pengeluaran'] as $item) : ?>
                            <tr>
                                <td><?= esc($item['tanggal']) ?></td>
                                <td><?= esc($item['nama_tanaman'] ?? 'Tidak spesifik') ?></td>
                                <td><?= esc(ucfirst($item['kategori'])) ?></td>
                                <td><?= esc($item['keterangan']) ?></td>
                                <td style="text-align: right;">Rp <?= number_format($item['nominal'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <?php if ($userCount == 0) : ?>
            <p style="text-align:center; margin-top: 50px;">Tidak ada data keuangan untuk ditampilkan pada periode ini.</p>
        <?php endif; ?>
    </div>
</body>
</html>
