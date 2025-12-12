<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    public function index()
    {
        // Tampilkan halaman registrasi
        return view('auth/register');
    }

    public function save()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]|max_length[255]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'petani', // Default role for new registrations
            ];
            $model->save($data);
            session()->setFlashdata('msg', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
    }
}