<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAktivitasPertanianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_aktivitas'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_tanaman'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_musim'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal'        => ['type' => 'DATE'],
            'kegiatan'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan'     => ['type' => 'TEXT'],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_aktivitas', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tanaman', 'jenis_tanaman', 'id_tanaman', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_musim', 'musim_tanam', 'id_musim', 'CASCADE', 'CASCADE');
        $this->forge->createTable('aktivitas_pertanian');
    }

    public function down()
    {
        $this->forge->dropTable('aktivitas_pertanian');
    }
}