<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Pengajuan Kerjasama</p>
                    <h1><?= $umkm->nama; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<div class="single-product mt-40 mb-40">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center">
                    <h3>PIHAK <span class="orange-text">PERTAMA</span></h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= session()->get('nama') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" id="email" value="<?= session()->get('email') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nik" class="col-sm-3 col-form-label">No. KTP (NIK)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nik" name="nik" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-9">
                <div class="section-title text-center">
                    <h3>PIHAK <span class="orange-text">KEDUA</span></h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id_umkm" id="id_umkm" value="<?=$umkm->id?>">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label align-self-center">Nama Toko</label>
                            <div class="col-sm-9 align-self-center">
                                : <?= $umkm->nama; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-3 col-form-label align-self-center">Alamat</label>
                            <div class="col-sm-9 align-self-center">
                                : <?= $umkm->alamat; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label align-self-center">No. Telepon</label>
                            <div class="col-sm-9 align-self-center">
                                : <?= $umkm->no_telepon; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kontrak" class="col-sm-3 col-form-label align-self-center">Kontrak Kerjasama</label>
                            <div class="col-sm-9 align-self-center">
                                <select name="kontrak" id="kontrak" class="form-control">
                                    <option value=""></option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pilih_produk" class="col-sm-3 col-form-label">Produk <?= $umkm->nama; ?></label>
                            <div class="col-sm-9 align-self-center">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#produk-umkm"><i class="fas fa-search"></i> Cari Produk</button>
                                <!-- Modal -->
                                <div class="modal fade" id="produk-umkm" tabindex="-1" role="dialog" aria-labelledby="produk-umkm" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Produk <?= $umkm->nama; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-sm table-bordered" id="table-produk" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Produk</th>
                                                            <th>Jumlah Pesan</th>
                                                            <th>Pilih</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <table class="table table-sm table-bordered" id="table-terpilih" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">Tidak ada produk yang dipilih</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <a href="<?= base_url('/umkm/' . $umkm->slug) ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>