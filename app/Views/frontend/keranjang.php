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
				<div id="isi_keranjang"></div>
			</div>

			<div class="col-lg-4">
				<div class="total-section">
					<form action="<?=base_url('/checkout')?>" method="POST">
						<h5>Ringkasan Belanja</h5>
						<table class="total-table table-sm">
							<tbody>
								<tr class="total-data">
									<td><b>Total Harga (<span class="jumlah_checkout">0</span> barang)</b></td>
									<td id="subtotal"><b><span class="jumlah_total">Rp 0</span></b></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" class="form-control" name="id_transaksi" value="" id="id_transaksi">
						<div class="cart-buttons text-center">
							<button type="submit" id="btn-checkout" disabled class="btn btn-primary btn-round" style="width:100%">
								<b>
									<h5 class="text-white">Beli (<span class="jumlah_checkout">0</span>)</h5>
								</b>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end cart -->