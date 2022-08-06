	<!-- product section -->
	<div class="product-section mt-100 mb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3>Produk <span class="orange-text">Terlaris</span> Bulan ini </h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row justify-content-center">
				<?php foreach($produk as $p): ?>
				<div class="col-lg-4 col-md-4 col-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="<?=base_url('/produk/')?>1"><img src="<?=$p->foto?>" alt="<?=$p->nama?>"></a>
						</div>
						<h3 ><?= $p->nama;?></h3>
						<p class="product-price"><span>Per <?= $p->satuan;?></span> Rp. <?= number_format($p->harga);?> </p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<a href="<?= base_url('list-produk') ?>" class="boxed-btn">Lihat Lebih Lengkap <i class="fas fa-shopping-cart"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- testimonail-section -->
	<div class="testimonail-section  mb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<div class="testimonial-sliders">
						<?php if(count($umkm) > 0){ ?>
						<?php foreach($umkm as $val){ ?>
						<div class="single-testimonial-slider">
							<div class="row clearfix">
            					<!--Image Column-->
								<div class="image-column col-lg-6">
									<div class="image">
										<img src="<?= $val->foto?>" alt="">
									</div>
								</div>
								<!--Content Column-->
								<div class="content-column col-lg-6">
									<h4><?= $val->nama ?></h4>
									<div class="text"><?= strip_tags($val->deskripsi) ?></div>
									<!--Countdown Timer-->
									<a href="cart.html" class="cart-btn mt-3">Lihat UMKM</a>
								</div>
							</div>
						</div>
						<?php }
						}else{
						?>
						<div class="single-testimonial-slider">
							<div class="row clearfix">
            					<!--Image Column-->
								<div class="image-column col-lg-6">
									<div class="image">
										<img src="<?= $val[0]->foto?>" alt="">
									</div>
								</div>
								<!--Content Column-->
								<div class="content-column col-lg-6">
									<h4><?= $val[0]->nama ?></h4>
									<div class="text"><?= strip_tags($val[0]->deskripsi) ?></div>
									<!--Countdown Timer-->
									<a href="cart.html" class="cart-btn mt-3">Lihat UMKM</a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end testimonail-section -->

	<!-- latest news -->
	<div class="latest-news">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3>Berita <span class="orange-text">Terbaru</span></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row">
			<?php foreach($berita as $b){ ?>
				<div class="col-lg-4 col-md-6">
					<div class="single-latest-news">
						<a href="single-news.html"><img src="<?=$b->foto?>" alt="<?= $b->judul;?>" style="float: left;width:100%;height:200px;object-fit: cover;"></a>
						<div class="news-text-box">
							<h3><a href="single-news.html"><?= $b->judul;?></a></h3>
	                        <p class="blog-meta">
	                            <span class="author"><i class="fas fa-user"></i> <?= $b->penulis;?></span>
	                            <span class="date"><i class="fas fa-calendar"></i> <?= $b->create_date;?></span>
	                        </p>
	                        <p class="excerpt"><?= html_entity_decode($b->ringkasan);?></p>
	                        <a href="single-news.html" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="row mb-100">
		<div class="col-lg-12 text-center">
			<a href="news.html" class="boxed-btn">More News</a>
		</div>
	</div>
	<!-- end latest news -->
