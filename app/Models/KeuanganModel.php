<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table = 'keuangan_pertanian';
    protected $primaryKey = 'id_keuangan';
    protected $allowedFields = ['id_user', 'id_aktivitas', 'id_panen', 'id_tanaman', 'tanggal', 'jenis_transaksi', 'kategori', 'nominal', 'keterangan', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}