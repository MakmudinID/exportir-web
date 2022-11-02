<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Daftar Produk</p>
                    <h1><?= $kategori->nama; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-section mt-40 mb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-filters">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-filter">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 align-self-center">
                                        <input type="text" name="keyword" class="form-control" placeholder="Cari Produk" id="keyword">
                                        <input type="hidden" name="kategori" id="kategori" value="<?=$kategori->id?>">
                                    </div>
                                    <div class="col-md-3 align-self-center">
                                        <button type="button" class="btn btn-primary filter" style="width: 100%;">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <div class="p-2 align-self-center"><i class="fas fa-sort"></i> <b>Urutkan</b></div>
            <div class="p-2">
                <select name="sort_by" id="sort_by" class="form-control">
                    <option value="TERBARU">Terbaru</option>
                    <option value="TERLARIS">Terlaris</option>
                </select>
            </div>
        </div>
        <div class="row" id="list-produk"></div>
    </div>
</div>