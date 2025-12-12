<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHasilPanenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_panen'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_tanaman'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_musim'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal'            => ['type' => 'DATE'],
            'jumlah'             => ['type' => 'INT', 'constraint' => 11],
            'harga_per_kg'       => ['type' => 'DOUBLE'],
            'total_pendapatan'   => ['type' => 'DOUBLE'],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_panen', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tanaman', 'jenis_tanaman', 'id_tanaman', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_musim', 'musim_tanam', 'id_musim', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hasil_panen');
    }

    public function down()
    {
        $this->forge->dropTable('hasil_panen');
    }
}