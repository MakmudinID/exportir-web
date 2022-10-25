<?php $validation = \Config\Services::validation(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Rempah | Sign Up</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/admin/css/adminlte.min.css">

</head>

<body class="hold-transition login-page">
    <div class="container">
        <!-- /.login-logo -->
        <?= session()->getFlashdata('message'); ?>
        <?php if ($validation->getErrors()) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $validation->listErrors() ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> ERROR!</h5>
                <?= $error ?>
            </div>
        <?php endif ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-header text-center">
                        <a href="<?= base_url('/') ?>" class="h1"><b>TOKO</b>REMPAH</a>
                    </div>
                    <div class="card-body">
                        <p class="login-box-msg">Buat Akun Sekarang!</p>
                        <form action="<?= base_url() ?>/daftar/proses" method="post" id="form-daftar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="no_hp">No. Handphone</label>
                                        <input type="text" name="no_hp" class="form-control" placeholder="Nomor Handphone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" placeholder="Alamat Tempat Tinggal">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="provinsi">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="">-Pilih Provinsi-</option>
                                            <?php foreach ($propinsi as $p) : ?>
                                                <option value="<?= $p->province_id ?>"><?= $p->province; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="kota">Kota/Kabupaten</label>
                                        <select name="kota" id="kota" class="form-control">
                                            <option value="">-Pilih Kota/Kabupaten-</option>
                                            <?php foreach ($kota as $p) : ?>
                                                <option value="<?= $p->city_id ?>"><?= $p->city_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="role">Role</label>
                                        <select name="role" id="role" class="form-control" placeholder="Daftar Sebagai">
                                            <option value="">-Daftar Sebagai-</option>
                                            <option value="RESELLER">RESELLER</option>
                                            <option value="UMKM">UMKM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="for-umkm">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="nama_umkm">Nama UMKM</label>
                                            <input type="text" name="nama_umkm" id="nama_umkm" class="form-control" placeholder="Nama UMKM">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="kategori_umkm">Kategori UMKM</label>
                                            <select name="kategori_umkm" id="kategori_umkm" class="form-control">
                                                <option value="">-Pilih Kategori-</option>
                                                <?php foreach ($kategori_umkm as $val) { ?>
                                                    <option value="<?= $val->id ?>"> <?= $val->nama ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <label for="deskripsi_umkm">Deskrispi UMKM</label>
                                            <textarea name="deskripsi_umkm" id="deskripsi_umkm" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Buat Akun</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <p class="mt-2 mb-1">
                            Sudah punya akun? <a href="<?= base_url('/login') ?>">Masuk Sekarang</a>
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>/assets/admin/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="<?= base_url() ?>/assets/admin/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        let base_url = '<?= base_url() ?>'
    </script>
    <script src="<?= base_url('/my-js/daftar.js') ?>"></script>
</body>

</html>