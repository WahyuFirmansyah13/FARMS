<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisTanamanModel extends Model
{
    protected $table = 'jenis_tanaman';
    protected $primaryKey = 'id_tanaman';
    protected $allowedFields = ['id_user', 'nama_tanaman', 'deskripsi', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}