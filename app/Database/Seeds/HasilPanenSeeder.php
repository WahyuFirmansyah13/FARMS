<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HasilPanenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_tanaman' => 1,
                'id_musim' => 1,
                'tanggal' => '2023-05-20',
                'jumlah' => 1000,
                'harga_per_kg' => 5000,
                'total_pendapatan' => 5000000,
            ],
            [
                'id_user' => 2,
                'id_tanaman' => 2,
                'id_musim' => 2,
                'tanggal' => '2023-10-15',
                'jumlah' => 1500,
                'harga_per_kg' => 3000,
                'total_pendapatan' => 4500000,
            ],
            [
                'id_user' => 3,
                'id_tanaman' => 3,
                'id_musim' => 3,
                'tanggal' => '2023-04-10',
                'jumlah' => 200,
                'harga_per_kg' => 20000,
                'total_pendapatan' => 4000000,
            ],
        ];

        $this->db->table('hasil_panen')->insertBatch($data);
    }
}