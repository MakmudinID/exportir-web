	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Detail</p>
						<h1><?= $produk->nama ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- single product -->
	<div class="single-product mt-40 mb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
						<img src="<?= $produk->foto ?>" alt="">
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3><?= $produk->nama ?></h3>
						<p class="single-product-pricing"><span>Per <?= $produk->satuan ?></span> Rp. <?= number_format($produk->harga, 0, ',', '.') ?></p>
						<p><strong>Kategori: </strong> <?= $produk->nama_kategori ?></p>
						<p><?= $produk->deskripsi ?></p>
	                    <div class="single-product-form">
							<input type="number" placeholder="0" name="qty" id="qty">
							<input type="hidden" name="id" value="<?=$produk->id?>" id="id">
							<input type="hidden" name="id_umkm" value="<?=$produk->id_umkm?>" id="id_umkm">
							<input type="hidden" name="produk" value="<?=$produk->nama?>" id="produk" >
							<input type="hidden" name="harga" value="<?=$produk->harga?>" id="harga" >
							<input type="hidden" name="img" value="<?=$produk->foto?>" id="img" >
							<input type="hidden" name="weight" value="<?=$produk->weight?>" id="weight" >
	                    </div>
						<a href="#" class="cart-btn tambah-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-150">
		<div class="container">
			<div class="section-title text-center">
				<h3>Produk <span class="orange-text">Lainnya</span></h3>
			</div>
			<div class="row justify-content-center">
				<?php foreach ($produk_related as $p) : ?>
					<div class="col-lg-3 col-md-3 col-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<a href="<?= base_url('/produk/' . $p->id) ?>"><img src="<?= $p->foto ?>" alt="<?= $p->nama ?>"></a>
							</div>
							<h3 ><?= $p->nama;?></h3>
							<p class="product-price"><span>Per <?= $p->satuan;?></span> Rp. <?= number_format($p->harga);?> </p>
							<a href="#" data-id='<?=$p->id?>' data-img='<?=$p->foto?>' data-produk='<?=$p->nama?>' data-qty='1' data-harga='<?=$p->harga?>' data-weight="<?=$p->weight?>" data-umkm='<?=$p->id_umkm?>' class="cart-btn add-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>

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
	<!-- end more products -->