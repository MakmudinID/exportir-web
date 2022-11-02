<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel(); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <div class="d-flex">
                    <a href="<?= base_url('admin/kerjasama') ?>" class="btn btn-secondary">Kembali</a>
                    <h3 class="ml-3">
                        <a href="<?= base_url('reseller/pdf/' . $kerjasama->no_kerjasama) ?>" target="_blank" class="p-1"><i class="fas fa-file-pdf"></i> No: <?= $kerjasama->no_kerjasama ?></a>
                    </h3>
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
        <?php if ($kerjasama->status == 'SUDAH_UPLOAD') { ?>
            <div class="alert alert-warning">
                <div class="d-flex">
                    <div class="fw-bold align-self-center">
                        <i class="icon fas fa-info-circle"></i> Silakan Konfirmasi Pengajuan Kerjasama Ini
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary update-konfirmasi" data-no_kerjasama="<?= $kerjasama->no_kerjasama ?>">Menyetujui</button>
                        <button type="button" class="btn btn-danger update-batal" data-no_kerjasama="<?= $kerjasama->no_kerjasama ?>">Tidak Menyetujui</button>
                    </div>
                </div>
            </div>
        <?php } else if ($kerjasama->status == 'DITOLAK') { ?>
            <div class="alert alert-danger">
                <div class="d-flex">
                    <div class="fw-bold align-self-center">
                        <i class="icon fas fa-info-circle"></i> Pengajuan kerjasama ini <B>DITOLAK</B>, karena: <?= $kerjasama->alasan_ditolak; ?>
                    </div>
                </div>
            </div>
        <?php }; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <h5><b>PIHAK PERTAMA</b></h5>
                    </div>
                    <div class="card-body box-profile">
                        <div class="row">
                            <label class="col-sm-4">Nama</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->nama ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->alamat ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Email</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->email ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">No. Telepon</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->no_telepon ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">No. KTP (NIK)</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->no_ktp ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <h5><b>PIHAK KEDUA</b></h5>
                    </div>
                    <div class="card-body box-profile">
                        <div class="row">
                            <label class="col-sm-4">Nama Toko</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->nama_umkm ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->alamat_umkm ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">No. Telepon</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->telepon_umkm ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Kontrak</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->lama_kerjasama ?> Bulan
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Jumlah Produk</label>
                            <div class="col-sm-8">
                                <?= $kerjasama->jumlah_produk ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($this->server_side->getTransaksiPembayaran($kerjasama->no_kerjasama) as $pembayaran) : ?>
                <div class="col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 align-self-center">
                                    <div class="text-center">
                                        <h4>Transaksi Bulan Ke-<?= $pembayaran->bayar_bulan_ke; ?></h4>
                                        <a href="javascript(void:0)">No. <?= $pembayaran->kode_transaksi; ?></a>
                                    </div>
                                    <?php if ($pembayaran->status == "BELUM_DIBAYAR") {
                                        $badge = "badge-danger";
                                    } else if ($pembayaran->status == "SUDAH_DIBAYAR") {
                                        $badge = "badge-success";
                                    } else if ($pembayaran->status == "BATAL") {
                                        $badge = "badge-danger";
                                    } else if ($pembayaran->status == "MENUNGGU_KONFIRMASI") {
                                        $badge = "badge-warning";
                                    } ?>
                                    <div class="d-flex justify-content-center">
                                        <?php if ($pembayaran->status != "BELUM_DIBAYAR" && $pembayaran->status != "BATAL") : ?>
                                            <a href="<?= $pembayaran->bukti_url ?>" class="ml-2" target="_blank"> Lihat <i class="fas fa-eye"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <?php if ($pembayaran->status == "BELUM_DIBAYAR" || $pembayaran->status == "BATAL") : ?>
                                        <div class="row">
                                            <label class="col-sm-4">Kode Bayar</label>
                                            <div class="col-sm-8">
                                                <?= $pembayaran->kode_bayar ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-4">Metode Bayar</label>
                                            <div class="col-sm-8">
                                                <?= $pembayaran->metode_bayar; ?> (<?= $pembayaran->nomor_rekening; ?>)
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-4">Batas Bayar</label>
                                            <div class="col-sm-8">
                                                <?= $this->server_side->formatTanggal($pembayaran->batas_bayar) ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <div class="row">
                                        <label class="col-sm-4">Tanggal Kirim</label>
                                        <div class="col-sm-8">
                                            <?= $this->server_side->formatTanggal($pembayaran->tanggal_kirim) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-4">Status Pesanan</label>
                                        <div class="col-sm-8">
                                            <?php
                                            if ($pembayaran->status_transaksi == 'SEDANG_DIPROSES') {
                                                if ($pembayaran->status == 'SUDAH_DIBAYAR') {
                                                    $status = '
                                                    <div class="d-flex">
                                                        <span class="badge badge-warning">PERLU DISIAPKAN</span>
                                                        <div class="align-self-center ml-2 update-status" data-id_transaksi="' . $pembayaran->id_transaksi . '" role="button"><i class="fas fa-edit"></i></div>
                                                    </div>';
                                                } else {
                                                    $status = '
                                                    <div class="d-flex">
                                                        <span class="badge badge-danger">KONFIRMASI PEMBAYARAN</span>
                                                        <div class="align-self-center ml-2 verifikasi-bukti-bayar" data-id_pembayaran="' . $pembayaran->id . '" data-bukti="' . $pembayaran->bukti_url . '" role="button"><i class="fas fa-edit"></i></div>
                                                    </div>';
                                                }
                                            } else if ($pembayaran->status_transaksi == 'SUDAH_DIKIRIM') {
                                                $status = '
                                                <div class="d-flex">
                                                    <span class="badge badge-primary">SUDAH DIKIRIM | Nomor Resi: ' . $pembayaran->no_resi . '</span>
                                                    <div class="align-self-center ml-2 update-status-selesai" data-id_transaksi="' . $pembayaran->id_transaksi . '" role="button"><i class="fas fa-edit"></i></div>
                                                </div>';
                                            } else if ($pembayaran->status_transaksi == 'SELESAI') {
                                                $status = '<span class="badge badge-success">SELESAI</span>';
                                            } else if ($pembayaran->status_transaksi == 'BELUM_DIBAYAR') {
                                                $status = '<span class="badge badge-danger">BELUM DIBAYAR</span>';
                                            } else {
                                                $status = '<span class="badge badge-danger">BATAL</span>';
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
                                        foreach ($this->server_side->transaksi_detail($pembayaran->id_transaksi) as $td) : ?>
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
                                            <td colspan="3" style="vertical-align:middle" class="text-right"><b>Kurir (<?= strtoupper($pembayaran->kurir) ?>)</b></td>
                                            <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($pembayaran->ongkir, 0, ',', '.') ?></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="vertical-align:middle" class="text-right"><b>Total</b></td>
                                            <td style="vertical-align:middle" class="text-right"><b>Rp <?= number_format($pembayaran->total_tagihan, 0, ',', '.') ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 align-self-center">
                                        <div class="form-group">
                                            <p><b>Catatan Pesanan:</b> <?= ($pembayaran->catatan_beli != '') ? $pembayaran->catatan_beli : '-' ?></p>
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
</section>

<div class="modal fade" id="modal-bukti-bayar">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form-bukti-bayar">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Bukti Bayar</h5>
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
                                <input type="hidden" class="form-control" name="id_pembayaran"></input>
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

<div class="modal fade" id="modal-kirim">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form-bukti-kirim">
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
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="preview_image_(event)">
                                <input type="hidden" class="form-control" name="id_transaksi" value=""></input>
                            </div>
                            <div class="form-group" style="display:none" id="row-display_">
                                <label for="output_image">Preview</label>
                                <div class="mt-2">
                                    <img id="output_image_" class="img-thumbnail" width="200" />
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

<div class="modal fade" id="modal-verifikasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form-verifikasi-bukti-bayar">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Bukti Bayar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Foto</label><br>
                                <div id="bukti-bayar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="catatan">Catatan</label><br>
                                <div id="catatan"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="konfirmasi">Konfirmasi</label><br>
                                <select name="konfirmasi" id="konfirmasi" class="form-control">
                                    <option value=""></option>
                                    <option value="LUNAS">Bayar Sesuai</option>
                                    <option value="TIDAK_LUNAS">Bayar Tidak Sesuai</option>
                                </select>
                                <input type="hidden" name="id_pembayaran" value="id_pembayaran">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="catatan_konfirmasi">Catatan Konfirmasi</label><br>
                                <textarea name="catatan_konfirmasi" id="catatan_konfirmasi" class="form-control"></textarea>
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