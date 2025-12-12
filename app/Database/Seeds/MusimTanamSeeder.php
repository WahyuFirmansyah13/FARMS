<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MusimTanamSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'nama_musim' => 'Musim Tanam I',
                'periode_awal' => '2023-01-01',
                'periode_akhir' => '2023-06-30',
                'keterangan' => 'Musim tanam pertama tahun 2023',
            ],
            [
                'id_user' => 2,
                'nama_musim' => 'Musim Tanam II',
                'periode_awal' => '2023-07-01',
                'periode_akhir' => '2023-12-31',
                'keterangan' => 'Musim tanam kedua tahun 2023',
            ],
            [
                'id_user' => 3,
                'nama_musim' => 'Musim Tanam I',
                'periode_awal' => '2023-01-01',
                'periode_akhir' => '2023-06-30',
                'keterangan' => 'Musim tanam pertama tahun 2023',
            ],
        ];

        $this->db->table('musim_tanam')->insertBatch($data);
    }
}