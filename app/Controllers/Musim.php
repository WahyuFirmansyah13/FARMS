<?php

namespace App\Controllers;

use App\Models\MusimModel;
use App\Models\JenisTanamanModel;
use CodeIgniter\RESTful\ResourceController;

class Musim extends ResourceController
{
    protected $modelName = 'App\Models\MusimModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new MusimModel();
        $data['title'] = 'Musim Tanam';
        $data['musim'] = $model->select('musim_tanam.*, jenis_tanaman.nama_tanaman')
                               ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = musim_tanam.id_tanaman')
                               ->where('musim_tanam.id_user', session('id_user'))
                               ->findAll();
        return view('petani/musim/index', $data);
    }

    public function new()
    {
        $tanamanModel = new JenisTanamanModel();
        $data['title'] = 'Tambah Musim Tanam';
        $data['jenis_tanaman'] = $tanamanModel->where('id_user', session('id_user'))->findAll();
        return view('petani/musim/create', $data);
    }

    public function create()
    {
        $rules = [
            'id_tanaman'    => 'required|integer',
            'periode_awal'  => 'required|valid_date',
            'periode_akhir' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id_user'       => session('id_user'),
            'id_tanaman'    => $this->request->getPost('id_tanaman'),
            'periode_awal'  => $this->request->getPost('periode_awal'),
            'periode_akhir' => $this->request->getPost('periode_akhir'),
        ]);

        session()->setFlashdata('success', 'Musim tanam berhasil ditambahkan.');
        return redirect()->to('/petani/musim');
    }

    public function show($id = null)
    {
        $tanamanModel = new JenisTanamanModel();
        $data['jenis_tanaman'] = $tanamanModel->where('id_user', session('id_user'))->findAll();
        $data['musim'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['musim']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/musim/edit', $data);
    }

    public function edit($id = null)
    {
        $tanamanModel = new JenisTanamanModel();
        $data['title'] = 'Edit Musim Tanam';
        $data['jenis_tanaman'] = $tanamanModel->where('id_user', session('id_user'))->findAll();
        $data['musim'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['musim']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/musim/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'id_tanaman'    => 'required|integer',
            'periode_awal'  => 'required|valid_date',
            'periode_akhir' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'id_tanaman'    => $this->request->getPost('id_tanaman'),
            'periode_awal'  => $this->request->getPost('periode_awal'),
            'periode_akhir' => $this->request->getPost('periode_akhir'),
        ]);

        session()->setFlashdata('success', 'Musim tanam berhasil diperbarui.');
        return redirect()->to('/petani/musim');
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        session()->setFlashdata('success', 'Musim tanam berhasil dihapus.');
        return redirect()->to('/petani/musim');
    }
}