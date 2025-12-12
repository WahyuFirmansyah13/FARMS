<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanPertanianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_laporan'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'periode'           => ['type' => 'VARCHAR', 'constraint' => 50],
            'total_biaya'       => ['type' => 'DOUBLE'],
            'total_pendapatan'  => ['type' => 'DOUBLE'],
            'file_laporan'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_laporan', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('laporan_pertanian');
    }

    public function down()
    {
        $this->forge->dropTable('laporan_pertanian');
    }
}