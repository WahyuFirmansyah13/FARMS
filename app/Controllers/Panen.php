<?php

namespace App\Controllers;

use App\Models\HasilPanenModel;
use App\Models\JenisTanamanModel;
use App\Models\KeuanganModel;
use App\Models\MusimModel;
use CodeIgniter\RESTful\ResourceController;

class Panen extends ResourceController
{
    protected $modelName = 'App\Models\HasilPanenModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new HasilPanenModel();
        $data['title'] = 'Hasil Panen';
        $data['hasil_panen'] = $model->select('hasil_panen.*, musim_tanam.periode_awal, musim_tanam.periode_akhir, jenis_tanaman.nama_tanaman')
                                     ->join('musim_tanam', 'musim_tanam.id_musim = hasil_panen.id_musim')
                                     ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = musim_tanam.id_tanaman')
                                     ->where('hasil_panen.id_user', session('id_user'))
                                     ->findAll();
        return view('petani/panen/index', $data);
    }

    public function new()
    {
        $musimModel = new MusimModel();
        $jenisTanamanModel = new JenisTanamanModel();
        $data['title'] = 'Tambah Hasil Panen';
        $data['musim_tanam'] = $musimModel->where('id_user', session('id_user'))->findAll();
        $data['jenis_tanaman'] = $jenisTanamanModel->where('id_user', session('id_user'))->findAll();
        return view('petani/panen/create', $data);
    }

    public function create()
    {
        $rules = [
            'id_tanaman'   => 'required|numeric',
            'id_musim'     => 'required|numeric',
            'tanggal'      => 'required|valid_date',
            'jumlah'       => 'required|numeric',
            'harga_per_kg' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jumlah = $this->request->getPost('jumlah');
        $harga_per_kg = $this->request->getPost('harga_per_kg');
        $total_pendapatan = $jumlah * $harga_per_kg;

        $panenData = [
            'id_user'          => session('id_user'),
            'id_tanaman'       => $this->request->getPost('id_tanaman'),
            'id_musim'         => $this->request->getPost('id_musim'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'jumlah'           => $jumlah,
            'harga_per_kg'     => $harga_per_kg,
            'total_pendapatan' => $total_pendapatan,
        ];

        $panenId = $this->model->insert($panenData);

        if ($panenId) {
            // Automatically create a financial record
            $keuanganModel = new KeuanganModel();
            $tanamanModel = new JenisTanamanModel();
            $tanaman = $tanamanModel->find($this->request->getPost('id_tanaman'));

            $keuanganModel->save([
                'id_user'         => session('id_user'),
                'id_panen'        => $panenId,
                'id_tanaman'      => $this->request->getPost('id_tanaman'),
                'tanggal'         => $this->request->getPost('tanggal'),
                'jenis_transaksi' => 'pendapatan',
                'kategori'        => 'penjualan',
                'nominal'         => $total_pendapatan,
                'keterangan'      => 'Pendapatan dari panen ' . ($tanaman['nama_tanaman'] ?? 'tanaman'),
            ]);
        }

        session()->setFlashdata('success', 'Data panen berhasil ditambahkan dan catatan keuangan telah dibuat.');
        return redirect()->to('/petani/panen');
    }

    public function show($id = null)
    {
        $data['panen'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['panen']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/panen/detail', $data);
    }

    public function edit($id = null)
    {
        $musimModel = new MusimModel();
        $jenisTanamanModel = new JenisTanamanModel();
        $data['title'] = 'Edit Hasil Panen';
        $data['musim_tanam'] = $musimModel->where('id_user', session('id_user'))->findAll();
        $data['jenis_tanaman'] = $jenisTanamanModel->where('id_user', session('id_user'))->findAll();
        $data['panen'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['panen']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/panen/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'id_tanaman'   => 'required|numeric',
            'id_musim'     => 'required|numeric',
            'tanggal'      => 'required|valid_date',
            'jumlah'       => 'required|numeric',
            'harga_per_kg' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jumlah = $this->request->getPost('jumlah');
        $harga_per_kg = $this->request->getPost('harga_per_kg');
        $total_pendapatan = $jumlah * $harga_per_kg;

        $this->model->update($id, [
            'id_tanaman'       => $this->request->getPost('id_tanaman'),
            'id_musim'         => $this->request->getPost('id_musim'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'jumlah'           => $jumlah,
            'harga_per_kg'     => $harga_per_kg,
            'total_pendapatan' => $total_pendapatan,
        ]);

        // Update the corresponding financial record
        $keuanganModel = new KeuanganModel();
        $keuanganRecord = $keuanganModel->where('id_panen', $id)->first();
        if ($keuanganRecord) {
            $keuanganModel->update($keuanganRecord['id_keuangan'], [
                'tanggal' => $this->request->getPost('tanggal'),
                'nominal' => $total_pendapatan,
                'id_tanaman' => $this->request->getPost('id_tanaman'),
            ]);
        }

        session()->setFlashdata('success', 'Data panen dan catatan keuangan terkait berhasil diperbarui.');
        return redirect()->to('/petani/panen');
    }

    public function delete($id = null)
    {
        // First, delete the corresponding financial record
        $keuanganModel = new KeuanganModel();
        $keuanganModel->where('id_panen', $id)->delete();

        // Then, delete the harvest record
        $this->model->delete($id);
        
        session()->setFlashdata('success', 'Data panen dan catatan keuangan terkait berhasil dihapus.');
        return redirect()->to('/petani/panen');
    }
}