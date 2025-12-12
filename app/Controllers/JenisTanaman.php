<?php

namespace App\Controllers;

use App\Models\JenisTanamanModel;
use CodeIgniter\RESTful\ResourceController;

class JenisTanaman extends ResourceController
{
    protected $modelName = 'App\Models\JenisTanamanModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new JenisTanamanModel();
        $data['title'] = 'Jenis Tanaman';
        $data['jenis_tanaman'] = $model->where('id_user', session('id_user'))->findAll();
        return view('petani/jenis_tanaman/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Tambah Jenis Tanaman';
        return view('petani/jenis_tanaman/create', $data);
    }

    public function create()
    {
        $rules = [
            'nama_tanaman' => 'required|max_length[100]',
            'deskripsi'    => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id_user'      => session('id_user'),
            'nama_tanaman' => $this->request->getPost('nama_tanaman'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('success', 'Jenis tanaman berhasil ditambahkan.');
        return redirect()->to('/petani/jenis_tanaman');
    }

    public function show($id = null)
    {
        $data['jenis_tanaman'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['jenis_tanaman']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/jenis_tanaman/detail', $data);
    }

    public function edit($id = null)
    {
        $data['title'] = 'Edit Jenis Tanaman';
        $data['jenis_tanaman'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['jenis_tanaman']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/jenis_tanaman/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'nama_tanaman' => 'required|max_length[100]',
            'deskripsi'    => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nama_tanaman' => $this->request->getPost('nama_tanaman'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('success', 'Jenis tanaman berhasil diperbarui.');
        return redirect()->to('/petani/jenis_tanaman');
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        session()->setFlashdata('success', 'Jenis tanaman berhasil dihapus.');
        return redirect()->to('/petani/jenis_tanaman');
    }
}