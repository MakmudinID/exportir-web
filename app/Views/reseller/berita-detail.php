<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Berita</a></li>
                    <li class="breadcrumb-item active"><?= $berita->kategori;?></li>
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
                        <h3 class="card-title"><?= $berita->judul;?></h3>
                    </div>
                    <div class="card-body table-responsive">
                        <p class="text-center"><img src="<?= $berita->foto;?>" alt="" class="img-fluid"></p>
                        <?= html_entity_decode($berita->isi);?>
                    </div>
                    <div class="card-footer">
                        <a href="<?=base_url('/reseller/berita')?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>