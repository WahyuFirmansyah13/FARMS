<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KeuanganPertanianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_aktivitas' => 1,
                'id_panen' => null,
                'tanggal' => '2023-01-15',
                'jenis_transaksi' => 'biaya',
                'kategori' => 'benih',
                'nominal' => 500000,
                'keterangan' => 'Pembelian benih padi',
            ],
            [
                'id_user' => 2,
                'id_aktivitas' => 4,
                'id_panen' => null,
                'tanggal' => '2023-03-01',
                'jenis_transaksi' => 'biaya',
                'kategori' => 'pupuk',
                'nominal' => 300000,
                'keterangan' => 'Pembelian pupuk urea',
            ],
            [
                'id_user' => 2,
                'id_aktivitas' => null,
                'id_panen' => 1,
                'tanggal' => '2023-05-20',
                'jenis_transaksi' => 'pendapatan',
                'kategori' => 'lainnya',
                'nominal' => 5000000,
                'keterangan' => 'Hasil panen padi',
            ],
            [
                'id_user' => 3,
                'id_aktivitas' => 5,
                'id_panen' => null,
                'tanggal' => '2023-01-20',
                'jenis_transaksi' => 'biaya',
                'kategori' => 'benih',
                'nominal' => 200000,
                'keterangan' => 'Pembelian benih cabai',
            ],
            [
                'id_user' => 3,
                'id_aktivitas' => null,
                'id_panen' => 3,
                'tanggal' => '2023-04-10',
                'jenis_transaksi' => 'pendapatan',
                'kategori' => 'lainnya',
                'nominal' => 4000000,
                'keterangan' => 'Hasil panen cabai',
            ],
        ];

        $this->db->table('keuangan_pertanian')->insertBatch($data);
    }
}