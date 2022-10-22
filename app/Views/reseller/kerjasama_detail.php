<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <div class="d-flex">
                    <h3>No: <?= $kerjasama->no_kerjasama ?></h3>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Kerja Sama Saya</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <H4><b>PIHAK PERTAMA</b></H4>
                    </div>
                    <div class="card-body box-profile">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->nama ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->alamat ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" disabled class="form-control" value="<?= $kerjasama->email ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->no_telepon ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">No. KTP (NIK)</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->no_ktp ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <H4><b>PIHAK KEDUA</b></H4>
                    </div>
                    <div class="card-body box-profile">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama Toko</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->nama_umkm ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->alamat_umkm ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="email" disabled class="form-control" value="<?= $kerjasama->telepon_umkm ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Kontrak</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->lama_kerjasama ?> Bulan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jumlah Produk</label>
                            <div class="col-sm-8">
                                <input type="text" disabled class="form-control" value="<?= $kerjasama->jumlah_produk ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <?php foreach ($this->server_side->getTransaksiPembayaran($kerjasama->no_kerjasama) as $pembayaran) : ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="card-text-title">
                                    <b>Transaksi Bulan Ke-<?= $pembayaran->bayar_bulan_ke; ?></b>
                                </div>
                                <div class="ml-auto">
                                    <span class="badge badge-danger"><?= str_replace("_", " ", $pembayaran->status); ?></span>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Batas Bayar</label>
                                <div class="col-sm-8">
                                    <input type="text" disabled class="form-control" name="batas_bayar" value="<?=$pembayaran->batas_bayar?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Status Pesanan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="status" value="" disabled></input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Bukti Bayar</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="bukti_bayar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <div class="card card-success card-outline">
                    <div class="card-header text-center">
                        <b>DAFTAR PESANAN</b>
                    </div>
                    <div class="card-body">
                        <?php
                        $total = 0;
                        foreach ($this->server_side->transaksi_by_kerjasama($kerjasama->no_kerjasama) as $t) : ?>
                            <table class="table table-sm" width="100%">
                                <?php foreach ($this->server_side->transaksi_detail($t->id) as $td) : ?>
                                    <tr>
                                        <td width="10%">
                                            <img src="<?= $td->foto ?>" alt="" class="img-fluid">
                                        </td>
                                        <td style="vertical-align:middle">
                                            <?= $td->nama ?>
                                        </td>
                                        <td style="vertical-align:middle" class="text-center"><?= $td->qty . ' ' . $td->satuan ?></td>
                                        <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($td->subtotal, 0, ',', '.') ?></b></td>
                                    </tr>
                                <?php $total += $td->subtotal;
                                endforeach; ?>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Sub Total</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($total, 0, ',', '.') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Kurir (<?= strtoupper($t->kurir) ?>)</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($t->ongkir, 0, ',', '.') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Total</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($total + $t->ongkir, 0, ',', '.') ?></b></td>
                                </tr>
                            </table>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 align-self-center">
                                    <div class="form-group">
                                        <p><b>Catatan Pesanan:</b><br> <?= ($t->catatan_beli != '') ? $t->catatan_beli : strtoupper($t->kurir) . ' - ' . $t->service ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>