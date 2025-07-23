<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// $routes->setAutoRoute(true);

// ============ AUTH ROUTES ============
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

// Register hanya untuk user biasa
$routes->match(['GET', 'POST'], '/register', 'Auth::register');

// ============ ADMIN ROUTES ============
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // profile
    $routes->get('profile', 'Admin\ProfileController::index');
    $routes->post('profile/update', 'Admin\ProfileController::update');
    $routes->post('profile/update-password', 'Admin\ProfileController::updatePassword');
    $routes->post('profile/update-photo', 'Admin\ProfileController::updatePhoto');
    $routes->post('profile/remove-photo', 'Admin\ProfileController::removePhoto');
    

    // Surat Masuk
    $routes->get('surat-masuk', 'Admin\SuratMasuk::index');
    $routes->get('surat-masuk/tambah', 'Admin\SuratMasuk::create');
    $routes->post('surat-masuk/simpan', 'Admin\SuratMasuk::store');
    $routes->get('surat-masuk/edit/(:num)', 'Admin\SuratMasuk::edit/$1');
    $routes->post('surat-masuk/update/(:num)', 'Admin\SuratMasuk::update/$1');
    $routes->get('surat-masuk/delete/(:num)', 'Admin\SuratMasuk::delete/$1');
    $routes->get('surat-masuk/reset-filter', 'Admin\SuratMasuk::resetFilter');
    $routes->post('surat-masuk/(:num)/disposisi', 'Admin\SuratMasuk::kirimDisposisi/$1');


    // Surat Keluar
    $routes->get('surat-keluar', 'Admin\SuratKeluar::index');
    $routes->get('surat-keluar/tambah', 'Admin\SuratKeluar::create');
    $routes->post('surat-keluar/simpan', 'Admin\SuratKeluar::store');
    $routes->get('surat-keluar/edit/(:num)', 'Admin\SuratKeluar::edit/$1');
    $routes->post('surat-keluar/update/(:num)', 'Admin\SuratKeluar::update/$1');
    $routes->get('surat-keluar/delete/(:num)', 'Admin\SuratKeluar::delete/$1');
    $routes->get('surat-keluar/reset-filter', 'Admin\SuratKeluar::resetFilter');


    // Manajemen User
    $routes->get('users', 'Admin\UserManagement::index');
    $routes->get('users/tambah', 'Admin\UserManagement::create');
    $routes->post('users/simpan', 'Admin\UserManagement::store');
    $routes->get('users/edit/(:num)', 'Admin\UserManagement::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserManagement::update/$1');
    $routes->get('users/hapus/(:num)', 'Admin\UserManagement::delete/$1');
    $routes->get('users/reset-filter', 'Admin\UserManagement::resetFilter');

    $routes->get('disposisi', 'Admin\Disposisi::index');

    // Tanda Tangan
    $routes->get('tanda-tangan', 'Admin\TandaTangan::index');
    $routes->post('tanda-tangan/upload', 'Admin\TandaTangan::upload');
    $routes->get('tanda-tangan/delete/(:num)', 'Admin\TandaTangan::delete/$1');

    // Perusahaan
    $routes->get('perusahaan', 'Admin\Perusahaan::index');
    $routes->get('perusahaan/create', 'Admin\Perusahaan::create');
    $routes->post('perusahaan/store', 'Admin\Perusahaan::store');
    $routes->get('perusahaan/edit/(:num)', 'Admin\Perusahaan::edit/$1');
    $routes->post('perusahaan/update/(:num)', 'Admin\Perusahaan::update/$1');
    $routes->get('perusahaan/delete/(:num)', 'Admin\Perusahaan::delete/$1');

    // Jenis Surat
    $routes->get('jenis-surat', 'Admin\JenisSurat::index');
    $routes->get('jenis-surat/create', 'Admin\JenisSurat::create');
    $routes->post('jenis-surat/store', 'Admin\JenisSurat::store');
    $routes->get('jenis-surat/edit/(:num)', 'Admin\JenisSurat::edit/$1');
    $routes->post('jenis-surat/update/(:num)', 'Admin\JenisSurat::update/$1');
    $routes->get('jenis-surat/delete/(:num)', 'Admin\JenisSurat::delete/$1');
});

// ============ OPERATOR ROUTES ============
$routes->group('operator', ['filter' => 'role:operator'], function ($routes) {
    $routes->get('dashboard', 'Operator\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // profile
    $routes->get('profile', 'Operator\ProfileController::index');
    $routes->post('profile/update', 'Operator\ProfileController::update');
    $routes->post('profile/update-password', 'Operator\ProfileController::updatePassword');
    $routes->post('profile/update-photo', 'Oerator\ProfileController::updatePhoto');
    $routes->post('profile/remove-photo', 'Operator\ProfileController::removePhoto');

    // Surat Masuk
    $routes->get('surat-masuk', 'Operator\SuratMasuk::index');
    $routes->get('surat-masuk/tambah', 'Operator\SuratMasuk::create');
    $routes->post('surat-masuk/simpan', 'Operator\SuratMasuk::store');
    $routes->get('surat-masuk/edit/(:num)', 'Operator\SuratMasuk::edit/$1');
    $routes->post('surat-masuk/update/(:num)', 'Operator\SuratMasuk::update/$1');
    $routes->get('surat-masuk/delete/(:num)', 'Operator\SuratMasuk::delete/$1');
    $routes->get('surat-masuk/reset-filter', 'Operator\SuratMasuk::resetFilter');
    
    $routes->get('disposisi', 'Operator\Disposisi::index');

    // Surat Keluar
    $routes->get('surat-keluar', 'Operator\SuratKeluar::index');
    $routes->get('surat-keluar/tambah', 'Operator\SuratKeluar::create');
    $routes->post('surat-keluar/simpan', 'Operator\SuratKeluar::store');
    $routes->get('surat-keluar/edit/(:num)', 'Operator\SuratKeluar::edit/$1');
    $routes->post('surat-keluar/update/(:num)', 'Operator\SuratKeluar::update/$1');
    $routes->get('surat-keluar/delete/(:num)', 'Operator\SuratKeluar::delete/$1');
    $routes->get('surat-keluar/reset-filter', 'Operator\SuratKeluar::resetFilter');

    // Manajemen User
    $routes->get('users', 'Operator\UserManagement::index');
    $routes->get('users/tambah', 'Operator\UserManagement::create');
    $routes->post('users/simpan', 'Operator\UserManagement::store');
    $routes->get('users/edit/(:num)', 'Operator\UserManagement::edit/$1');
    $routes->post('users/update/(:num)', 'Operator\UserManagement::update/$1');
    $routes->get('users/delete/(:num)', 'Operator\UserManagement::delete/$1');
});

// ============ USER ROUTES ============
$routes->group('user', ['filter' => 'role:user'], function ($routes) {
    $routes->get('dashboard', 'User\Dashboard::index');
        // profile
    $routes->get('profile', 'User\ProfileController::index');
    $routes->post('profile/update', 'User\ProfileController::update');
    $routes->post('profile/update-password', 'User\ProfileController::updatePassword');
    $routes->post('profile/update-photo', 'User\ProfileController::updatePhoto');
    $routes->post('profile/remove-photo', 'User\ProfileController::removePhoto');

    $routes->get('disposisi', 'User\Disposisi::index');


    // Kirim Surat Masuk
    $routes->get('kirim-surat', 'User\SuratMasuk::create');
    $routes->post('kirim-surat/simpan', 'User\SuratMasuk::store');

    // History Surat Masuk
    $routes->get('history-surat-masuk', 'User\History::suratMasuk');
});
