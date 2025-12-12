<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfilModel;
use CodeIgniter\Controller;

class Profil extends Controller
{
    private function getRoleBasedPaths()
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petani'])) {
            // Default to petani or throw an error if role is not set or invalid
            $role = 'petani';
        }
        return [
            'view_path' => $role . '/profil/',
            'redirect_url' => '/' . $role . '/profil',
        ];
    }

    public function index()
    {
        $userModel = new UserModel();
        $profilModel = new ProfilModel();
        $paths = $this->getRoleBasedPaths();

        $data['user'] = $userModel->find(session('id_user'));
        $data['profil'] = $profilModel->getProfil(session('id_user'));
        $data['title'] = 'Profil Saya';

        return view($paths['view_path'] . 'index', $data);
    }

    public function edit()
    {
        $userModel = new UserModel();
        $profilModel = new ProfilModel();
        $paths = $this->getRoleBasedPaths();

        $data['user'] = $userModel->find(session('id_user'));
        $data['profil'] = $profilModel->getProfil(session('id_user'));
        $data['title'] = 'Edit Profil';

        return view($paths['view_path'] . 'edit', $data);
    }

    public function update()
    {
        $userModel = new UserModel();
        $profilModel = new ProfilModel();
        $id_user = session('id_user');
        $paths = $this->getRoleBasedPaths();

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'nama' => 'required|max_length[100]',
            'alamat' => 'required|max_length[255]',
            'no_hp' => 'required|max_length[20]',
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[8]';
            $rules['pass_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $fotoFile = $this->request->getFile('foto');
        $profilData = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
        ];

        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            // Delete old photo
            $profil = $profilModel->getProfil($id_user);
            if (!empty($profil['foto']) && file_exists('uploads/' . $profil['foto'])) {
                unlink('uploads/' . $profil['foto']);
            }

            $newName = $fotoFile->getRandomName();
            $fotoFile->move('uploads', $newName);
            $profilData['foto'] = $newName;
            
            // Update the photo in the session immediately
            session()->set('foto', $newName);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id_user, $userData);

        $profil = $profilModel->getProfil($id_user);
        if ($profil) {
            $profilModel->update($profil['id_profil'], $profilData);
        } else {
            $profilData['id_user'] = $id_user;
            $profilModel->insert($profilData);
        }

        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to($paths['redirect_url']);
    }
}
