<?php

use App\Models\ServerSideModel;

$cart_ = '';
$this->server_side = new ServerSideModel();
?>
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Pengajuan Kerjasama</p>
                    <h1><?= $umkm->nama; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<div class="single-product mt-40 mb-40">
    <div class="container">
        <form id="form-kerjasama">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="section-title text-center">
                        <h3>PIHAK <span class="orange-text">PERTAMA</span></h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= session()->get('nama') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" id="email" value="<?= session()->get('email') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nik" class="col-sm-3 col-form-label">No. KTP (NIK)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nik" name="nik" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-9">
                    <div class="section-title text-center">
                        <h3>PIHAK <span class="orange-text">KEDUA</span></h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="id_umkm" id="id_umkm" value="<?= $umkm->id ?>">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label align-self-center">Nama Toko</label>
                                <div class="col-sm-9 align-self-center">
                                    : <?= $umkm->nama; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label align-self-center">Alamat</label>
                                <div class="col-sm-9 align-self-center">
                                    : <?= $umkm->alamat; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label align-self-center">No. Telepon</label>
                                <div class="col-sm-9 align-self-center">
                                    : <?= $umkm->no_telepon; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kontrak" class="col-sm-3 col-form-label align-self-center">Kontrak Kerjasama</label>
                                <div class="col-sm-9 align-self-center">
                                    <select name="kontrak" id="kontrak" class="form-control">
                                        <option value=""></option>
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-9">
                    <div class="section-title text-center">
                        <h3>DAFTAR <span class="orange-text">BARANG</span></h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <?php
                            $total = 0;
                            foreach ($transaksi as $t) :
                                $jumlah_berat = $this->server_side->jumlah_berat($t->id);
                            ?>
                                <div class="row">
                                    <div class="col-md-12 align-self-center">
                                        <div class="form-group">
                                            <p><b>Catatan Pesanan:</b></p>
                                            <?= ($t->catatan_beli != '') ? $t->catatan_beli : '-' ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Metode Pengiriman:</b></label>
                                            <select class="form-control form-control-sm pilih-kurir" data-id="<?= $t->id ?>" data-kota_asal="<?= $t->city_id ?>" data-kota_penerima="<?= $t->kota_pengirim ?>" data-total_berat="<?= $jumlah_berat ?>" id="metode_<?= $t->id ?>" name="metode[]">
                                                <option value="">- Pilih Pengiriman -</option>
                                                <option value="jne">JNE</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pos">POS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Layanan:</b></label>
                                            <div class="selecter">
                                                <select class="form-control form-control-sm pilih-layanan" data-id="<?= $t->id ?>" id="layanan_<?= $t->id ?>" name="layanan[]">
                                                    <option value="">- Pilih Layanan -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-sm">
                                    <tbody>
                                        <?php foreach ($this->server_side->transaksi_detail($t->id) as $td) : ?>
                                            <tr>
                                                <td class="product-image" width="60%">
                                                    <div class="d-flex">
                                                        <div class="p-2 align-self-center">
                                                            <img src="<?= $td->foto ?>" alt="">
                                                        </div>
                                                        <div class="p-2 align-self-center">
                                                            <?= $td->nama ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align:middle" class="text-center" width="10%"><?= $td->qty . ' ' . $td->satuan ?></td>
                                                <td style="vertical-align:middle" class="text-right">Rp <?= number_format($td->subtotal, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php $total += $td->subtotal;
                                        endforeach; ?>
                                        <tr>
                                            <td colspan="2" class="text-right"><b>Ongkos Kirim</b></td>
                                            <td class="text-right"><span id="shipping">Rp <?= number_format(0, 0, ',', '.') ?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right"><b>Total Bayar</b></td>
                                            <td class="text-right"><span id="total">Rp <?= number_format($total, 0, ',', '.') ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php $t->id++;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?= base_url('/umkm/' . $umkm->slug) ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>