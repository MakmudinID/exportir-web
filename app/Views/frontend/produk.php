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
						Terjual <?= $produk->satuan ?>
						<hr>
						<p class="single-product-pricing">
							Rp <?= number_format($produk->harga, 0, ',', '.') ?>/<?= $produk->satuan ?>
						</p>
						<p><strong>Kategori: </strong> <?= $produk->nama_kategori ?></p>
						<p><?= $produk->deskripsi ?></p>
						<div class="d-flex">
							<div class="single-product-form">
								<input type="number" placeholder="0" name="qty" id="qty" class="form-control">
								<input type="hidden" name="id" value="<?= $produk->id ?>" id="id">
								<input type="hidden" name="id_umkm" value="<?= $produk->id_umkm ?>" id="id_umkm">
								<input type="hidden" name="produk" value="<?= $produk->nama ?>" id="produk">
								<input type="hidden" name="harga" value="<?= $produk->harga ?>" id="harga">
								<input type="hidden" name="img" value="<?= $produk->foto ?>" id="img">
								<input type="hidden" name="weight" value="<?= $produk->weight ?>" id="weight">
							</div>
							<a href="#" class="cart-btn tambah-cart btn-sm ml-2"><i class="fas fa-shopping-cart"></i> Masukkan Keranjang</a>
						</div>
						<hr>
							<i class="fas fa-store mr-2 align-self-center"></i>
							<label><a href="<?=base_url('profil-umkm/'.$produk->slug)?>"><b><?= $produk->nama_umkm ?></b></a></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-3">
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
							<label style="font-size:17px">
								<a href="<?= base_url('/produk/' . $p->id) ?>">
									<b><?= $p->nama; ?></b>
								</a>
							</label>
							<p class="product-price"> Rp <?= number_format($p->harga, 0, ',','.'); ?> </p>
							<a data-id="<?= $p->id ?>" data-img="<?= $p->foto ?>" data-produk="<?= $p->nama ?>" data-qty="1" data-harga="<?= $p->harga ?>" data-weight="<?=$p->weight?>" data-umkm="<?= $p->id_umkm ?>" class="cart-btn add-cart btn-sm"><i class="fas fa-shopping-cart"></i> Masukkan Keranjang</a>
							<hr>
							<span><b><a href="<?=base_url('profil-umkm/'.$p->slug)?>"><?= $p->nama_toko; ?></a></b></span><br>
							<span><i class="fas fa-city mr-1"></i> <?= $p->city_name; ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<a href="<?= base_url('list-produk') ?>" class="boxed-btn btn-sm">Lihat Lebih Lengkap</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end more products -->