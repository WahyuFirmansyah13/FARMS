<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTanamanToKeuangan extends Migration
{
    public function up()
    {
        $fields = [
            'id_tanaman' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_panen',
            ],
        ];
        $this->forge->addColumn('keuangan_pertanian', $fields);
        $this->forge->addForeignKey('id_tanaman', 'jenis_tanaman', 'id_tanaman', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        $this->forge->dropForeignKey('keuangan_pertanian', 'keuangan_pertanian_id_tanaman_foreign');
        $this->forge->dropColumn('keuangan_pertanian', 'id_tanaman');
    }
}