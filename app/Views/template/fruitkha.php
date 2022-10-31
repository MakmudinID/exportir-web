<?php $session = \Config\Services::session();

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Toko Rempah</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/fruitkha/assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="<?= base_url() ?>/fruitkha/assets/css/responsive.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body>

	<!--PreLoader-->
	<div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
		</div>
	</div>
	<!--PreLoader Ends-->

	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12 col-sm-12 align-self-center text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="<?= base_url('/') ?>">
								<img src="<?= base_url() ?>/fruitkha/assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li <?=($title == 'Home') ? 'class="current-list-item"' : ''?>><a href="<?= base_url('/') ?>">Home</a></li>
								<li <?=($title == 'Kategori') ? 'class="current-list-item"' : ''?>>
									<a href="<?= base_url('/list-produk') ?>">Kategori</a>
									<ul class="sub-menu">
										<?php foreach($this->server_side->getKategoriUMKMreal() as $k):?>
											<li><a href="<?= base_url('/kategori/'.$k->id)?>"><?= $k->nama;?></a></li>
										<?php endforeach; ?>
									</ul>
								</li>
								<li <?=($title == 'Berita') ? 'class="current-list-item"' : ''?>><a href="<?= base_url('/list-berita') ?>">Berita</a></li>
								<li>
									<div class="header-icons">
										<?php if ($session->get("role") == "RESELLER") { ?>
											<a class="shopping-cart" href="<?= base_url('/cart') ?>"><i class="fas fa-shopping-cart"></i> <span class="badge badge-primary total-cart">0</span></a>
											<a href="<?= base_url('/reseller/profil') ?>"><i class="fas fa-user"></i> Profil</a>
											<a href="<?= base_url('/logout') ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
										<?php } else if ($session->get("role") == "UMKM") { ?>
											<a href="<?= base_url('/umkm/profil') ?>"><i class="fas fa-user"></i> Profil</a>
											<a href="<?= base_url('/logout') ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
										<?php } else if ($session->get("role") == "SUPERADMIN") { ?>
											<a class="shopping-cart" href="<?= base_url('/login') ?>"><i class="fas fa-shopping-cart"></i> <span class="badge badge-primary total-cart">0</span></a>
											<a href="<?= base_url('/admin/dashboard') ?>"><i class="fas fa-user"></i> Profil</a>
											<a href="<?= base_url('/logout') ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
										<?php } else { ?>
											<a class="shopping-cart" href="<?= base_url('/login') ?>"><i class="fas fa-shopping-cart"></i> <span class="badge badge-primary total-cart">0</span></a>
											<a href="<?= base_url('/login') ?>"><i class="fa fa-sign-in-alt"></i> Login</a>
										<?php } ?>
									</div>
								</li>
							</ul>
						</nav>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- hero area -->
	<?php echo view($main_content); ?>
	<!-- end hero area -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Website ini di buat untuk dapat memberikan kemudahan dan membantu UMKM dalam memperluas dan meningkatkan bisnis serta membangun kerjasama dengan beberapa reseller dan importin lokal secara terpercaya dan mudah.</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>Prodi Informatika, Universitas Al Azhar Indonesia</li>
							<li>support@toko-rempah.com</li>
							<li>+62 838-7199-8220</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->

	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-12 text-center">
					<p>Copyrights &copy; <?= date('Y'); ?> - <a href="https://toko-rempah.com/">Yasmin</a>, All Rights Reserved.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->

	<!-- jquery -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="<?= base_url() ?>/fruitkha/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="<?= base_url() ?>/fruitkha/assets/js/main.js"></script>

	<script src="<?= base_url() ?>/assets/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/jquery-validation/additional-methods.min.js"></script>

	<script src="<?= base_url() ?>/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script>
		let base_url = "<?= base_url() ?>";
		$(document).ready(function() {
			$.ajax({
				url: base_url + '/count_cart',
				type: 'GET',
				success: function(res) {
					console.log(res);
					$('.total-cart').html(res);
				}
			})
		})
	</script>
	<script src="<?= base_url('/my-js/home.js') ?>"></script>
	<?php if (isset($js)) {
		foreach ($js as $j) {
			echo '<script src="' . base_url() . '/my-js/' . $j . '"></script>';
		}
	} ?>
</body>

</html>