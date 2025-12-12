<?php

namespace App\Models;

use CodeIgniter\Model;

class MusimModel extends Model
{
    protected $table = 'musim_tanam';
    protected $primaryKey = 'id_musim';
    protected $allowedFields = ['id_user', 'id_tanaman', 'nama_musim', 'periode_awal', 'periode_akhir', 'keterangan', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
