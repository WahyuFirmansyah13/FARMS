<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index'); // Alias for Auth::index
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('ping', 'Dashboard::ping');

$routes->get('/register', 'Register::index');
$routes->post('/register/save', 'Register::save');

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::admin');
    $routes->resource('petani', ['controller' => 'Admin\Petani']); // namespace optional
    $routes->resource('tanaman', ['controller' => 'Admin\Tanaman']);
    $routes->get('laporan', 'Laporan::index_admin');
    $routes->get('laporan/create', 'Laporan::create_admin');
    $routes->post('laporan/generate', 'Laporan::generate_admin');
    $routes->get('laporan/export_pdf/(:num)', 'Laporan::exportPdf_admin/$1');
    $routes->get('laporan/export_excel/(:num)', 'Laporan::exportExcel_admin/$1');
    $routes->get('profil', 'Profil::index');
    $routes->get('profil/edit', 'Profil::edit');
    $routes->post('profil/update', 'Profil::update');
});

$routes->group('petani', ['filter' => 'role:petani'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::petani');
    $routes->resource('jenis_tanaman', ['controller' => 'JenisTanaman']);
    $routes->resource('aktivitas', ['controller' => 'Aktivitas']);
    $routes->resource('keuangan', ['controller' => 'Keuangan']);
    $routes->resource('panen', ['controller' => 'Panen']);
    $routes->resource('musim', ['controller' => 'Musim']);
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/create', 'Laporan::create'); // Add this line
    $routes->post('laporan/generate', 'Laporan::generate');
    $routes->get('laporan/export_pdf', 'Laporan::exportPdf');
    $routes->get('laporan/export_excel', 'Laporan::exportExcel');
    $routes->get('profil', 'Profil::index');
    $routes->get('profil/edit', 'Profil::edit');
    $routes->post('profil/update', 'Profil::update');
});