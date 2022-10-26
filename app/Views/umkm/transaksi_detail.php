<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <div class="d-flex">
                    <a href="<?= base_url('umkm/laporan-transaksi') ?>" class="btn btn-secondary">Kembali</a>
                    <h3 class="ml-3">No: <?= $transaksi->kode_transaksi ?></h3>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-4">Nama Penerima</label>
                            <div class="col-sm-8">
                                <?= $transaksi->nama; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">No. Handphone</label>
                            <div class="col-sm-8">
                                <?= $transaksi->nohp; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Email</label>
                            <div class="col-sm-8 ">
                                <?= $transaksi->email; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <?= $transaksi->alamat . ', ' . $transaksi->nama_kota . ', ' . $transaksi->nama_propinsi; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-4">Total Tagihan</label>
                            <div class="col-sm-8">
                                Rp <?= number_format($transaksi->total_tagihan, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($transaksi->status_bayar != 'BELUM_DIBAYAR' && $transaksi->status_bayar != 'BATAL') : ?>
                                <label class="col-sm-4">Tanggal Bayar</label>
                                <div class="col-sm-8">
                                    <?= $transaksi->tanggal_bayar; ?>
                                </div>
                            <?php else : ?>
                                <label class="col-sm-4">Batas Bayar</label>
                                <div class="col-sm-8">
                                    <?= $transaksi->batas_bayar; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Status Pembayaran</label>
                            <div class="col-sm-8">
                                <?php
                                if ($transaksi->status_bayar == 'BELUM_DIBAYAR') {
                                    $status = '
                                <div class="d-flex">
                                    <div class="badge badge-danger">Belum Dibayar</div>
                                    <div class="align-self-center ml-2 unggah-bukti-bayar" data-id_pembayaran="' . $pembayaran->id . '" role="button"><i class="fas fa-upload text-danger"></i></div>
                                </div>';
                                } else if ($transaksi->status_bayar == 'MENUNGGU_KONFIRMASI') {
                                    $status = '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                } else if ($transaksi->status_bayar == 'SUDAH_DIBAYAR') {
                                    $status = '<span class="badge badge-success">Lunas</span>';
                                } else {
                                    $status = '<span class="badge badge-danger">Batal</span>';
                                }
                                echo $status;
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Bukti Pembayaran</label>
                            <div class="col-sm-8">
                                <?= ($transaksi->bukti_url != '') ? '<a href="' . $transaksi->bukti_url . '" target="_blank">Lihat <i class="fas fa-eye"></i></a>' : '-' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-warning card-outline">
                    <div class="card-header text-center">
                        <b>DAFTAR PESANAN</b>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-2">
                            <div class="align-self-center"><b>Produk dari UMKM: <a href="<?= base_url('profil-umkm/' . $transaksi->slug) ?>"><?= $transaksi->nama_toko; ?></a></b></div>
                            <div class="ml-auto align-self-center">
                                <?php
                                if ($transaksi->status == 'SEDANG_DIPROSES') {
                                    $status = '
                                    <div class="d-flex">
                                        <span class="badge badge-warning">Perlu Disiapkan</span>
                                        <div class="align-self-center ml-2 update-status" data-id_transaksi="' . $transaksi->id . '" role="button"><i class="fas fa-edit"></i></div>
                                    </div>';
                                } else if ($transaksi->status == 'SUDAH_DIKIRIM') {
                                    $status = '<span class="badge badge-primary">No. Resi Kurir: '.$transaksi->no_resi.'</span>';
                                } else if ($transaksi->status == 'SELESAI') {
                                    $status = '<span class="badge badge-success">Selesai</span>';
                                } else {
                                    $status = '<span class="badge badge-danger">Batal</span>';
                                }
                                ?>
                                <h5><?= $status ?></h5>
                            </div>
                        </div>
                        <table class="table table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">
                                        PRODUK
                                    </th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">HARGA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($this->server_side->transaksi_detail($transaksi->id) as $td) : ?>
                                    <tr>
                                        <td width="8%" style="vertical-align:middle">
                                            <img src="<?= $td->foto ?>" alt="" class="img-fluid">
                                        </td>
                                        <td style="vertical-align:middle">
                                            <?= $td->nama ?>
                                        </td>
                                        <td style="vertical-align:middle" class="text-center" width="8%"><?= $td->qty . ' ' . $td->satuan ?></td>
                                        <td style="vertical-align:middle" class="text-right" width="20%">Rp <?= number_format($td->subtotal, 0, ',', '.') ?></td>
                                    </tr>
                                <?php
                                endforeach; ?>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Sub Total</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($transaksi->jumlah, 0, ',', '.') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Kurir (<?= strtoupper($transaksi->kurir) ?>)</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($transaksi->ongkir, 0, ',', '.') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="vertical-align:middle" class="text-right"><b>Total</b></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($transaksi->jumlah + $transaksi->ongkir, 0, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 align-self-center">
                                <b>Catatan Pesanan:</b> <?= ($transaksi->catatan_beli != '') ? $transaksi->catatan_beli : '-' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form-bukti">
                <div class="modal-header">
                    <h4 class="modal-title">Kirim Pesanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="no_resi">No. Resi Kurir</label><br>
                                <input type="text" class="form-control" name="no_resi" id="no_resi">
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto Bukti Kirim</label><br>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="preview_image(event)">
                                <input type="hidden" class="form-control" name="id_transaksi" value=""></input>
                            </div>
                            <div class="form-group" style="display:none" id="row-display">
                                <label for="output_image">Preview</label>
                                <div class="mt-2">
                                    <img id="output_image" class="img-thumbnail" width="200" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>