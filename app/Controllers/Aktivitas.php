<?php

namespace App\Controllers;

use App\Models\AktivitasModel;
use App\Models\JenisTanamanModel;
use App\Models\MusimModel;
use CodeIgniter\RESTful\ResourceController;

class Aktivitas extends ResourceController
{
    protected $modelName = 'App\Models\AktivitasModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new AktivitasModel();
        $data['title'] = 'Aktivitas Pertanian';
        $data['aktivitas'] = $model->select('aktivitas_pertanian.*, musim_tanam.periode_awal, musim_tanam.periode_akhir, jenis_tanaman.nama_tanaman')
                                   ->join('musim_tanam', 'musim_tanam.id_musim = aktivitas_pertanian.id_musim')
                                   ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = musim_tanam.id_tanaman')
                                   ->where('aktivitas_pertanian.id_user', session('id_user'))
                                   ->findAll();
        return view('petani/aktivitas/index', $data);
    }

    public function new()
    {
        $musimModel = new MusimModel();
        $data['title'] = 'Tambah Aktivitas';
        $data['musim_tanam'] = $musimModel->select('musim_tanam.*, jenis_tanaman.nama_tanaman')
                                           ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = musim_tanam.id_tanaman')
                                           ->where('musim_tanam.id_user', session('id_user'))
                                           ->findAll();
        return view('petani/aktivitas/create', $data);
    }

    public function create()
    {
        $rules = [
            'id_tanaman' => 'required|numeric',
            'id_musim'   => 'required|numeric',
            'tanggal'    => 'required|valid_date',
            'kegiatan'   => 'required|max_length[100]',
            'keterangan' => 'permit_empty',
            'foto'       => 'uploaded[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        $fileName = '';
        if ($foto->isValid() && !$foto->hasMoved()) {
            $fileName = time() . '_' . session('id_user') . '_' . $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads', $fileName);
        }

        $this->model->save([
            'id_user'    => session('id_user'),
            'id_tanaman' => $this->request->getPost('id_tanaman'),
            'id_musim'   => $this->request->getPost('id_musim'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'kegiatan'   => $this->request->getPost('kegiatan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto'       => $fileName,
        ]);

        session()->setFlashdata('success', 'Aktivitas pertanian berhasil ditambahkan.');
        return redirect()->to('/petani/aktivitas');
    }

    public function show($id = null)
    {
        $data['aktivitas'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['aktivitas']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/aktivitas/detail', $data);
    }

    public function edit($id = null)
    {
        $musimModel = new MusimModel();
        $data['title'] = 'Edit Aktivitas';
        $data['musim_tanam'] = $musimModel->select('musim_tanam.*, jenis_tanaman.nama_tanaman')
                                           ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = musim_tanam.id_tanaman')
                                           ->where('musim_tanam.id_user', session('id_user'))
                                           ->findAll();
        $data['aktivitas'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['aktivitas']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/aktivitas/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'id_tanaman' => 'required|numeric',
            'id_musim'   => 'required|numeric',
            'tanggal'    => 'required|valid_date',
            'kegiatan'   => 'required|max_length[100]',
            'keterangan' => 'permit_empty',
            'foto'       => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]', // Optional for update
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $oldFoto = $this->model->find($id)['foto'];
        $foto = $this->request->getFile('foto');
        $fileName = $oldFoto;

        if ($foto->isValid() && !$foto->hasMoved()) {
            // Delete old photo if it exists
            if ($oldFoto && file_exists(ROOTPATH . 'public/uploads/' . $oldFoto)) {
                unlink(ROOTPATH . 'public/uploads/' . $oldFoto);
            }
            $fileName = time() . '_' . session('id_user') . '_' . $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads', $fileName);
        }

        $this->model->update($id, [
            'id_tanaman' => $this->request->getPost('id_tanaman'),
            'id_musim'   => $this->request->getPost('id_musim'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'kegiatan'   => $this->request->getPost('kegiatan'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto'       => $fileName,
        ]);

        session()->setFlashdata('success', 'Aktivitas pertanian berhasil diperbarui.');
        return redirect()->to('/petani/aktivitas');
    }

    public function delete($id = null)
    {
        $aktivitas = $this->model->find($id);
        if ($aktivitas['foto'] && file_exists(ROOTPATH . 'public/uploads/' . $aktivitas['foto'])) {
            unlink(ROOTPATH . 'public/uploads/' . $aktivitas['foto']);
        }
        $this->model->delete($id);
        session()->setFlashdata('success', 'Aktivitas pertanian berhasil dihapus.');
        return redirect()->to('/petani/aktivitas');
    }
}