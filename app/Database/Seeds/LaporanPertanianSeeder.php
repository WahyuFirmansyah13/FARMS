<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LaporanPertanianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'periode' => 'Januari - Juni 2023',
                'total_biaya' => 800000,
                'total_pendapatan' => 5000000,
                'file_laporan' => 'laporan-2023-01-06.pdf',
            ],
            [
                'id_user' => 3,
                'periode' => 'Januari - Juni 2023',
                'total_biaya' => 200000,
                'total_pendapatan' => 4000000,
                'file_laporan' => 'laporan-2023-01-06.pdf',
            ],
        ];

        $this->db->table('laporan_pertanian')->insertBatch($data);
    }
}