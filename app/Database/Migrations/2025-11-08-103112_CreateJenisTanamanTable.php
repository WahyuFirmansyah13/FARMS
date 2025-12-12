<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisTanamanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tanaman'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_tanaman'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_tanaman', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jenis_tanaman');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_tanaman');
    }
}