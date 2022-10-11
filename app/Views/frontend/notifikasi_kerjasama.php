<?php

use App\Models\ServerSideModel;

$cart_ = '';
$this->server_side = new ServerSideModel();
?>

<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>PROSES PENGAJUAN</p>
                    <h1>BERHASIL</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="checkout-section mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card bg-orange">
                    <div class="card-header">
                        <h5><?=$kode?></h5>
                    </div>
                    <div class="card-body text-center">
                        Pengajuan Kerjasama Berhasil
                        <hr>
                        <a href="<?=base_url('/')?>" class="btn btn-warning">Beranda</a>
                        <a href="<?=base_url('/reseller/kerjasamasaya')?>"  class="btn btn-primary">Kerjasama Saya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>