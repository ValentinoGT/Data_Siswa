<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('siswa', 'Home::index');
$routes->post('siswa/simpan', 'Home::simpan');
$routes->post('siswa/edit/(:num)', 'Home::edit/$1');
$routes->post('siswa/hapus/(:num)', 'Home::hapus/$1');
?>