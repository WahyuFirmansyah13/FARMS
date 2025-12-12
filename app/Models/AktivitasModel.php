<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasModel extends Model
{
    protected $table = 'aktivitas_pertanian';
    protected $primaryKey = 'id_aktivitas';
    protected $allowedFields = ['id_user', 'id_tanaman', 'id_musim', 'tanggal', 'kegiatan', 'keterangan', 'foto', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}