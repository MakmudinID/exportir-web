<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Detail</p>
					<h1>Berita</h1>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mt-5 mb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="single-article-section">
					<div class="single-article-text">
						<h2><?= $berita->judul ?></h2>
						<p class="blog-meta">
							<span class="author"><i class="fas fa-user"></i> <?= $berita->penulis ?></span>
							<span class="date"><i class="fas fa-calendar"></i><?= $berita->create_date ?></span>
						</p>
						<img src="<?= $berita->foto ?>" alt="" class="img-fluid">
						<p><?= html_entity_decode($berita->isi) ?></p>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="sidebar-section">
					<div class="recent-posts">
						<h4>Berita Lainnya</h4>
						<ul>
							<?php foreach ($berita_random as $b) { ?>
								<li><a href="<?= base_url('/berita/' . $b->id) ?>"><?= $b->judul ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>