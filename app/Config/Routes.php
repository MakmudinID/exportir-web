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
$routes->get('about', 'Frontend::tentang');
$routes->get('cart', 'Frontend::keranjang');
$routes->get('produk/(:any)', 'Frontend::produk/$1');
$routes->get('kategori/(:any)', 'Frontend::kategori/$1');
$routes->get('profil-umkm/(:any)', 'Frontend::umkm/$1');
$routes->get('kerjasama/umkm/(:any)', 'Frontend::kerjasama_umkm/$1');
$routes->get('kerjasama', 'Frontend::kerjasama');
$routes->post('kerjasama_', 'Frontend::kerjasama_');
$routes->post('kerjasama_pengajuan', 'Frontend::kerjasama_pengajuan');
$routes->post('kirim_kerjasama', 'Frontend::kirim_kerjasama');
$routes->get('list-produk', 'Frontend::list_produk');
$routes->post('list_produk_', 'Frontend::list_produk_');
$routes->get('list-berita', 'Frontend::list_berita');
$routes->post('list_berita_', 'Frontend::list_berita_');
$routes->get('berita/(:any)', 'Frontend::berita/$1');
$routes->post('add-cart', 'Frontend::add_cart');
$routes->post('cart_', 'Frontend::cart_');
$routes->post('remove_cart', 'Frontend::remove_cart');
$routes->post('update_qty', 'Frontend::update_qty');
$routes->post('this_checkout', 'Frontend::this_checkout');
$routes->post('update_catatan', 'Frontend::update_catatan');
$routes->get('count_cart', 'Frontend::count_cart');
$routes->post('checkout', 'Frontend::checkout');
$routes->get('wilayah/(:any)/(:any)', 'Frontend::wilayah/$1/$2');
$routes->get('get_kota/(:any)', 'Frontend::get_kota/$1');
$routes->post('kurir', 'Frontend::kurir');
$routes->post('set_kurir', 'Frontend::set_kurir');
$routes->post('proses_checkout', 'Frontend::proses_checkout');
$routes->get('notifikasi/(:any)', 'Frontend::notifikasi/$1');
$routes->get('notifikasi-kerjasama/(:any)', 'Frontend::notifikasi_kerjasama/$1');
$routes->post('transaksi', 'Frontend::transaksi');
$routes->post('cek_ongkir', 'Frontend::cek_ongkir');

//UMKM BackOffice
$routes->get('umkm/dashboard', 'Umkm::dashboard');
$routes->get('umkm/produk', 'Umkm::produk');
$routes->get('umkm/profil', 'Umkm::profil');
$routes->post('umkm/edit_profil', 'Umkm::edit_profil');
$routes->post('umkm/edit_umkm', 'Umkm::edit_umkm');
$routes->get('umkm/kontrak-perjanjian', 'Umkm::kontrak_perjanjian');
$routes->post('umkm/kontrak_perjanjian_', 'Umkm::kontrak_perjanjian_');
$routes->get('umkm/produk', 'Umkm::produk');
$routes->post('umkm/produk_', 'Umkm::produk_');
$routes->post('umkm/create_produk', 'Umkm::create_produk');
$routes->post('umkm/update_produk', 'Umkm::update_produk');
$routes->post('umkm/delete_produk', 'Umkm::delete_produk');
$routes->get('umkm/kategori-produk', 'Umkm::kategori_produk');
$routes->get('umkm/laporan-transaksi', 'Umkm::transaksi');
$routes->post('umkm/transaksi_', 'Umkm::transaksi_');
$routes->post('umkm/kategori_produk_', 'Umkm::kategori_produk_');
$routes->post('umkm/create_kategori', 'Umkm::create_kategori');
$routes->post('umkm/update_kategori', 'Umkm::update_kategori');
$routes->post('umkm/delete_kategori', 'Umkm::delete_kategori');

