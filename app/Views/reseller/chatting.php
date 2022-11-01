<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CHATTING</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">DATA</a></li>
                    <li class="breadcrumb-item active">CHATTING</li>
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
                        <h3 class="card-title">DATA CHATTING</h3>
                        <div class="card-tools">
                            <button type="button" class="add btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Kirim Chat
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="table" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kode Transaksi</th>
                                    <th>Pengirim</th>
                                    <th>Penerima</th>
                                    <th>Topik</th>
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
            <form id='form-chat'>
                <div class="modal-header">
                    <h4 class="modal-title">Kirim Chat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="topik">Topik</label>
                        <input type="text" class="form-control" id="topik" name="topik" placeholder="Masukkan topik">
                    </div>
                    <div class="form-group">
                        <label for="transaksi">Nomor Transaksi Terakhir</label>
                        <select class="form-control" id="transaksi" name="transaksi">
                            <option value="">-Pilih nomor transaksi Terakhir-</option>
                            <?php foreach($nomor_transaksi as $t): ?>
                                <option value="<?=$t->kode_transaksi?>"><?= $t->kode_transaksi;?> | <?= $t->nama_umkm;?> | <?= str_replace("_", " ", $t->status); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary save btn-name">Kirim Chat</button>
                </div>
            </form>
        </div>
    </div>
</div>