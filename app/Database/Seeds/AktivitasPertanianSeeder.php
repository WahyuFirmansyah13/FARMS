<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AktivitasPertanianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_tanaman' => 1,
                'id_musim' => 1,
                'tanggal' => '2023-01-15',
                'kegiatan' => 'Penyemaian',
                'keterangan' => 'Penyemaian benih padi',
                'foto' => 'penyemaian.jpg',
            ],
            [
                'id_user' => 2,
                'id_tanaman' => 1,
                'id_musim' => 1,
                'tanggal' => '2023-02-01',
                'kegiatan' => 'Pengolahan Lahan',
                'keterangan' => 'Pengolahan lahan sawah',
                'foto' => 'pengolahan_lahan.jpg',
            ],
            [
                'id_user' => 2,
                'id_tanaman' => 1,
                'id_musim' => 1,
                'tanggal' => '2023-02-15',
                'kegiatan' => 'Penanaman',
                'keterangan' => 'Penanaman bibit padi',
                'foto' => 'penanaman.jpg',
            ],
            [
                'id_user' => 2,
                'id_tanaman' => 1,
                'id_musim' => 1,
                'tanggal' => '2023-03-01',
                'kegiatan' => 'Pemupukan',
                'keterangan' => 'Pemupukan pertama',
                'foto' => 'pemupukan.jpg',
            ],
            [
                'id_user' => 3,
                'id_tanaman' => 3,
                'id_musim' => 3,
                'tanggal' => '2023-01-20',
                'kegiatan' => 'Penyemaian',
                'keterangan' => 'Penyemaian benih cabai',
                'foto' => 'penyemaian_cabai.jpg',
            ],
            [
                'id_user' => 3,
                'id_tanaman' => 3,
                'id_musim' => 3,
                'tanggal' => '2023-02-10',
                'kegiatan' => 'Penanaman',
                'keterangan' => 'Penanaman bibit cabai',
                'foto' => 'penanaman_cabai.jpg',
            ],
        ];

        $this->db->table('aktivitas_pertanian')->insertBatch($data);
    }
}