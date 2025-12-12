<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProfilSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'nama' => 'Admin',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567890',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 2,
                'nama' => 'Budi',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567891',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 3,
                'nama' => 'Dwi',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567892',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 4,
                'nama' => 'Nyimas Sopiah',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567893',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 5,
                'nama' => 'Adonan',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567894',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 6,
                'nama' => 'Asep',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567895',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 7,
                'nama' => 'Rehan',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567896',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 8,
                'nama' => 'Bugito',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567897',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 9,
                'nama' => 'Cipa',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567898',
                'foto' => 'default.jpg',
            ],
            [
                'id_user' => 10,
                'nama' => 'Wahyue',
                'alamat' => 'Desa Bubusan',
                'no_hp' => '081234567899',
                'foto' => 'default.jpg',
            ],
        ];

        $this->db->table('profil')->insertBatch($data);
    }
}