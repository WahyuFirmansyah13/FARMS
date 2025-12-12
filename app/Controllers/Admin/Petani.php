<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Petani extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new UserModel();
        $data['title'] = 'Data Petani';
        $data['petani'] = $model->where('role', 'petani')->findAll();
        return view('admin/petani/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Tambah Petani';
        return view('admin/petani/create', $data);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]|max_length[255]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'petani',
        ]);

        session()->setFlashdata('success', 'Petani berhasil ditambahkan.');
        return redirect()->to('/admin/petani');
    }

    public function edit($id = null)
    {
        $data['title'] = 'Edit Data Petani';
        $data['petani'] = $this->model->where('role', 'petani')->find($id);
        if (!$data['petani']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/petani/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id_user,' . $id . ']',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
            'pass_confirm' => 'matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->model->update($id, $data);

        session()->setFlashdata('success', 'Data petani berhasil diperbarui.');
        return redirect()->to('/admin/petani');
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        session()->setFlashdata('success', 'Petani berhasil dihapus.');
        return redirect()->to('/admin/petani');
    }
}