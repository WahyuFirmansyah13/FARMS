<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfilModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        // Tampilkan halaman login
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $userModel = new UserModel();
        $profilModel = new ProfilModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $profil = $profilModel->where('id_user', $user['id_user'])->first();

                $ses_data = [
                    'id_user'   => $user['id_user'],
                    'username'  => $user['username'],
                    'role'      => $user['role'],
                    'foto'      => $profil['foto'] ?? null,
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);

                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/petani/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Password salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}