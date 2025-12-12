<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKategoriInKeuangan extends Migration
{
    public function up()
    {
        $fields = [
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['benih', 'pupuk', 'pestisida', 'upah', 'lainnya', 'penjualan'],
            ],
        ];
        $this->forge->modifyColumn('keuangan_pertanian', $fields);
    }

    public function down()
    {
        $fields = [
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['benih', 'pupuk', 'pestisida', 'upah', 'lainnya'],
            ],
        ];
        $this->forge->modifyColumn('keuangan_pertanian', $fields);
    }
}