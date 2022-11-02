<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <div class="d-flex">
                    <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary">Kembali</a>
                    <h3 class="ml-3">No: <?= $pembayaran->kode_bayar ?></h3>
                </div>
            </div>
            <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Transaksi Penjualan</a></li>
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
                                <?= $pembayaran->nama; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">No. Handphone</label>
                            <div class="col-sm-8">
                                <?= $pembayaran->nohp; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Email</label>
                            <div class="col-sm-8 ">
                                <?= $pembayaran->email; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <?= $pembayaran->alamat . ', ' . $pembayaran->nama_kota . ', ' . $pembayaran->nama_propinsi; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Nomor Resi (<?= strtoupper($pembayaran->kurir) ?>)</label>
                            <div class="col-sm-8">
                                <?= ($pembayaran->no_resi != '') ? $pembayaran->no_resi : '-'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-sm-4">Total Tagihan</label>
                            <div class="col-sm-8">
                                Rp <?= number_format($pembayaran->total_tagihan, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Batas Bayar</label>
                            <div class="col-sm-8">
                                <?= $pembayaran->batas_bayar; ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Metode Bayar</label>
                            <div class="col-sm-8">
                                <?= $pembayaran->metode_bayar; ?> (<?= $pembayaran->nomor_rekening; ?>)
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Status Pembayaran</label>
                            <div class="col-sm-8">
                                <?php
                                if ($pembayaran->status_bayar == 'BELUM_DIBAYAR') {
                                    $status = '
                                <div class="d-flex">
                                    <div class="badge badge-danger">Belum Dibayar</div>
                                    <div class="align-self-center ml-2 unggah-bukti-bayar" data-id_pembayaran="' . $pembayaran->id . '" role="button"><i class="fas fa-upload text-danger"></i></div>
                                </div>';
                                } else if ($pembayaran->status_bayar == 'MENUNGGU_KONFIRMASI') {
                                    $status = '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                } else if ($pembayaran->status_bayar == 'SUDAH_DIBAYAR') {
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
                                <?= ($pembayaran->bukti_url != '') ? '<a href="' . $pembayaran->bukti_url . '" target="_blank">Lihat <i class="fas fa-eye"></i></a>' : '-' ?>
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
                        <b>DAFTAR TRANSAKSI</b>
                    </div>
                    <div class="card-body">
                        <?php foreach ($transaksi as $t) : ?>
                            <b>Nomor Transaksi: <a href="<?= base_url('/transaksi/nomor/' . $t->kode_transaksi) ?>"><?= $t->kode_transaksi; ?></a></b>
                            <div class="d-flex mb-2">
                                <div class="align-self-center"><b>Produk dari UMKM: <a href="<?= base_url('profil-umkm/' . $t->slug) ?>"><?= $t->nama_toko; ?></a></b></div>
                                <div class="ml-auto align-self-center">
                                    <?php
                                    if ($t->status == 'SEDANG_DIPROSES') {
                                        $status = '
                                    <div class="d-flex">
                                        <span class="badge badge-warning">SEDANG DIPROSES</span>
                                    </div>';
                                    } else if ($t->status == 'SUDAH_DIKIRIM') {
                                        $status = '
                                        <div class="d-flex">
                                            <span class="badge badge-primary">SUDAH DIKIRIM | Nomor Resi: ' . $t->no_resi . '</span>
                                            <div class="align-self-center ml-2 update-status-selesai" data-id_transaksi="' . $t->id . '" role="button"><i class="fas fa-edit"></i></div>
                                        </div>';
                                    } else if ($t->status == 'SELESAI') {
                                        $status = '<span class="badge badge-success">SELESAI</span>';
                                    } else {
                                        $status = '<span class="badge badge-danger">BATAL</span>';
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
                                    <?php $total = 0;
                                    foreach ($this->server_side->transaksi_detail($t->id) as $td) : ?>
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
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12 align-self-center">
                                    <b>Catatan Pesanan:</b> <?= ($t->catatan_beli != '') ? $t->catatan_beli : '-' ?>
                                </div>
                            </div>

                            <hr style="border-top: 3px solid #ffc107;">
                        <?php endforeach; ?>
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
                    <h4 class="modal-title">Unggah Bukti Bayar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Foto</label><br>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="preview_image(event)">
                                <input type="hidden" name="foto_" id="foto_">
                                <input type="hidden" class="form-control" name="id_pembayaran" value=""></input>
                            </div>
                            <div class="form-group" style="display:none" id="row-display">
                                <label for="output_image">Preview</label>
                                <div class="mt-2">
                                    <img id="output_image" class="img-thumbnail" width="200" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label><br>
                                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
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

<div class="modal fade" id="modal-selesai">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form-selesai">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Pesanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>Apakah pesanan anda sudah sampai? </h4>
                            <input type="hidden" class="form-control" name="id_transaksi" value=""></input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak, Belum Sampai</button>
                    <button type="submit" class="btn btn-primary">Ya, Sudah Sampai</button>
                </div>
            </form>
        </div>
    </div>
</div>