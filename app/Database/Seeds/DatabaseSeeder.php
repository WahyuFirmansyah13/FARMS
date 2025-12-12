<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('ProfilSeeder');
        $this->call('JenisTanamanSeeder');
        $this->call('MusimTanamSeeder');
        $this->call('AktivitasPertanianSeeder');
        $this->call('HasilPanenSeeder');
        $this->call('KeuanganPertanianSeeder');
        $this->call('LaporanPertanianSeeder');
    }
}