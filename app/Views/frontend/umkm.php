<?php
use App\Models\ServerSideModel;
$this->server_side = new ServerSideModel();
?>

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
                        <a href="<?= $url ?>" class="url-kerjasama boxed-btn" style="width:100%"><i class="fas fa-plus-circle"></i> PENGAJUAN KERJA SAMA</a>
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
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Produk</h3>
                                                <p><?= $jumlah_produk;?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <div class="list-box d-flex align-items-center">
                                            <div class="list-icon">
                                            <i class="fas fa-home"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Bergabung</h3>
                                                <p><?= $this->server_side->formatTanggal($umkm->create_date, 'no');?></p>
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
                                                <p><?= $this->server_side->formatTanggal($umkm->logout_date);?></p>
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
                                <div class="row justify-content-center">
                                    <div class="col-md-4 align-self-center">
                                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Cari Produk">
                                        <input type="hidden" name="umkm" id="umkm" value="<?= $umkm->id ?>">
                                    </div>
                                    <div class="col-md-4 align-self-center">
                                        <select id="kategori" class="form-control">
                                            <option value="">- Semua Kategori -</option>
                                            <?php foreach ($produk_kategori as $kp) { ?>
                                                <option value="<?= $kp->id ?>"><?= $kp->kategori ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 align-self-center">
                                        <button type="button" class="btn btn-primary filter" style="width:100%">Terapkan</button>
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