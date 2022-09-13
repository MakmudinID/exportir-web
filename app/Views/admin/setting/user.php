<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>USER</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">SETTING</a></li>
                    <li class="breadcrumb-item active">USER</li>
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
                        <h3 class="card-title">DATA USER</h3>
                        <div class="card-tools">
                            <button type="button" class="add btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
            <form id='form-user'>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
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
                        <label for="hp">No. Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                    </div>
                    <div class="form-group">
                        <label for="password">Retype Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Masukkan kembali password">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="SUPERADMIN">Super Admin</option>
                            <option value="UMKM">UMKM</option>
                            <option value="RESELLER">Reseller</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label><br>
                        <input type="file" name="photo" id="photo" accept="image/*" onchange="preview_image(event)">
                        <input type="hidden" name="photo_" id="photo_">
                    </div>
                    <div class="form-group" style="display:none" id="row-display">
                        <hr>
                        <label for="output_image">Preview</label>
                        <div class="mt-2">
                            <img id="output_image" class="img-thumbnail" width="200" />
                        </div>
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