<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>UMKM</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">SETTING</a></li>
                    <li class="breadcrumb-item active">UMKM</li>
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
                        <h3 class="card-title">DATA UMKM</h3>
                        <div class="card-tools">
                            <button type="button" class="add btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Tambah UMKM
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama UMKM</th>
                                    <th>Foto</th>
                                    <th>Kategori</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id='form-user'>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah UMKM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_pengguna">Nama Pengguna</label>
                        <select id = "id_pengguna" name="id_pengguna" class="form-control">
                            <option value=''>- Pilih Pengguna -</option>
                            <?php foreach($pengguna as $val) {?>
                                <option value="<?= $val->id ?>"> <?= $val->nama ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama UMKM</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori UMKM</label>
                        <select id = "id_kategori" name="id_kategori" class="form-control">
                            <option value=''>- Pilih Kategori -</option>
                            <?php foreach($kategori_umkm as $val) {?>
                                <option value="<?= $val->id ?>"> <?= $val->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label><br>
                        <input type="file" name="foto" id="foto" accept="image/*" onchange="preview_image(event)">
                        <input type="hidden" name="foto_" id="foto_">
                    </div>
                    <div class="form-group" style="display:none" id="row-display">
                        <hr>
                        <label for="output_image">Preview</label>
                        <div class="mt-2">
                            <img id="output_image" class="img-thumbnail" width="200" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
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