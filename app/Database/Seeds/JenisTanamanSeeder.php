<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisTanamanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_user' => 2, 'nama_tanaman' => 'Padi', 'deskripsi' => 'Padi sawah'],
            ['id_user' => 2, 'nama_tanaman' => 'Jagung', 'deskripsi' => 'Jagung manis'],
            ['id_user' => 3, 'nama_tanaman' => 'Cabai', 'deskripsi' => 'Cabai rawit'],
            ['id_user' => 3, 'nama_tanaman' => 'Tomat', 'deskripsi' => 'Tomat buah'],
            ['id_user' => 4, 'nama_tanaman' => 'Kacang Panjang', 'deskripsi' => 'Kacang panjang hijau'],
            ['id_user' => 4, 'nama_tanaman' => 'Bawang Merah', 'deskripsi' => 'Bawang merah lokal'],
            ['id_user' => 5, 'nama_tanaman' => 'Singkong', 'deskripsi' => 'Singkong mentega'],
            ['id_user' => 5, 'nama_tanaman' => 'Terong', 'deskripsi' => 'Terong ungu'],
            ['id_user' => 6, 'nama_tanaman' => 'Ketimun', 'deskripsi' => 'Ketimun lalap'],
            ['id_user' => 6, 'nama_tanaman' => 'Melon', 'deskripsi' => 'Melon madu'],
        ];

        $this->db->table('jenis_tanaman')->insertBatch($data);
    }
}