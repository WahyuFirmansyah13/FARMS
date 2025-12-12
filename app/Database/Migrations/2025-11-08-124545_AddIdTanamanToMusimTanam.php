<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdTanamanToMusimTanam extends Migration
{
    public function up()
    {
        $this->forge->addColumn('musim_tanam', [
            'id_tanaman' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'after' => 'id_user'],
        ]);
        $this->forge->addForeignKey('id_tanaman', 'jenis_tanaman', 'id_tanaman', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('musim_tanam', 'musim_tanam_id_tanaman_foreign');
        $this->forge->dropColumn('musim_tanam', 'id_tanaman');
    }
}