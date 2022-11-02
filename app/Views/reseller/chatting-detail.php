<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<div class="container">
    <div class="card mt-2 card-primary card-outline direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Direct Chat: <b><?= $this->server_side->getNama($id_penerima);?></b></h3>
            <div class="card-tools">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-default"><i class="fas fa-list-alt"></i> <?= $kode_transaksi; ?></a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="direct-chat-messages" id="historiObrolan" style="height: 350px !important">
                <!-- PENGIRIM SEBELAH Kiri
                PENERIMA SEBELAH Kanan -->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <form id="form-pesan">
                <div class="input-group">
                    <input type="text" class="write_msg form-control" name="pesan" id="pesan" placeholder="Ketikkan sebuah pesan" required />
                    <input type="hidden" id="kode_transaksi" name="kode_transaksi" value="<?=$kode_transaksi?>">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-primary kirim-pesan">Kirim</button>
                    </span>
                </div>
            </form>
        </div>
        <!-- /.card-footer-->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Transaksi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center mt-2">
                        <?php foreach ($this->server_side->getTransaksiKodeResult($kode_transaksi) as $transaksi) : ?>
                            <div class="col-md-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 align-self-center">
                                                <div class="text-center">
                                                    <a href="javascript(void:0)">No. <?= $transaksi->kode_transaksi; ?></a>
                                                </div>
                                                <?php if ($transaksi->status == "BELUM_DIBAYAR") {
                                                    $badge = "badge-danger";
                                                } else if ($transaksi->status == "SUDAH_DIBAYAR") {
                                                    $badge = "badge-success";
                                                } else if ($transaksi->status == "BATAL") {
                                                    $badge = "badge-danger";
                                                } else if ($transaksi->status == "MENUNGGU_KONFIRMASI") {
                                                    $badge = "badge-warning";
                                                } ?>
                                                <div class="d-flex justify-content-center">
                                                    <?php if ($transaksi->status != "BELUM_DIBAYAR" && $transaksi->status != "BATAL") : ?>
                                                        <a href="<?= $transaksi->bukti_url ?>" class="ml-2" target="_blank"> Lihat <i class="fas fa-eye"></i></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <?php if ($transaksi->status == "BELUM_DIBAYAR" || $transaksi->status == "BATAL") : ?>
                                                    <div class="row">
                                                        <label class="col-sm-4">Kode Bayar</label>
                                                        <div class="col-sm-8">
                                                            <?= $transaksi->kode_bayar ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-4">Metode Bayar</label>
                                                        <div class="col-sm-8">
                                                            <?= $transaksi->metode_bayar; ?> (<?= $transaksi->nomor_rekening; ?>)
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-sm-4">Batas Bayar</label>
                                                        <div class="col-sm-8">
                                                            <?= $this->server_side->formatTanggal($transaksi->batas_bayar) ?>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="row">
                                                    <label class="col-sm-4">Tanggal Kirim</label>
                                                    <div class="col-sm-8">
                                                        <?= $this->server_side->formatTanggal($transaksi->tanggal_kirim) ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4">Status Pesanan</label>
                                                    <div class="col-sm-8">
                                                        <?php
                                                        if ($transaksi->status == 'SUDAH_DIBAYAR') {
                                                            $status = '
                                                    <div class="d-flex">
                                                        <span class="badge badge-warning">Perlu Disiapkan</span>
                                                    </div>';
                                                        } else if ($transaksi->status == 'SUDAH_DIKIRIM') {
                                                            $status = '<small><b>Sedang Dikirim</b></small> <span class="badge badge-secondary">No. Resi: ' . $transaksi->no_resi . '</span>';
                                                        } else if ($transaksi->status == 'SELESAI') {
                                                            $status = '<span class="badge badge-success">Selesai</span>';
                                                        } else if ($transaksi->status == 'BELUM_DIBAYAR') {
                                                            $status = '<span class="badge badge-danger">Belum Dibayar</span>';
                                                        } else {
                                                            $status = '<span class="badge badge-danger">Batal</span>';
                                                        }
                                                        ?>
                                                        <h5><?= $status ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <?php
                                            $total = 0;
                                            ?>
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
                                                    <?php $total += $td->subtotal;
                                                    endforeach; ?>
                                                    <tr>
                                                        <td colspan="3" style="vertical-align:middle" class="text-right"><b>Sub Total</b></td>
                                                        <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($total, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="vertical-align:middle" class="text-right"><b>Kurir (<?= strtoupper($transaksi->kurir) ?>)</b></td>
                                                        <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($transaksi->ongkir, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="vertical-align:middle" class="text-right"><b>Total</b></td>
                                                        <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($transaksi->total_tagihan, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 align-self-center">
                                                    <div class="form-group">
                                                        <p><b>Catatan Pesanan:</b> <?= ($transaksi->catatan_beli != '') ? $transaksi->catatan_beli : '-' ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>