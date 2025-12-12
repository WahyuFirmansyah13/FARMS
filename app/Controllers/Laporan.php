<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\KeuanganModel;
use App\Models\HasilPanenModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends Controller
{
    // Petani methods
    public function index()
    {
        $keuanganModel = new KeuanganModel();
        $data['title'] = 'Laporan Keuangan';

        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        $pendapatan = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                    ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                    ->where('keuangan_pertanian.id_user', session('id_user'))
                                    ->where('jenis_transaksi', 'pendapatan')
                                    ->where('tanggal >=', $startDate)
                                    ->where('tanggal <=', $endDate)
                                    ->findAll();

        $pengeluaran = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                     ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                     ->where('keuangan_pertanian.id_user', session('id_user'))
                                     ->where('jenis_transaksi', 'pengeluaran')
                                     ->where('tanggal >=', $startDate)
                                     ->where('tanggal <=', $endDate)
                                     ->findAll();

        $totalPendapatan = array_sum(array_column($pendapatan, 'nominal'));
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));
        $profit_loss = $totalPendapatan - $totalPengeluaran;

        $pengeluaranByTanaman = [];
        foreach ($pengeluaran as $item) {
            $tanaman = $item['nama_tanaman'] ?? 'Lainnya';
            if (!isset($pengeluaranByTanaman[$tanaman])) {
                $pengeluaranByTanaman[$tanaman] = 0;
            }
            $pengeluaranByTanaman[$tanaman] += $item['nominal'];
        }

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['pendapatan'] = $pendapatan;
        $data['pengeluaran'] = $pengeluaran;
        $data['totalPendapatan'] = $totalPendapatan;
        $data['totalPengeluaran'] = $totalPengeluaran;
        $data['profit_loss'] = $profit_loss;
        $data['pengeluaranByTanaman'] = $pengeluaranByTanaman;

        return view('petani/laporan/index', $data);
    }

    public function exportPdf()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if (empty($startDate) || empty($endDate)) {
            session()->setFlashdata('error', 'Periode tidak valid. Silakan pilih tanggal mulai dan selesai.');
            return redirect()->to('/petani/laporan');
        }

        $keuanganModel = new KeuanganModel();

        // Fetch income
        $pendapatan = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                    ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                    ->where('keuangan_pertanian.id_user', session('id_user'))
                                    ->where('jenis_transaksi', 'pendapatan')
                                    ->where('tanggal >=', $startDate)
                                    ->where('tanggal <=', $endDate)
                                    ->findAll();

        // Fetch expenses
        $pengeluaran = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                     ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                     ->where('keuangan_pertanian.id_user', session('id_user'))
                                     ->where('jenis_transaksi', 'pengeluaran')
                                     ->where('tanggal >=', $startDate)
                                     ->where('tanggal <=', $endDate)
                                     ->findAll();

        $totalPendapatan = array_sum(array_column($pendapatan, 'nominal'));
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));
        $profit_loss = $totalPendapatan - $totalPengeluaran;

        $pengeluaranByTanaman = [];
        foreach ($pengeluaran as $item) {
            $tanaman = $item['nama_tanaman'] ?? 'Lainnya';
            if (!isset($pengeluaranByTanaman[$tanaman])) {
                $pengeluaranByTanaman[$tanaman] = 0;
            }
            $pengeluaranByTanaman[$tanaman] += $item['nominal'];
        }

        $data = [
            'laporan' => ['periode' => $startDate . '_' . $endDate],
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'profit_loss' => $profit_loss,
            'pengeluaranByTanaman' => $pengeluaranByTanaman,
        ];

        $html = view('petani/laporan/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'laporan_petani_' . $startDate . '_' . $endDate . '.pdf';
        $dompdf->stream($fileName, ['Attachment' => false]); // stream to browser
    }

    public function exportExcel()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if (empty($startDate) || empty($endDate)) {
            session()->setFlashdata('error', 'Periode tidak valid. Silakan pilih tanggal mulai dan selesai.');
            return redirect()->to('/petani/laporan');
        }
        
        $keuanganModel = new KeuanganModel();

        // Fetch data
        $pendapatan = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                    ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                    ->where('keuangan_pertanian.id_user', session('id_user'))
                                    ->where('jenis_transaksi', 'pendapatan')
                                    ->where('tanggal >=', $startDate)
                                    ->where('tanggal <=', $endDate)
                                    ->findAll();
        $pengeluaran = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                     ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                     ->where('keuangan_pertanian.id_user', session('id_user'))
                                     ->where('jenis_transaksi', 'pengeluaran')
                                     ->where('tanggal >=', $startDate)
                                     ->where('tanggal <=', $endDate)
                                     ->findAll();

        $totalPendapatan = array_sum(array_column($pendapatan, 'nominal'));
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));
        $profit_loss = $totalPendapatan - $totalPengeluaran;

        $pengeluaranByTanaman = [];
        foreach ($pengeluaran as $item) {
            $tanaman = $item['nama_tanaman'] ?? 'Lainnya';
            if (!isset($pengeluaranByTanaman[$tanaman])) {
                $pengeluaranByTanaman[$tanaman] = 0;
            }
            $pengeluaranByTanaman[$tanaman] += $item['nominal'];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Styling
        $headerStyle = ['font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF3498DB']], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
        $sectionHeaderStyle = ['font' => ['bold' => true, 'size' => 12]];
        $tableHeaderStyle = ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2F2F2']]];

        // Header
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'Laporan Keuangan Pertanian');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Periode: ' . $startDate . ' s/d ' . $endDate);
        
        $row = 4;

        // Summary
        $sheet->setCellValue('A' . $row, 'Ringkasan Keuangan')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
        $row++;
        $sheet->setCellValue('A' . $row, 'Total Pendapatan');
        $sheet->setCellValue('B' . $row, $totalPendapatan)->getStyle('B' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row++;
        $sheet->setCellValue('A' . $row, 'Total Pengeluaran');
        $sheet->setCellValue('B' . $row, $totalPengeluaran)->getStyle('B' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row++;
        $sheet->setCellValue('A' . $row, 'Hasil Akhir (Profit/Loss)')->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $row, $profit_loss)->getStyle('B' . $row)->applyFromArray(['font' => ['bold' => true]])->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row += 2;

        // Income Details
        $sheet->setCellValue('A' . $row, 'Rincian Pendapatan')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
        $row++;
        $sheet->fromArray(['Tanggal', 'Tanaman', 'Kategori', 'Keterangan', 'Nominal'], null, 'A'.$row);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($tableHeaderStyle);
        $row++;
        foreach ($pendapatan as $item) {
            $sheet->fromArray([$item['tanggal'], $item['nama_tanaman'] ?? 'Tidak spesifik', ucfirst($item['kategori']), $item['keterangan'], $item['nominal']], null, 'A'.$row);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
            $row++;
        }
        $row++;

        // Expense Details
        $sheet->setCellValue('A' . $row, 'Rincian Pengeluaran')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
        $row++;
        $sheet->fromArray(['Tanggal', 'Tanaman', 'Kategori', 'Keterangan', 'Nominal'], null, 'A'.$row);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($tableHeaderStyle);
        $row++;
        foreach ($pengeluaran as $item) {
            $sheet->fromArray([$item['tanggal'], $item['nama_tanaman'] ?? 'Tidak spesifik', ucfirst($item['kategori']), $item['keterangan'], $item['nominal']], null, 'A'.$row);
             $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
            $row++;
        }
        $row++;
        
        // Expenses by Plant Summary
        $sheet->setCellValue('A' . $row, 'Ringkasan Pengeluaran per Tanaman')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
        $row++;
        $sheet->fromArray(['Tanaman', 'Total Pengeluaran'], null, 'A'.$row);
        $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($tableHeaderStyle);
        $row++;
        foreach ($pengeluaranByTanaman as $tanaman => $total) {
            $sheet->fromArray([$tanaman, $total], null, 'A'.$row);
            $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
            $row++;
        }
        
        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_petani_' . $startDate . '_' . $endDate . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        exit();
    }

    // Admin methods
    public function index_admin()
    {
        $model = new LaporanModel();
        $data['title'] = 'Laporan (Admin)';
        $data['laporan'] = $model->findAll();
        return view('admin/laporan/index', $data);
    }

    public function create_admin()
    {
        $data['title'] = 'Buat Laporan (Admin)';
        return view('admin/laporan/create', $data);
    }

    public function generate_admin()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        if (empty($startDate) || empty($endDate) || $endDate < $startDate) {
            session()->setFlashdata('error', 'Periode tidak valid. Tanggal selesai harus setelah tanggal mulai.');
            return redirect()->back()->withInput();
        }
        
        $periode = $startDate . '_' . $endDate;

        $keuanganModel = new KeuanganModel();

        $pengeluaran = $keuanganModel->where('jenis_transaksi', 'pengeluaran')
                                     ->where('tanggal >=', $startDate)
                                     ->where('tanggal <=', $endDate)
                                     ->selectSum('nominal')
                                     ->first();

        $pendapatan = $keuanganModel->where('jenis_transaksi', 'pendapatan')
                                    ->where('tanggal >=', $startDate)
                                    ->where('tanggal <=', $endDate)
                                    ->selectSum('nominal')
                                    ->first();

        $totalPengeluaran = $pengeluaran['nominal'] ?? 0;
        $totalPendapatan = $pendapatan['nominal'] ?? 0;

        $laporanModel = new LaporanModel();
        $laporanData = [
            'id_user' => session('id_user'), // Admin who generated the report
            'periode' => $periode,
            'total_pengeluaran' => $totalPengeluaran,
            'total_pendapatan' => $totalPendapatan,
            'file_laporan' => '',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $laporanModel->save($laporanData);

        session()->setFlashdata('success', 'Laporan admin berhasil digenerate.');
        return redirect()->to('/admin/laporan');
    }

    public function exportPdf_admin($laporanId)
    {
        $laporanModel = new LaporanModel();
        $laporan = $laporanModel->find($laporanId);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        list($startDate, $endDate) = explode('_', $laporan['periode']);
        $keuanganModel = new KeuanganModel();
        $userModel = new UserModel();

        // Fetch all financial data for the period
        $allData = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman, users.username')
                                 ->join('users', 'users.id_user = keuangan_pertanian.id_user')
                                 ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                 ->where('tanggal >=', $startDate)
                                 ->where('tanggal <=', $endDate)
                                 ->orderBy('keuangan_pertanian.id_user, tanggal', 'ASC')
                                 ->findAll();

        $laporanData = [
            'users' => [],
            'grandTotalPendapatan' => 0,
            'grandTotalPengeluaran' => 0,
        ];

        foreach ($allData as $item) {
            $userId = $item['id_user'];
            if (!isset($laporanData['users'][$userId])) {
                $laporanData['users'][$userId] = [
                    'username' => $item['username'],
                    'pendapatan' => [],
                    'pengeluaran' => [],
                    'totalPendapatan' => 0,
                    'totalPengeluaran' => 0,
                ];
            }

            if ($item['jenis_transaksi'] == 'pendapatan') {
                $laporanData['users'][$userId]['pendapatan'][] = $item;
                $laporanData['users'][$userId]['totalPendapatan'] += $item['nominal'];
                $laporanData['grandTotalPendapatan'] += $item['nominal'];
            } else {
                $laporanData['users'][$userId]['pengeluaran'][] = $item;
                $laporanData['users'][$userId]['totalPengeluaran'] += $item['nominal'];
                $laporanData['grandTotalPengeluaran'] += $item['nominal'];
            }
        }

        $data = [
            'laporan' => $laporan,
            'laporanData' => $laporanData,
        ];

        $html = view('admin/laporan/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'laporan_admin_' . $laporan['periode'] . '_' . $laporanId . '.pdf';
        $filePath = ROOTPATH . 'public/reports/' . $fileName;
        file_put_contents($filePath, $dompdf->output());

        return $this->response->download($filePath, null)->setFileName($fileName);
    }

    public function exportExcel_admin($laporanId)
    {
        $laporanModel = new LaporanModel();
        $laporan = $laporanModel->find($laporanId);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        list($startDate, $endDate) = explode('_', $laporan['periode']);
        $keuanganModel = new KeuanganModel();
        $userModel = new UserModel();

        $allData = $keuanganModel->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman, users.username')
                                 ->join('users', 'users.id_user = keuangan_pertanian.id_user')
                                 ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                 ->where('tanggal >=', $startDate)
                                 ->where('tanggal <=', $endDate)
                                 ->orderBy('keuangan_pertanian.id_user, tanggal', 'ASC')
                                 ->findAll();

        $laporanData = [
            'users' => [],
            'grandTotalPendapatan' => 0,
            'grandTotalPengeluaran' => 0,
        ];

        foreach ($allData as $item) {
            $userId = $item['id_user'];
            if (!isset($laporanData['users'][$userId])) {
                $laporanData['users'][$userId] = [
                    'username' => $item['username'],
                    'pendapatan' => [],
                    'pengeluaran' => [],
                    'totalPendapatan' => 0,
                    'totalPengeluaran' => 0,
                ];
            }

            if ($item['jenis_transaksi'] == 'pendapatan') {
                $laporanData['users'][$userId]['pendapatan'][] = $item;
                $laporanData['users'][$userId]['totalPendapatan'] += $item['nominal'];
                $laporanData['grandTotalPendapatan'] += $item['nominal'];
            } else {
                $laporanData['users'][$userId]['pengeluaran'][] = $item;
                $laporanData['users'][$userId]['totalPengeluaran'] += $item['nominal'];
                $laporanData['grandTotalPengeluaran'] += $item['nominal'];
            }
        }
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Styling
        $headerStyle = ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
        $subHeaderStyle = ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
        $sectionHeaderStyle = ['font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FF3498DB']]];
        $userSectionStyle = ['font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF2980B9']]];
        $tableHeaderStyle = ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2F2F2']]];
        $totalRowStyle = ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEBF5FB']]];

        // Main Header
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'Laporan Keuangan Pertanian (Admin)');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Periode: ' . $startDate . ' s/d ' . $endDate);
        $sheet->getStyle('A2')->applyFromArray($subHeaderStyle);
        
        $row = 4;

        // Grand Total Summary
        $sheet->setCellValue('A' . $row, 'Ringkasan Total (Semua Petani)')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
        $row++;
        $sheet->setCellValue('A' . $row, 'Total Pendapatan');
        $sheet->setCellValue('B' . $row, $laporanData['grandTotalPendapatan'])->getStyle('B' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row++;
        $sheet->setCellValue('A' . $row, 'Total Pengeluaran');
        $sheet->setCellValue('B' . $row, $laporanData['grandTotalPengeluaran'])->getStyle('B' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row++;
        $sheet->setCellValue('A' . $row, 'Hasil Akhir (Profit/Loss)')->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $row, $laporanData['grandTotalPendapatan'] - $laporanData['grandTotalPengeluaran'])->getStyle('B' . $row)->applyFromArray($totalRowStyle)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
        $row += 2;

        // Per-User Details
        foreach ($laporanData['users'] as $userId => $userData) {
            $sheet->mergeCells('A' . $row . ':F' . $row);
            $sheet->setCellValue('A' . $row, 'Rincian untuk Petani: ' . $userData['username'])->getStyle('A' . $row)->applyFromArray($userSectionStyle);
            $row+=2;

            // Income
            $sheet->setCellValue('A' . $row, 'Rincian Pendapatan')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
            $row++;
            $sheet->fromArray(['Tanggal', 'Tanaman', 'Kategori', 'Keterangan', 'Nominal'], NULL, 'A' . $row);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($tableHeaderStyle);
            $row++;
            $incomeStartRow = $row;
            foreach($userData['pendapatan'] as $item) {
                $sheet->fromArray([$item['tanggal'], $item['nama_tanaman'] ?? 'Tidak Spesifik', ucfirst($item['kategori']), $item['keterangan'], $item['nominal']], NULL, 'A' . $row);
                $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
                $row++;
            }
            $sheet->setCellValue('D' . $row, 'Total Pendapatan')->getStyle('D' . $row)->getFont()->setBold(true);
            $sheet->setCellValue('E' . $row, "=SUM(E{$incomeStartRow}:E" . ($row - 1) .")")->getStyle('E' . $row)->applyFromArray($totalRowStyle)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
            $row+=2;

            // Expenses
            $sheet->setCellValue('A' . $row, 'Rincian Pengeluaran')->getStyle('A' . $row)->applyFromArray($sectionHeaderStyle);
            $row++;
            $sheet->fromArray(['Tanggal', 'Tanaman', 'Kategori', 'Keterangan', 'Nominal'], NULL, 'A' . $row);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($tableHeaderStyle);
            $row++;
            $expenseStartRow = $row;
            foreach($userData['pengeluaran'] as $item) {
                $sheet->fromArray([$item['tanggal'], $item['nama_tanaman'] ?? 'Tidak Spesifik', ucfirst($item['kategori']), $item['keterangan'], $item['nominal']], NULL, 'A' . $row);
                $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
                $row++;
            }
            $sheet->setCellValue('D' . $row, 'Total Pengeluaran')->getStyle('D' . $row)->getFont()->setBold(true);
            $sheet->setCellValue('E' . $row, "=SUM(E{$expenseStartRow}:E" . ($row - 1) .")")->getStyle('E' . $row)->applyFromArray($totalRowStyle)->getNumberFormat()->setFormatCode('"Rp "#,##0.00');
            $row+=3;
        }

        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_admin_' . $laporan['periode'] . '_' . $laporanId . '.xlsx';
        $filePath = ROOTPATH . 'public/reports/' . $fileName;
        $writer->save($filePath);

        return $this->response->download($filePath, null)->setFileName($fileName);
    }
}
