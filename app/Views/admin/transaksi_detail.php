<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <div class="d-flex">
                    <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary">Kembali</a>
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
        <div class="row">
            <div class="col-md-7 align-self-center">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <H4><b>ALAMAT PENGIRIMAN</b></H4>
                    </div>
                    <div class="card-body box-profile">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Penerima</label>
                            <div class="col-sm-9 ">
                                <input type="text" disabled class="form-control" value="<?= $transaksi->nama ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9 ">
                                <input type="text" disabled class="form-control" value="<?= $transaksi->alamat ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9 ">
                                <input type="email" disabled class="form-control" value="<?= $transaksi->email ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No. Telepon</label>
                            <div class="col-sm-9 ">
                                <input type="text" disabled class="form-control" value="<?= $transaksi->nohp ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kurir</label>
                            <div class="col-sm-9 ">
                                <input type="text" disabled class="form-control" value="<?= strtoupper($transaksi->kurir) . ' ' . $transaksi->service ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No. Resi</label>
                            <div class="col-sm-9 ">
                                <input type="text" disabled class="form-control" value="<?= ($transaksi->no_resi != '') ? $transaksi->no_resi : '-' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 align-self-center">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <H4><b>STATUS PESANAN</b></H4>
                    </div>
                    <div class="card-body box-profile">
                        <form action="<?= base_url('admin/update_status_transaksi') ?>" method="POST">
                            <input type="hidden" name="id_pembayaran" value="<?=$transaksi->id_pembayaran?>">
                            <input type="hidden" name="kode_transaksi" value="<?=$transaksi->kode_transaksi?>">
                            <table width="100%">
                                <tr>
                                    <td><b>Status Pesanan</b></td>
                                    <td>:</td>
                                    <?php
                                    if ($transaksi->status == 'BELUM_DIBAYAR') {
                                        $status = '
                                        <div class="d-flex">
                                            <div class="badge badge-danger">Belum Diproses</div>
                                            <div class="align-self-center ml-2" data-toggle="modal" data-target="#modal-default" role="button"><i class="fas fa-upload text-danger"></i></div>
                                        </div>';
                                    } else {
                                        $status = '<select class="form-control form-control-sm" name="status_transaksi">';
                                        $selected_ = '';
                                        $selected__ = '';
                                        $selected___ = '';

                                        if ($transaksi->status == 'SEDANG_DIPROSES') {
                                            $selected_ = 'selected';
                                        } else if ($transaksi->status == 'SUDAH_DIKIRIM') {
                                            $selected__ = 'selected';
                                        } else if ($transaksi->status == 'SELESAI') {
                                            $selected___ = 'selected';
                                        }

                                        $status .= '<option value="SEDANG_DIPROSES" ' . $selected_ . '>Sedang Diproses</option>';
                                        $status .= '<option value="SUDAH_DIKIRIM" ' . $selected__ . '>Sudah Dikirim</option>';
                                        $status .= '<option value="SELESAI" ' . $selected___ . '>Selesai</option>';
                                        $status .= '</select>';
                                    }

                                    ?>
                                    <td><?= $status; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>No. Resi</b></td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="no_resi_transaksi" class="form-control form-control-sm" value="<?=$transaksi->no_resi?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Status Bayar</b></td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control form-control-sm" name="status_bayar">
                                            <option value="BELUM_DIBAYAR" <?= ($transaksi->status_bayar == 'BELUM_DIBAYAR') ? 'selected' : '' ?>>Belum Dibayar</option>
                                            <option value="MENUNGGU_KONFIRMASI" <?= ($transaksi->status_bayar == 'MENUNGGU_KONFIRMASI') ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                                            <option value="SUDAH_DIBAYAR" <?= ($transaksi->status_bayar == 'SUDAH_DIBAYAR') ? 'selected' : '' ?>>Sudah Dibayar</option>
                                            <option value="BATAL" <?= ($transaksi->status_bayar == 'BATAL') ? 'selected' : '' ?>>Kadaluarsa</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Keterangan</b></td>
                                    <td>:</td>
                                    <td><?= ($transaksi->keterangan_bayar != '') ? $transaksi->keterangan_bayar : '-'; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Batas Bayar</b></td>
                                    <td>:</td>
                                    <td><?= $this->server_side->formatTanggal($transaksi->batas_bayar); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Bukti Bayar</b></td>
                                    <td>:</td>
                                    <td><a href="<?= $transaksi->bukti_bayar ?>" target="_blank">Lihat</a></td>
                                </tr>
                            </table>
                            <hr>
                            <button type="submit" class="btn btn-success" style="width: 100%;">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-success card-outline">
                    <div class="card-header text-center">
                        <H4><b>DAFTAR PRODUK</b></H4>
                    </div>
                    <div class="card-body">
                        <p><b>Produk dari UMKM: <?= $transaksi->nama_toko; ?></b></p>
                        <?php
                        $total = 0;
                        $t = $this->server_side->transaksi_in_kode_detail($transaksi->kode_transaksi); ?>
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
                                <input type="hidden" class="form-control" name="id_pembayaran" value="<?= $transaksi->id_pembayaran ?>"></input>
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