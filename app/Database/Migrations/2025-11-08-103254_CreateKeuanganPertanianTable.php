<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeuanganPertanianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_keuangan'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_aktivitas'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_panen'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tanggal'         => ['type' => 'DATE'],
            'jenis_transaksi' => ['type' => 'ENUM', 'constraint' => ['biaya', 'pendapatan']],
            'kategori'        => ['type' => 'ENUM', 'constraint' => ['benih', 'pupuk', 'pestisida', 'upah', 'lainnya']],
            'nominal'         => ['type' => 'DOUBLE'],
            'keterangan'      => ['type' => 'TEXT'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_keuangan', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_aktivitas', 'aktivitas_pertanian', 'id_aktivitas', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_panen', 'hasil_panen', 'id_panen', 'CASCADE', 'SET NULL');
        $this->forge->createTable('keuangan_pertanian');
    }

    public function down()
    {
        $this->forge->dropTable('keuangan_pertanian');
    }
}