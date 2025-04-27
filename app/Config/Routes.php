<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Guest
$routes->get('/', function () {
    return redirect()->to('auth');
});

// Guest (Belum login)
$routes->group('auth', ['filter' => 'noauth'], function ($routes) {
    $routes->get('/', 'Auth::index');               // /auth/
    $routes->post('login', 'Auth::login');          // /auth/login
    $routes->get('register', 'Auth::register');     // /auth/register
    $routes->post('register', 'Auth::StoreRegister'); // /auth/register (POST)
});
$routes->get('/logout', 'Auth::logout');

// Already Login
$routes->group('home', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('top-up', 'Home::TopUp');
    $routes->post('top-up', 'Home::DoTopUp');
    $routes->get('transaction', 'Home::Transaction');
    $routes->get('akun', 'Home::Akun');
    $routes->post('transaction-pay', 'Home::TransactionPay');
    $routes->post('update-akun', 'Home::UpdateAkun');
    $routes->post('load-transaction', 'Home::LoadTransaction');
    $routes->post('update-profile-image', 'Home::UpdateProfileImage');
    $routes->get('service/(:segment)', 'Home::TransactionService/$1');
});