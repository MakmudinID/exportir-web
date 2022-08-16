<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

    <!-- title -->
    <title>Sistem Exportir</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>/fruitkha/assets/img/favicon.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/bootstrap/css/bootstrap.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/owl.carousel.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/magnific-popup.css">
    <!-- animate css -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/animate.css">
    <!-- mean menu css -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/meanmenu.min.css">
    <!-- main style -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/main.css">
    <!-- responsive -->
    <link rel="stylesheet" href="<?=base_url()?>/fruitkha/assets/css/responsive.css">

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
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="<?=base_url('/')?>">
                                <img src="<?=base_url()?>/fruitkha/assets/img/logo.png" alt="">
                            </a>
                        </div>
                        <!-- logo -->

                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <li class="align-self-center"><input type="text" class="form-control"></li>
                                <li>
                                    <div class="header-icons">
                                        <a href="<?=base_url('/about')?>">Tentang</a>
                                        <a href="<?=base_url('/news')?>">Berita</a>
                                        <a class="shopping-cart" href="<?=base_url('/cart')?>"><i class="fas fa-shopping-cart"></i></a>
                                        <a class="btn btn-primary" href="<?=base_url('/login')?>">Login</a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- search area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Search For:</h3>
                            <input type="text" placeholder="Keywords">
                            <button type="submit">Search <i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search area -->
    <!-- hero area -->
	
	<!-- end hero area -->
    <?php echo view($main_content);?>

    <!-- footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">Tentang Aplikasi</h2>
                        <p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Kontak Kami</h2>
                        <ul>
                            <li>34/8, East Hukupara, Gifirtok, Sadan.</li>
                            <li>support@fruitkha.com</li>
                            <li>+00 111 222 3333</li>
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
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>, All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end copyright -->

    <!-- jquery -->
    <script src="<?=base_url()?>/fruitkha/assets/js/jquery-1.11.3.min.js"></script>
    <!-- bootstrap -->
    <script src="<?=base_url()?>/fruitkha/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- count down -->
    <script src="<?=base_url()?>/fruitkha/assets/js/jquery.countdown.js"></script>
    <!-- isotope -->
    <script src="<?=base_url()?>/fruitkha/assets/js/jquery.isotope-3.0.6.min.js"></script>
    <!-- waypoints -->
    <script src="<?=base_url()?>/fruitkha/assets/js/waypoints.js"></script>
    <!-- owl carousel -->
    <script src="<?=base_url()?>/fruitkha/assets/js/owl.carousel.min.js"></script>
    <!-- magnific popup -->
    <script src="<?=base_url()?>/fruitkha/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- mean menu -->
    <script src="<?=base_url()?>/fruitkha/assets/js/jquery.meanmenu.min.js"></script>
    <!-- sticker js -->
    <script src="<?=base_url()?>/fruitkha/assets/js/sticker.js"></script>
    <!-- main js -->
    <script src="<?=base_url()?>/fruitkha/assets/js/main.js"></script>
    <script>
        let base_url = "<?= base_url() ?>";
    </script>
    <?php if (isset($js)) {
        foreach ($js as $j) {
            echo '<script src="' . base_url() . '/my-js/' . $j . '"></script>';
        }
    } ?>
</body>

</html>