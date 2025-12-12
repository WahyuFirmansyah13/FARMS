<?php

namespace App\Controllers;

use App\Models\AktivitasModel;
use App\Models\HasilPanenModel;
use App\Models\JenisTanamanModel;
use App\Models\KeuanganModel;
use App\Models\MusimModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function admin()
    {
        $data['title'] = 'Dashboard Admin';
        // TODO: Implement data fetching for admin dashboard
        return view('admin/dashboard', $data);
    }

    public function petani()
    {
        $id_user = session('id_user');
        $data['title'] = 'Dashboard Petani';

        // Load models
        $tanamanModel = new JenisTanamanModel();
        $aktivitasModel = new AktivitasModel();
        $musimModel = new MusimModel();
        $panenModel = new HasilPanenModel();
        $keuanganModel = new KeuanganModel();

        // Fetch data for summary cards
        $data['total_tanaman'] = $tanamanModel->where('id_user', $id_user)->countAllResults();
        
        $first_day_of_month = date('Y-m-01');
        $last_day_of_month  = date('Y-m-t');
        $data['aktivitas_bulan_ini'] = $aktivitasModel->where('id_user', $id_user)
                                                      ->where('tanggal >=', $first_day_of_month)
                                                      ->where('tanggal <=', $last_day_of_month)
                                                      ->countAllResults();
                                                      
        $data['musim_aktif'] = $musimModel->where('id_user', $id_user)
                                          ->where('periode_awal <=', date('Y-m-d'))
                                          ->where('periode_akhir >=', date('Y-m-d'))
                                          ->countAllResults();
        $data['total_panen'] = $panenModel->where('id_user', $id_user)->countAllResults();

        // Fetch data for charts
        // Keuangan Chart (last 6 months)
        $keuanganData = $keuanganModel->select("DATE_FORMAT(tanggal, '%Y-%m') as bulan, jenis_transaksi, SUM(nominal) as total")
                                      ->where('id_user', $id_user)
                                      ->where('tanggal >=', date('Y-m-d', strtotime('-6 months')))
                                      ->groupBy("bulan, jenis_transaksi")
                                      ->orderBy('bulan', 'ASC')
                                      ->findAll();
        
        $chartLabels = [];
        $pendapatanData = [];
        $pengeluaranData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartLabels[] = date('M', strtotime($month));
            $pendapatanData[$month] = 0;
            $pengeluaranData[$month] = 0;
        }

        foreach ($keuanganData as $row) {
            if ($row['jenis_transaksi'] == 'pendapatan') {
                $pendapatanData[$row['bulan']] = (int)$row['total'];
            } else {
                $pengeluaranData[$row['bulan']] = (int)$row['total'];
            }
        }
        $data['chart_keuangan'] = [
            'labels' => $chartLabels,
            'pendapatan' => array_values($pendapatanData),
            'pengeluaran' => array_values($pengeluaranData),
        ];

        // Biaya Composition Chart
        $biayaKategori = $keuanganModel->select('kategori, SUM(nominal) as total')
                                       ->where('id_user', $id_user)
                                       ->where('jenis_transaksi', 'pengeluaran')
                                       ->groupBy('kategori')
                                       ->findAll();

        $data['chart_biaya'] = [
            'labels' => array_column($biayaKategori, 'kategori'),
            'data' => array_column($biayaKategori, 'total'),
        ];

        return view('petani/dashboard', $data);
    }

    public function ping()
    {
        return $this->response->setJSON(['status' => 'ok']);
    }
}