<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kontrak Perjanjian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">KERJASAMA</a></li>
                    <li class="breadcrumb-item active">Kontrak Perjanjian</li>
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
                                        <option value="SUDAH_UPLOAD">Menunggu Persetujuan</option>
                                        <option value="SUDAH_DISETUJUI">Kerjasama Disetujui</option>
                                        <option value="DITOLAK">Kerjasama Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Aksi</label><br>
                                    <button type="button" id="btn-filter" class="btn btn-primary" style="width: 100%;">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><b>Daftar Kerja Sama Saya</b></h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>No. Kerja Sama</th>
                                    <th>Reseller</th>
                                    <th>Kontrak</th>
                                    <th>Status</th>
                                    <th>Progress</th>
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
            <form method="post" id="form-dokumen">
                <div class="modal-header">
                    <h4 class="modal-title">Unggah Dokumen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a class="btn btn-success btn-sm" id="btn-unduh-kerjasama" style="width: 100%;" target="_blank">Unduh Dokumen Perjanjian Kerjasama</a>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Unggah Dokumen PDF Persetujuan</label><br>
                                <input type="file" class="form-control" name="dokumen" id="dokumen" accept="application/pdf">
                                <input type="hidden" name="no_kerjasama" id="no_kerjasama">
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