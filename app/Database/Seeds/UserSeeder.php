<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'username' => 'budi',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'dwii',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'nyimas_sopiah',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'Adonan',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'asep',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'rehan',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'bugito',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'cipa',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
            [
                'username' => 'wahyue',
                'password' => password_hash('petani123', PASSWORD_DEFAULT),
                'role' => 'petani',
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}