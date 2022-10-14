    <div class="breadcrumb-section breadcrumb-bg">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 offset-lg-2 text-center">
	                <div class="breadcrumb-text">
	                    <h1>Daftar Produk</h1>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <!-- products -->
	<div class="product-section mt-40 mb-5">
		<div class="container">
			<div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-filter">
                                    <div class="row justify-content-center">
                                        <div class="form-group col-md-4">
                                            <label for="cari">Kata Kunci</label>
                                            <input type="text" name="cari" class="form-control" placeholder="Cari Produk" id="cari">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="kategori">Kategori Produk</label>
                                            <select id="kategori" class="form-control">
                                                <option value="">- Pilih Kategori -</option>
                                                <?php foreach($kategori_produk as $kp){ ?>
                                                    <option value="<?= $kp->id?>"><?= $kp->nama?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="jenis">Aksi</label><br>
                                            <button type="button" class="btn btn-primary" style="width: 100%;">Terapkan</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="list-produk"></div>			
		</div>
	</div>