//reseller backoffice
$routes->get('reseller/profil', 'Reseller::profil');
$routes->get('reseller/transaksi', 'Reseller::transaksi');
$routes->post('reseller/transaksi_', 'Reseller::transaksi_');
$routes->post('reseller/update_profil', 'Reseller::update_profil');
$routes->get('reseller/berita', 'Reseller::berita');
$routes->post('reseller/berita_', 'Reseller::berita_');
$routes->get('reseller/kerjasama', 'Reseller::kerjasama');
$routes->get('reseller/kerjasama/(:any)', 'Reseller::kerjasama_detail/$1');
$routes->get('reseller/pdf/(:any)', 'Reseller::kerjasama_pdf/$1');
$routes->get('reseller/pdf_download/(:any)', 'Reseller::kerjasama_pdf_download/$1');
$routes->post('reseller/pdf_upload', 'Reseller::kerjasama_pdf_upload');
$routes->post('reseller/update_bayar', 'Reseller::update_bayar');
$routes->post('reseller/kerjasama_', 'Reseller::kerjasama_');
$routes->get('reseller/transaksi/(:any)', 'Reseller::transaksi_detail/$1');
$routes->post('reseller/transaksi_', 'Reseller::transaksi_');
$routes->get('reseller/detail-berita/(:any)', 'Reseller::detail_berita/$1');

//ADMIN BackOffice
$routes->get('login', 'Login::index');
$routes->get('daftar-akun', 'Login::daftar');
$routes->get('logout', 'Login::logout');
$routes->post('login/proses', 'Login::proses');
$routes->post('daftar/proses', 'Login::daftar_');
$routes->get('admin/reseller', 'Admin::reseller');
$routes->get('admin/modul', 'Admin::modul');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/user', 'Admin::user');
$routes->post('admin/user_', 'Admin::user_');
$routes->post('admin/create_user', 'Admin::create_user');
$routes->post('admin/update_user', 'Admin::update_user');
$routes->post('admin/delete_user', 'Admin::delete_user');
$routes->get('admin/umkm', 'Admin::umkm');
$routes->post('admin/umkm_', 'Admin::umkm_');
$routes->post('admin/create_umkm', 'Admin::create_umkm');
$routes->post('admin/update_umkm', 'Admin::update_umkm');
$routes->post('admin/update_status_transaksi', 'Admin::update_status_transaksi');
$routes->post('admin/delete_umkm', 'Admin::delete_umkm');
$routes->get('admin/kategori-umkm', 'Admin::kategori_umkm');
$routes->post('admin/kategori_umkm_', 'Admin::kategori_umkm_');
$routes->post('admin/create_kategori_umkm', 'Admin::create_kategori_umkm');
$routes->post('admin/update_kategori_umkm', 'Admin::update_kategori_umkm');
$routes->post('admin/delete_kategori_umkm', 'Admin::delete_kategori_umkm');
$routes->get('admin/berita_kategori', 'Admin::berita_kategori');
$routes->post('admin/berita_kategori_', 'Admin::berita_kategori_');
$routes->post('admin/create_berita_kategori', 'Admin::create_berita_kategori');
$routes->post('admin/update_berita_kategori', 'Admin::update_berita_kategori');
$routes->post('admin/delete_berita_kategori', 'Admin::delete_berita_kategori');
$routes->get('admin/berita', 'Admin::berita');
$routes->post('admin/berita_', 'Admin::berita_');
$routes->post('admin/create_berita', 'Admin::create_berita');
$routes->post('admin/update_berita', 'Admin::update_berita');
$routes->post('admin/delete_berita', 'Admin::delete_berita');
$routes->get('admin/transaksi', 'Admin::transaksi');
$routes->post('admin/transaksi_', 'Admin::transaksi_');
$routes->get('admin/transaksi/(:any)', 'Admin::transaksi_detail/$1');

$routes->post('admin/kerjasama_', 'Admin::kerjasama_');
$routes->get('admin/kerjasama', 'Admin::kerjasama');
$routes->get('admin/kerjasama/(:any)', 'Admin::kerjasama_detail/$1');

$routes->get('admin/produk', 'Admin::produk');
$routes->post('admin/produk_', 'Admin::produk_');

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
