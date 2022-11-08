<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= $get_profil->foto_umkm ?>" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?= $get_profil->nama ?></h3>
                        <p class="text-muted text-center"><?= $get_profil->nama_umkm ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Data Owner</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="edit-profil">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $get_profil->email ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?= $get_profil->nama ?>">
                                    <input type="hidden" class="form-control" name="id" id="id"  value="<?= $get_profil->id ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-2 col-form-label">Nomor Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor Hp" value="<?= $get_profil->no_hp ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="foto" id="foto"  accept="image/*" onchange="preview_image_profil(event)">
                                    <input type="hidden" id="foto_" name="foto_" value="<?= $get_profil->foto ?>">
                                    <img id="output_image_foto" src="<?= $get_profil->foto ?>" class="img-thumbnail mt-2" width="200" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update Profil</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        <h4>Data UMKM</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" id="edit-umkm">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama UMKM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_umkm" id="nama_umkm" placeholder="Nama" value="<?= $get_profil->nama_umkm ?>">
                                    <input type="hidden" class="form-control" name="id_umkm" id="id_umkm"  value="<?= $get_profil->id_umkm ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nohp" class="col-sm-2 col-form-label">Deskripsi UMKM</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="deskripsi_umkm" id="deskripsi_umkm" placeholder="Deskripsi" row="5"><?= $get_profil->deskripsi ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-sm-2 col-form-label">Foto UMKM</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="foto_umkm" id="foto_umkm"  accept="image/*" onchange="preview_image(event)">
                                    <input type="hidden" id="foto_umkm_" name="foto_umkm_" value="<?= $get_profil->foto_umkm ?>">
                                    <img id="output_image" src="<?= $get_profil->foto_umkm ?>" class="img-thumbnail mt-2" width="200" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="foto" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $get_profil->alamat_umkm ?>">
                                    <input type="hidden" name="hidden_kota" id="hidden_kota" class="form-control" value="<?= $get_profil->city_id ?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="foto" class="col-sm-2 col-form-label">Propinsi</label>
                                <div class="col-sm-10">
                                    <select name="propinsi" id="propinsi" class="form-control">
                                        <option value="">- Pilih Propinsi -</option>
                                        <?php foreach($propinsi as $val){ ?>
                                            <option value="<?=$val->province_id?>" <?= ($get_profil->province_id == $val->province_id) ? "selected" : ""; ?>><?=$val->province?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="foto" class="col-sm-2 col-form-label">Kota</label>
                                <div class="col-sm-10">
                                    <select name="kota" id="kota" class="form-control">
                                        <option value="">- Pilih Kota -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update UMKM</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
