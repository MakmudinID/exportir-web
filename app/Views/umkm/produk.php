<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>PRODUK</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">DATA</a></li>
                    <li class="breadcrumb-item active">PRODUK</li>
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
                        <h3 class="card-title">DATA PRODUK</h3>
                        <div class="card-tools">
                            <button type="button" class="add btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Tambah Barang
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
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
            <form id='form-produk'>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kategori">Kategori</label>
                                <select class="form-control" name="id_kategori" id="id_kategori">
                                    <option value="">- Pilih Kategori -</option>
                                    <?php foreach($kategori as $val){ ?>
                                        <option value="<?= $val->id ?>"><?= $val->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control summernote" id="deskripsi" name="deskripsi"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" >
                            </div>    
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Stok</label>
                                <input type="number" class="form-control" id="qty" name="qty" >
                            </div>    
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty_min">Min. Pemesanan (Non Kerjasama)</label>
                                <input type="number" class="form-control" id="qty_min" name="qty_min" >
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="satuan">Berat Produk (Gram)</label>
                                <input type="number" name="weight" id="weight" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="ACTIVE"> ACTIVE</option>
                                    <option value="INACTIVE"> INACTIVE</option>
                                </select>
                            </div>     
                        </div>
                    </div>      
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label><br>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="preview_image(event)">
                                <input type="hidden" name="foto_" id="foto_">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="display:none" id="row-display">
                                <label for="output_image">Preview</label>
                                <div class="mt-2">
                                    <img id="output_image" class="img-thumbnail" width="200" />
                                </div>
                            </div>
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
