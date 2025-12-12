<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilPanenModel extends Model
{
    protected $table = 'hasil_panen';
    protected $primaryKey = 'id_panen';
    protected $allowedFields = ['id_user', 'id_tanaman', 'id_musim', 'tanggal', 'jumlah', 'harga_per_kg', 'total_pendapatan', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}