<?php

namespace App\Controllers\Admin;

use App\Models\JenisTanamanModel;
use CodeIgniter\RESTful\ResourceController;

class Tanaman extends ResourceController
{
    protected $modelName = 'App\Models\JenisTanamanModel';
    protected $format    = 'json';

    public function index()
    {
        $data['title'] = 'Data Jenis Tanaman';
        $data['jenis_tanaman'] = $this->model->findAll();
        return view('admin/tanaman/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Tambah Jenis Tanaman';
        return view('admin/tanaman/create', $data);
    }

    public function create()
    {
        $rules = [
            'id_user'      => 'required|numeric',
            'nama_tanaman' => 'required|max_length[100]',
            'deskripsi'    => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id_user'      => $this->request->getPost('id_user'),
            'nama_tanaman' => $this->request->getPost('nama_tanaman'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('success', 'Jenis tanaman berhasil ditambahkan.');
        return redirect()->to('/admin/tanaman');
    }

    public function edit($id = null)
    {
        $data['title'] = 'Edit Jenis Tanaman';
        $data['jenis_tanaman'] = $this->model->find($id);
        if (!$data['jenis_tanaman']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/tanaman/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'id_user'      => 'required|numeric',
            'nama_tanaman' => 'required|max_length[100]',
            'deskripsi'    => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'id_user'      => $this->request->getPost('id_user'),
            'nama_tanaman' => $this->request->getPost('nama_tanaman'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('success', 'Jenis tanaman berhasil diperbarui.');
        return redirect()->to('/admin/tanaman');
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        session()->setFlashdata('success', 'Jenis tanaman berhasil dihapus.');
        return redirect()->to('/admin/tanaman');
    }
}