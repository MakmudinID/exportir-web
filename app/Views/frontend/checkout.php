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
        <form id="form-order">
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
                            <?php $no=1;
                                foreach ($transaksi as $t) : ?>
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
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-6 align-self-center">
                                        <div class="form-group">
                                            <p><b>Catatan Pesanan:</b></p>
                                            <?= ($t->catatan_beli != '') ? $t->catatan_beli : '-' ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Metode Pengiriman:</b></label>
                                            <select class="form-control form-control-sm pilih-kurir" id="kurir<?=$no?>" name="kurir">
                                                <?php '<option value="">- Pilih Metode Pengiriman -</option>';
                                                // for ($c = 0; $c < count(${"cekOngkir$no"}['rajaongkir']['results']); $c++) {
                                                //     echo "<optgroup label='" . ${"cekOngkir$no"}['rajaongkir']['results'][$c]['name'] . "'>";
                                                //     $layanan = ${"cekOngkir$no"}['rajaongkir']['results'][$c]['costs'];
                                                //     for ($i = 0; $i < count($layanan); $i++) {
                                                //         $tarif = $layanan[$i]['cost'];
                                                //         for ($j = 0; $j < count($tarif); $j++) {
                                                //             $nilai = ${"cekOngkir$no"}['rajaongkir']['results'][$c]['code'] . ":" . $layanan[$i]['service'] . ":" . $tarif[$j]['etd'] . ":" . $tarif[$j]['value'];
                                                //             echo "<option ketentuan='' data-keranjang='" . $t->id . "' data-ongkir='" . $tarif[$j]['value'] . "' data-service='$nilai' value='$j' data-info_kurir='" . ${"cekOngkir$no"}['rajaongkir']['results'][$c]['name'] . " - " . $layanan[$i]['service'] . " (" . $tarif[$j]['etd'] . " hari)'>" . $layanan[$i]['service'] . " (" . $tarif[$j]['etd'] . " hari) Rp " . number_format($tarif[$j]['value'], 0, ',', '.');
                                                //         }
                                                //     }
                                                // }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 4px solid #F3F4F5;">
                            <?php $no++; endforeach; ?>
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
                                        <td>Pembelian</td>
                                        <td id="subtotal" class="text-right"><b><?= number_format(0, 0) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Kurir</td>
                                        <td id="shipping" class="text-right"><b>0</b></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pembayaran</td>
                                        <td id="total" class="text-right"><b><?= number_format(0, 0) ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" value="<?= $id_transaksi ?>">
                            <button type="submit" id="order" style="width:100%" class="btn btn-primary btn-rounded">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>