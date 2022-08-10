	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 offset-lg-2 text-center">
	                <div class="breadcrumb-text">
	                    <p>See more Details</p>
	                    <h1>Single Product</h1>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end breadcrumb section -->
    
	<!-- single product -->
	<div class="single-product mt-150 mb-150">
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
	                    <p class="single-product-pricing"><span>Per <?= $produk->satuan?></span> Rp. <?= number_format($produk->harga,0,',','.')?></p>
	                    <p><strong>Kategori: </strong> <?= $produk->nama_kategori ?></p>
						<p><?= $produk->deskripsi ?></p>
	                    <div class="single-product-form">
	                        <form action="index.html">
	                            <input type="number" placeholder="0">
	                        </form>
	                        <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-150">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 offset-lg-2 text-center">
	                <div class="section-title">
	                    <h3>Produk yang <span class="orange-text">Mirip</span></h3>
	                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
	                </div>
	            </div>
	        </div>
			<div class="row justify-content-center">
				<?php foreach($produk_related as $p): ?>
				<div class="col-lg-4 col-md-4 col-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<a href="<?=base_url('/produk/'.$p->id)?>"><img src="<?=$p->foto?>" alt="<?=$p->nama?>"></a>
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
	<!-- end more products -->