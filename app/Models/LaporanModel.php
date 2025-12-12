<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan_pertanian';
    protected $primaryKey = 'id_laporan';
    protected $allowedFields = ['id_user', 'periode', 'total_pengeluaran', 'total_pendapatan', 'file_laporan', 'created_at'];
    protected $useTimestamps = false;
}