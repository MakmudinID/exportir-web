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
	                <div class="cart-table-wrap">
	                    <table class="cart-table" id="table">
	                        <thead class="cart-table-head">
	                            <tr class="table-head-row">
	                                <th class="product-image">Foto Produk</th>
	                                <th class="product-name">Produk</th>
	                                <th class="product-price">Harga</th>
	                                <th class="product-quantity">Qty</th>
	                                <th class="product-total">Total</th>
									<th class="product-remove"></th>
	                            </tr>
	                        </thead>
	                    </table>
	                </div>
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
							<?php 
								if(!empty($carts)){
							?>
	                        <a href="<?=base_url()?>/checkout" class="boxed-btn black">Check Out</a>
							<?php  } ?>
	                    </div>
	                </div>

	                
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end cart -->