<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateJenisTransaksiInKeuangan extends Migration
{
    public function up()
    {
        $this->db->query("UPDATE keuangan_pertanian SET jenis_transaksi = 'pengeluaran' WHERE jenis_transaksi = 'biaya'");

        $fields = [
            'jenis_transaksi' => [
                'type' => 'ENUM',
                'constraint' => ['pengeluaran', 'pendapatan'],
                'null' => false,
            ],
        ];
        $this->forge->modifyColumn('keuangan_pertanian', $fields);
    }

    public function down()
    {
        $this->db->query("UPDATE keuangan_pertanian SET jenis_transaksi = 'biaya' WHERE jenis_transaksi = 'pengeluaran'");
        
        $fields = [
            'jenis_transaksi' => [
                'type' => 'ENUM',
                'constraint' => ['biaya', 'pendapatan'],
                'null' => false,
            ],
        ];
        $this->forge->modifyColumn('keuangan_pertanian', $fields);
    }
}