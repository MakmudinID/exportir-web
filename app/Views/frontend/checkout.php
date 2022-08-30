<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out Produk</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
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
                                Alamat Penerima
                            </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                            <div class="billing-address-form">
                                
                                    <div class="row form-group">
                                        <input type="text" name="nama" id="nama" placeholder="Nama Penerima" class="form-control" required>
                                    </div>
                                    <div class="row form-group">
                                        <input type="email" name="email" id="email" placeholder="Email Penerima" class="form-control" required>
                                    </div>
                                    <div class="row form-group">
                                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat Penerima">
                                    </div>
                                    <div class="row form-group">
                                        <input type="text" name="nohp" id="nohp" class="form-control" placeholder="No.HP Penerima">
                                    </div>
                                    <div class="row form-group">
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                                    </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="card single-accordion">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Pengiriman
                            </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                            <div class="shipping-address-form">
                                
                                    <div class="col-md-12">

                                        <div class="row form-group">
                                            <input type="hidden" name="kota_asal" id="kota_asal" value="<?= $kota_asal?>">
                                            <select name="propinsi" id="propinsi" class="form-control">
                                                <option value="">- Pilih Propinsi -</option>
                                                <?php foreach($propinsi as $val){ ?>
                                                    <option value="<?=$val->province_id?>"><?=$val->province?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="row form-group">
                                            <select name="kota" id="kota" class="form-control">
                                                <option value="">- Pilih Kota -</option>
                                            </select>
                                        </div>
                                        <div class="row form-group">
                                            <select name="kurir" id="kurir" class="form-control">
                                                <option value="">- Pilih Kurir -</option>
                                                <option value="jne">JNE</option>
                                                <option value="pos">POS Indonesia</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pcp">PCP</option>
                                                <option value="esl">ESL</option>
                                            </select>
                                        </div>
                                        <div class="row form-group">
                                            <select name="service" id="service" class="form-control">
                                                <option value="">- Pilih Service -</option>
                                            </select>
                                        </div>
                                    </div>
                                
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Detail Pemesanan </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">

                            <?php 
                                $sum = 0;
                                foreach($cart as $val){ 
                                    $sum += $val['subtotal'];
                            ?>
                                <tr>
                                    <td><?=$val['name']?></td>
                                    <td><?=number_format($val['subtotal'],0)?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td id="subtotal"><?=number_format($sum,0)?></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td id="shipping">0</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td id="total"><?=number_format($sum,0)?></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" id="order" style="width:75%" class="btn btn-primary btn-rounded mt-4">Place Order</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- end check out section -->
