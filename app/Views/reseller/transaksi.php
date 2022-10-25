<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pesanan Saya</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">DATA</a></li>
                    <li class="breadcrumb-item active">Pesanan Saya</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><b>Filter</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Rentang Tanggal:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="date_transaction">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="ALL">ALL</option>
                                        <option value="BELUM_DIBAYAR">Belum Dibayar</option>
                                        <option value="MENUNGGU_KONFIRMASI">Menunggu Konfirmasi</option>
                                        <option value="SUDAH_DIBAYAR">Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Aksi</label><br>
                                    <button type="button" class="btn btn-primary" id="btn-filter" style="width: 100%;">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><b>Daftar Pesanan Saya</b></h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Kode Bayar</th>
                                    <th>Total Tagihan</th>
                                    <th>Batas Bayar</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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