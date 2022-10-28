<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Daftar Produk</p>
                    <h1><?= $kategori->nama; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- products -->
<div class="product-section mt-5 mb-2">
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($produk_umkm as $p) : ?>
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
                        <p class="product-price"> Rp <?= number_format($p->harga, 0, ',', '.'); ?> </p>
                        <a data-id="<?= $p->id ?>" data-img="<?= $p->foto ?>" data-produk="<?= $p->nama ?>" data-qty="1" data-harga="<?= $p->harga ?>" data-weight="<?= $p->weight ?>" data-umkm="<?= $p->id_umkm ?>" class="cart-btn add-cart btn-sm"><i class="fas fa-shopping-cart"></i> Masukkan Keranjang</a>
                        <hr>
                        <span><b><a href="<?= base_url('profil-umkm/' . $p->slug) ?>"><?= $p->nama_toko; ?></a></b></span><br>
                        <span><i class="fas fa-city mr-1"></i> <?= $p->city_name; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>