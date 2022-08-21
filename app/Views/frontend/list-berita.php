<div class="breadcrumb-section breadcrumb-bg">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 offset-lg-2 text-center">
	                <div class="breadcrumb-text">
	                    <p>Informasi</p>
	                    <h1>Berita</h1>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <!-- products -->
	<div class="product-section mt-40 mb-40">
		<div class="container">
			<div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-filter">
                                    <div class="form row">
                                        <div class="form-group col-md-8 align-self-center">
                                            <input type="text" name="cari" class="form-control form-control-lg" placeholder="Cari Berita" id="cari">
                                        </div>
                                        <div class="form-group col-md-4 align-self-center">
                                            <select id="kategori" class="form-control form-control-lg">
                                                <option value="">- Pilih Kategori -</option>
                                                <?php foreach($kategori_berita as $kp){ ?>
                                                    <option value="<?= $kp->id?>"><?= $kp->nama?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="list-berita"></div>			
		</div>
	</div>