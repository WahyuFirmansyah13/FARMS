<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_profil'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'alamat'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_profil', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('profil');
    }

    public function down()
    {
        $this->forge->dropTable('profil');
    }
}