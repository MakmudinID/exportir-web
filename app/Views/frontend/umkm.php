<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Detail UMKM</p>
                    <h1><?= $umkm->nama; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<div class="single-product mt-40 mb-40">
    <div class="container">
        <div class="row">
            <div class="col-md-4 align-self-center mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="<?= $umkm->foto ?>" alt="">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= base_url() ?>" class="boxed-btn btn-sm"><i class="fas fa-plus-circle"></i> Pengajuan Kerjasama</a>
                        <a href="<?= base_url() ?>" class="boxed-btn btn-sm">Chat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 align-self-center mb-2">
                <div class="card">
                    <div class="card-body">
                        <?= $umkm->deskripsi; ?>
                        <hr>
                        <div class="list-section pt-3 pb-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <div class="list-box d-flex align-items-center">
                                            <div class="list-icon">
                                                <i class="fas fa-shipping-fast"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Produk</h3>
                                                <p>10</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <div class="list-box d-flex align-items-center">
                                            <div class="list-icon">
                                                <i class="fas fa-phone-volume"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Bergabung</h3>
                                                <p>24 Hari lalu</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="list-box d-flex justify-content-start align-items-center">
                                            <div class="list-icon">
                                                <i class="fas fa-sync"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Aktif</h3>
                                                <p>60 menit lalu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3>Produk <span class="orange-text"><?= $umkm->nama; ?></span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-filters">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-filter">
                                <div class="row">
                                    <div class="col-md-4 align-self-center">
                                        <label for="cari"></label>
                                        <input type="text" name="cari" class="form-control form-control-lg" placeholder="Cari Produk" id="cari">
                                        <input type="hidden" name="umkm" id="umkm" value="<?= $umkm->id ?>">
                                    </div>
                                    <div class="col-md-4 align-self-center">
                                        <label for="kategori"></label>
                                        <select id="kategori" class="form-control form-control-lg">
                                            <option value="">- Pilih Kategori -</option>
                                            <?php foreach ($produk_kategori as $kp) { ?>
                                                <option value="<?= $kp->id ?>"><?= $kp->kategori ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 align-self-center">
                                        <label for="jenis"></label>
                                        <select id="jenis" class="form-control form-control-lg">
                                            <option value="TERLARIS">Terlaris</option>
                                            <option value="TERBARU">Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" id="list-produk"></div>
    </div>
</div>