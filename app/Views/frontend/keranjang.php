<?php

use App\Models\ServerSideModel;

$this->server_side = new ServerSideModel();
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>DETAIL</p>
					<h1>Keranjang Belanja</h1>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end breadcrumb section -->

<!-- cart -->
<div class="cart-section mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12">
				<?php foreach ($transaksi as $t) : ?>
					<div class="card mb-3">
						<div class="card-header">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="<?= $t->id ?>">
								<label class="form-check-label" for="<?= $t->id ?>">
									<b><?= $t->nama_toko; ?></b>
								</label>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-sm">
								<tbody>
									<?php foreach ($this->server_side->transaksi_detail($t->id) as $td) : ?>
										<tr>
											<td class="product-image" width="60%">
												<div class="d-flex">
													<div class="p-2 align-self-center">
														<img src="<?= $td->foto; ?>" alt="">
													</div>
													<div class="p-2 align-self-center">
														<?= $td->nama; ?>
													</div>
												</div>
											</td>
											<td style="vertical-align:middle" class="text-center" width="6%"><input type="number" class="form-control" value="<?= $td->qty; ?>"></td>
											<td style="vertical-align:middle" class="text-right">Rp <?= number_format($td->subtotal, 0, ',', '.') ?></td>
											<td style="vertical-align:middle" width="5%"><a href="javascript:void(0)"><i class="fas fa-trash-alt text-danger remove" data-id="<?= $td->id ?>"></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="col-lg-4">
				<div class="total-section">
					<table class="total-table table-sm">
						<thead class="total-table-head">
							<tr class="table-total-row">
								<th>Total</th>
								<th>Harga</th>
							</tr>
						</thead>
						<tbody>
							<tr class="total-data">
								<td><strong>Subtotal: </strong></td>
								<td id="subtotal"></td>
							</tr>
						</tbody>
					</table>
					<div class="cart-buttons">
						<?php if (!empty($transaksi)) { ?>
							<a href="<?= base_url() ?>/checkout" class="boxed-btn black" style="width:100%">Check Out</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end cart -->