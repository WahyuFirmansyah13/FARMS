<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = 'profil';
    protected $primaryKey = 'id_profil';
    protected $allowedFields = ['id_user', 'nama', 'alamat', 'no_hp', 'foto', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getProfil($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }
}