<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function() {
    return view("template/404");
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Frontend::index');
$routes->get('category', 'Frontend::kategori');
$routes->get('news', 'Frontend::berita');
$routes->get('about', 'Frontend::tentang');
$routes->get('cart', 'Frontend::keranjang');
$routes->get('produk/(:any)', 'Frontend::produk/$1');

//UMKM BackOffice
$routes->get('umkm/index', 'Umkm::index');
$routes->get('umkm/produk', 'Umkm::produk');
$routes->get('umkm/kategori-produk', 'Umkm::kategori_produk');
$routes->post('umkm/kategori_produk_', 'Umkm::kategori_produk_');
$routes->post('umkm/create_kategori', 'Umkm::create_kategori');
$routes->post('umkm/update_kategori', 'Umkm::update_kategori');
$routes->post('umkm/delete_kategori', 'Umkm::delete_kategori');

//ADMIN BackOffice
$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::logout');
$routes->post('login/proses', 'Login::proses');
$routes->get('admin/produk', 'Admin::produk');
$routes->get('admin/umkm', 'Admin::umkm');
$routes->get('admin/reseller', 'Admin::reseller');
$routes->get('admin/modul', 'Admin::modul');
$routes->get('admin/user', 'Admin::user');
$routes->post('admin/user_', 'Admin::user_');
$routes->post('admin/create_user', 'Admin::create_user');
$routes->post('admin/update_user', 'Admin::update_user');
$routes->post('admin/delete_user', 'Admin::delete_user');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
