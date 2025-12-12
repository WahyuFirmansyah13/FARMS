<div align="center">
  <h1 align="center">FARMS </h1>
  <p align="center">
    <strong>Farming Activity & Reporting Management System</strong>
    <br />
    Sistem web untuk mengelola aktivitas dan pelaporan pertanian, dibangun dengan CodeIgniter 4.
  </p>
</div>

![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue?style=flat-square)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-orange?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## Tentang Proyek

**FARMS ** adalah sistem informasi berbasis web yang dirancang untuk membantu petani dan administrator di Desa Bubusan dalam mengelola dan memantau seluruh siklus aktivitas pertanian. Mulai dari pencatatan jenis tanaman, pengelolaan musim tanam, pemantauan aktivitas harian, hingga pelaporan keuangan dan hasil panen.

## Fitur Utama

-   **Autentikasi & Hak Akses**: Sistem login dan registrasi dengan dua peran: `Admin` dan `Petani`.
-   **Dashboard Interaktif**: Visualisasi data statistik menggunakan Chart.js untuk ringkasan cepat.
-   **Manajemen Data (CRUD)**:
    -   Jenis Tanaman
    -   Musim Tanam
    -   Aktivitas Pertanian (dengan unggah foto)
    -   Keuangan (Pemasukan & Pengeluaran)
    -   Hasil Panen
-   **Laporan Otomatis**: Buat dan unduh laporan dalam format **PDF** dan **Excel**.
-   **Antarmuka Modern**: Dibangun dengan Bootstrap 5, tema terang/gelap, dan notifikasi SweetAlert2.
-   **Keamanan**: Perlindungan CSRF, escaping output, dan validasi input.

## Teknologi yang Digunakan

-   **Backend**: PHP 8.1, CodeIgniter 4
-   **Frontend**: Bootstrap 5, Chart.js, DataTables, SweetAlert2
-   **Database**: MySQL (dikelola dengan Migrations)
-   **Library**: Dompdf (untuk PDF), PhpSpreadsheet (untuk Excel)

## Panduan Instalasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

1.  **Clone Repository**
    ```bash
    https://github.com/WahyuFirmansyah13/FARMS.git
    cd farms2
    ```
    > Ganti `username/farms2.git` dengan URL repositori Anda.

2.  **Install Dependensi**
    Pastikan Anda memiliki [Composer](https://getcomposer.org/). Jalankan perintah berikut di root proyek:
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasinya, terutama untuk database.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan atur variabel berikut:
    ```dotenv
    CI_ENVIRONMENT = development
    app.baseURL = 'http://localhost:8080'

    database.default.hostname = localhost
    database.default.database = farms2
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    ```

4.  **Buat Database**
    Pastikan server MySQL Anda berjalan, lalu buat database baru dengan nama `farms2` (sesuai dengan `.env`).

5.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal (termasuk akun default).
    ```bash
    php spark migrate
    php spark db:seed DatabaseSeeder
    ```

6.  **Jalankan Aplikasi**
    Gunakan server development bawaan CodeIgniter:
    ```bash
    php spark serve
    ```
    Aplikasi sekarang dapat diakses di **http://localhost:8080**.

## Akun Default

Setelah menjalankan *database seeder*, Anda bisa login menggunakan akun berikut:

-   **Admin**
    -   **Username**: `admin`
    -   **Password**: `admin123`
-   **Petani (Farmer)**
    -   **Username**: `budi`
    -   **Password**: `petani123`

## Struktur Proyek

Proyek ini mengikuti struktur direktori standar CodeIgniter 4. Berikut adalah direktori kunci yang perlu diperhatikan:

```
farms2/
├── app/
│   ├── Config/       # Konfigurasi routing, filter, dll.
│   ├── Controllers/  # Logika bisnis aplikasi.
│   ├── Database/     # Migrations & Seeder.
│   ├── Models/       # Interaksi dengan database.
│   ├── Views/        # File tampilan (HTML & PHP).
│   └── ...
├── public/           # Root folder untuk web server (aset, index.php).
├── writable/         # Direktori untuk cache, log, dan file upload.
└── ...
```
