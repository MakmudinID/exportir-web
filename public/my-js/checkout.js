"use strict";
let total, ongkir;
jQuery(document).ready(function() {
    // var id_umkm = $("input[name='id_umkm[]']")
    //           .map(function(){return $(this).val();}).get();
    // console.log(values);
    $(document).on('change', '#propinsi', function(){
        $.ajax({
            url: base_url+"/wilayah/city/"+$(this).val(),
            type: "GET",
            success:function(res){
                var kot = JSON.parse(res);
                var data = kot.rajaongkir.results;
                var isi = '<option value="">- Pilih Kota -</option>';
                for(var i = 0; i < data.length; i++){
                    isi += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
                }
                $('#kota').html(isi);
            }
        })
    })

    $(document).on('change', '#kurir', function(){
        if($('#propinsi').val() != '' && $('#kota').val() != ''){
            $.ajax({
                url: base_url+"/kurir",
                type:"POST",
                data:{
                    origin: $('#kota_asal').val(),
                    destination: $('#kota').val(),
                    weight: $('#weight').val(),
                    courier: $(this).val(),
                },
                success:function(res){
                    var data = JSON.parse(res);
                    var data_kurir = data.rajaongkir.results;
                    var datas = data_kurir[0].costs;
                    var isi = '<option value="">- Pilih Service -</option>';
                    for(var i = 0; i < datas.length; i++){
                        isi += "<option value='"+datas[i].service+"' data-cost='"+datas[i].cost[0].value+"'>"+datas[i].description+" | "+datas[i].cost[0].etd+" Hari </option>";
                    }
                    $('#service').html(isi);
                }
            })
        }
    })

    $(document).on('change', '#service', function(){
        ongkir = $(this).find(':selected').data('cost');
        $('#shipping').html(ongkir.toLocaleString())
        var subtotal = $('#subtotal').html();
        subtotal = Number(subtotal.replace(/[^0-9\.-]+/g,""));
        
        total = subtotal + ongkir;
        $('#total').html(total.toLocaleString());
    })

    $("#form-order").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama: {
                required: true
            },
            nohp: {
                required: true
            },
            email: {
                required: true
            },
            alamat: {
                required: true
            },
            propinsi: {
                required: true
            },
            kota: {
                required: true
            },
            kurir: {
                required: true
            },
            service: {
                required: true
            }
        },
        submitHandler: function(form) {
            var form_data = new FormData(document.getElementById("form-order"));
            form_data.append("jumlah", total);
            form_data.append("ongkir", ongkir);
            $.ajax({
                url: base_url + "/transaksi",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Order Barang",
                            icon: 'error',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            html: "Berhasil Order Barang",
                            icon: 'success',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('.total-cart').html(data.total);
                        $('#form-order').trigger("reset");
                        window.location.href = base_url + "/cart"

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    });

})