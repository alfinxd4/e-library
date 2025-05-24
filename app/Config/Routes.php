<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// 
$routes->get('register', 'Member\Auth::register');
$routes->post('register', 'Member\Auth::processRegister');
// 
$routes->get('login', 'Member\Auth::login');  
$routes->post('login', 'Member\Auth::processLogin');
// 
$routes->get('auth/google-login', 'Member\Auth::googleLogin');
$routes->get('auth/google-callback', 'Member\Auth::googleCallback');
// 
$routes->get('logout', 'Member\Auth::logout');
// 
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Member\Dashboard::index');
    $routes->get('list-buku', 'Member\ListBuku::index');
});
// 

