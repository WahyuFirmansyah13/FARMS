<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMusimTanamTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_musim'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_musim'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'periode_awal'   => ['type' => 'DATE'],
            'periode_akhir'  => ['type' => 'DATE'],
            'keterangan'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_musim', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('musim_tanam');
    }

    public function down()
    {
        $this->forge->dropTable('musim_tanam');
    }
}