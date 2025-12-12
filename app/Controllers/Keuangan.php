<?php

namespace App\Controllers;

use App\Models\KeuanganModel;
use App\Models\AktivitasModel;
use App\Models\HasilPanenModel;
use App\Models\JenisTanamanModel;
use CodeIgniter\RESTful\ResourceController;

class Keuangan extends ResourceController
{
    protected $modelName = 'App\Models\KeuanganModel';
    protected $format    = 'json';

    public function index()
    {
        $model = new KeuanganModel();
        $data['title'] = 'Catatan Keuangan';
        $data['keuangan'] = $model->select('keuangan_pertanian.*, jenis_tanaman.nama_tanaman')
                                   ->join('jenis_tanaman', 'jenis_tanaman.id_tanaman = keuangan_pertanian.id_tanaman', 'left')
                                   ->where('keuangan_pertanian.id_user', session('id_user'))
                                   ->findAll();
        return view('petani/keuangan/index', $data);
    }

    public function new()
    {
        $aktivitasModel = new AktivitasModel();
        $hasilPanenModel = new HasilPanenModel();
        $jenisTanamanModel = new JenisTanamanModel();
        $data['title'] = 'Tambah Transaksi';
        $data['aktivitas'] = $aktivitasModel->where('id_user', session('id_user'))->findAll();
        $data['hasil_panen'] = $hasilPanenModel->where('id_user', session('id_user'))->findAll();
        $data['jenis_tanaman'] = $jenisTanamanModel->where('id_user', session('id_user'))->findAll();
        return view('petani/keuangan/create', $data);
    }

    public function create()
    {
        $jenis_transaksi = $this->request->getPost('jenis_transaksi');
        $kategori_rules = 'required|';

        if ($jenis_transaksi === 'pengeluaran') {
            $kategori_rules .= 'in_list[benih,pupuk,pestisida,upah,lainnya]';
        } elseif ($jenis_transaksi === 'pendapatan') {
            $kategori_rules .= 'in_list[penjualan]';
        } else {
            $kategori_rules = 'required'; // Should fail if no type is selected
        }

        $rules = [
            'tanggal'         => 'required|valid_date',
            'jenis_transaksi' => 'required|in_list[pengeluaran,pendapatan]',
            'kategori'        => $kategori_rules,
            'nominal'         => 'required|numeric',
            'keterangan'      => 'permit_empty',
            'id_aktivitas'    => 'permit_empty|numeric',
            'id_panen'        => 'permit_empty|numeric',
            'id_tanaman'      => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id_user'         => session('id_user'),
            'id_aktivitas'    => $this->request->getPost('id_aktivitas') ?: null,
            'id_panen'        => $this->request->getPost('id_panen') ?: null,
            'id_tanaman'      => $this->request->getPost('id_tanaman') ?: null,
            'tanggal'         => $this->request->getPost('tanggal'),
            'jenis_transaksi' => $this->request->getPost('jenis_transaksi'),
            'kategori'        => $this->request->getPost('kategori'),
            'nominal'         => $this->request->getPost('nominal'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ]);

        session()->setFlashdata('success', 'Data keuangan berhasil ditambahkan.');
        return redirect()->to('/petani/keuangan');
    }

    public function show($id = null)
    {
        $data['keuangan'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['keuangan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/keuangan/detail', $data);
    }

    public function edit($id = null)
    {
        $aktivitasModel = new AktivitasModel();
        $hasilPanenModel = new HasilPanenModel();
        $jenisTanamanModel = new JenisTanamanModel();
        $data['title'] = 'Edit Transaksi';
        $data['aktivitas'] = $aktivitasModel->where('id_user', session('id_user'))->findAll();
        $data['hasil_panen'] = $hasilPanenModel->where('id_user', session('id_user'))->findAll();
        $data['jenis_tanaman'] = $jenisTanamanModel->where('id_user', session('id_user'))->findAll();
        $data['keuangan'] = $this->model->where('id_user', session('id_user'))->find($id);
        if (!$data['keuangan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('petani/keuangan/edit', $data);
    }

    public function update($id = null)
    {
        $jenis_transaksi = $this->request->getPost('jenis_transaksi');
        $kategori_rules = 'required|';

        if ($jenis_transaksi === 'pengeluaran') {
            $kategori_rules .= 'in_list[benih,pupuk,pestisida,upah,lainnya]';
        } elseif ($jenis_transaksi === 'pendapatan') {
            $kategori_rules .= 'in_list[penjualan]';
        } else {
            $kategori_rules = 'required';
        }

        $rules = [
            'tanggal'         => 'required|valid_date',
            'jenis_transaksi' => 'required|in_list[pengeluaran,pendapatan]',
            'kategori'        => $kategori_rules,
            'nominal'         => 'required|numeric',
            'keterangan'      => 'permit_empty',
            'id_aktivitas'    => 'permit_empty|numeric',
            'id_panen'        => 'permit_empty|numeric',
            'id_tanaman'      => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'id_aktivitas'    => $this->request->getPost('id_aktivitas') ?: null,
            'id_panen'        => $this->request->getPost('id_panen') ?: null,
            'id_tanaman'      => $this->request->getPost('id_tanaman') ?: null,
            'tanggal'         => $this->request->getPost('tanggal'),
            'jenis_transaksi' => $this->request->getPost('jenis_transaksi'),
            'kategori'        => $this->request->getPost('kategori'),
            'nominal'         => $this->request->getPost('nominal'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ]);

        session()->setFlashdata('success', 'Data keuangan berhasil diperbarui.');
        return redirect()->to('/petani/keuangan');
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        session()->setFlashdata('success', 'Data keuangan berhasil dihapus.');
        return redirect()->to('/petani/keuangan');
    }
}