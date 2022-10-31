<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>METODE BAYAR</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">SETTING</a></li>
                    <li class="breadcrumb-item active">METODE BAYAR</li>
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
                        <h3 class="card-title">DAFTAR METODE BAYAR</h3>
                        <div class="card-tools">
                            <button type="button" class="add btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Tambah Metode Bayar
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nomor Rekening</th>
                                    <th>Status</th>
                                    <th></th>
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
            <form id='form-metode-bayar'>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Metode Bayar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekening">Nomor Rekening</label>
                        <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" placeholder="Masukkan nomor rekening">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary save btn-name">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>