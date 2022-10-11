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
                    <p>Transaksi</p>
                    <h1>Checkout Produk</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="checkout-section mt-5 mb-5">
    <div class="container">
        <form method="POST" action="<?=base_url('proses_checkout')?>">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Alamat Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <b>Nama Penerima:</b> <?= $pemesan->nama; ?><br>
                            <b>No. Handphone:</b> <?= $pemesan->nohp; ?><br>
                            <b>Alamat:</b> <?= $pemesan->alamat; ?>, <?= $pemesan->nama_kota; ?>, <?= $pemesan->nama_propinsi; ?>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Daftar Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <?php 
                            $total=0;    
                            foreach ($transaksi as $t) : 
                                $jumlah_berat = $this->server_side->jumlah_berat($t->id);
                            ?>
                                <b>Barang dari <?= $t->nama_toko ?></b>
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
                                                <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($td->subtotal, 0, ',', '.') ?></b></td>
                                            </tr>
                                        <?php $total+= $td->subtotal; endforeach; ?>
                                    </tbody>
                                </table>
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
                                            <select class="form-control form-control-sm pilih-kurir" data-id="<?=$t->id?>" data-kota_asal="<?=$t->city_id?>" data-kota_penerima="<?=$t->kota_pengirim?>" data-total_berat="<?=$jumlah_berat?>" id="metode_<?=$t->id?>" name="metode_<?=$t->id?>">
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
                                                <select class="form-control form-control-sm pilih-layanan" data-id="<?=$t->id?>" id="layanan_<?=$t->id?>" name="layanan_<?=$t->id?>">
                                                    <option value="">- Pilih Layanan -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 4px solid #F3F4F5;">
                            <?php $t->id++; endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td><b>Pembelian</b></td>
                                        <td id="subtotal" class="text-right"><b>Rp <?= number_format($total, 0,',','.') ?></b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Kurir</b></td>
                                        <td id="shipping" class="text-right"><b>Rp -</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Pembayaran</b></td>
                                        <td id="total" class="text-right"><b>Rp <?= number_format($total, 0,',','.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" value="<?= $id_transaksi ?>" name="id_transaksi">
                            <button type="submit" id="btn-order" style="width:100%" class="btn btn-primary btn-rounded" disabled><b>Bayar Sekarang</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>