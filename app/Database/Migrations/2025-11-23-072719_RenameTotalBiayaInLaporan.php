<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameTotalBiayaInLaporan extends Migration
{
    public function up()
    {
        $fields = [
            'total_biaya' => [
                'name' => 'total_pengeluaran',
                'type' => 'DOUBLE',
            ],
        ];
        $this->forge->modifyColumn('laporan_pertanian', $fields);
    }

    public function down()
    {
        $fields = [
            'total_pengeluaran' => [
                'name' => 'total_biaya',
                'type' => 'DOUBLE',
            ],
        ];
        $this->forge->modifyColumn('laporan_pertanian', $fields);
    }
}