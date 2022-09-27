<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Transaksi</p>
                    <h1>Checkout Produk</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-5 mb-5">
    <div class="container">
        <form id="form-order">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Alamat Pengiriman
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="nama"><b>Nama Penerima</b></label>
                                                <input type="hidden" name="weight" id="weight" value="<?= $total_weight ?>">
                                                <input type="hidden" name="id_umkm" id="id_umkm" value="<?= $id_umkm ?>">
                                                <input type="text" name="nama" value="<?=$reseller->nama?>" id="nama" placeholder="Nama Penerima" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="nama"><b>Email Penerima</b></label>
                                                <input type="email" name="email" value="<?=$reseller->email?>" id="email" placeholder="Email Penerima" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="nama"><b>No. Handphone</b></label>
                                                <input type="text" name="nohp" id="nohp" value="<?=$reseller->no_hp?>" placeholder="No.Handphone" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="alamat"><b>Alamat Penerima</b></label>
                                                <input type="text" name="alamat" id="alamat" value="<?=$reseller->alamat?>" class="form-control" placeholder="Alamat Penerima">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="provinsi"><b>Provinsi</b></label>
                                                <input type="hidden" name="kota_asal" id="kota_asal" value="<?= $kota_asal ?>">
                                                <select name="propinsi" id="propinsi" class="form-control">
                                                    <option value="">- Pilih Propinsi -</option>
                                                    <?php foreach ($propinsi as $val) { ?>
                                                        <option value="<?= $val->province_id ?>"><?= $val->province ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="kota"><b>Kota</b></label>
                                                <select name="kota" id="kota" class="form-control">
                                                    <option value="">- Pilih Kota -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="kurir"><b>Kurir</b></label>
                                                <select name="kurir" id="kurir" class="form-control">
                                                    <option value="">- Pilih Kurir -</option>
                                                    <option value="jne">JNE</option>
                                                    <option value="pos">POS Indonesia</option>
                                                    <option value="tiki">TIKI</option>
                                                    <option value="pcp">PCP</option>
                                                    <option value="esl">ESL</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="service"><b>Service</b></label>
                                                <select name="service" id="service" class="form-control">
                                                    <option value="">- Pilih Service -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" placeholder="Catatan pembelian"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="h3">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Daftar Pesanan
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="cart-table-wrap">
                                            <table class="cart-table" id="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Photo</th>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sum = 0;
                                                    $no = 1;
                                                    foreach ($cart as $val) {
                                                        $sum += $val['subtotal'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td class="product-image"><img src="<?= $val['img'] ?>"></td>
                                                            <td><?= $val['name'] ?></td>
                                                            <td class="product-price text-right"><?= $val['price'] ?></td>
                                                            <td class="product-quantity"><?= $val['qty'] ?></td>
                                                            <td class="product-total text-right"><?= number_format($val['subtotal'], 0) ?></td>
                                                        </tr>
                                                    <?php $no++;
                                                    } ?>
                                                    <tr>
                                                    <tr>
                                                        <td colspan="5"><b>Total</b></td>
                                                        <td class="product-total text-right"><b><?= number_format($sum, 0) ?></b></td>
                                                    </tr>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td>Pembelian</td>
                                        <td id="subtotal" class="text-right"><b><?= number_format($sum, 0) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Kurir</td>
                                        <td id="shipping" class="text-right"><b>0</b></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pembayaran</td>
                                        <td id="total" class="text-right"><b><?= number_format($sum, 0) ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="order" style="width:100%" class="btn btn-primary btn-rounded">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end check out section -->