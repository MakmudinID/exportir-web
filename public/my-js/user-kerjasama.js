"use strict";
let total, ongkir;

jQuery(document).ready(function() {
    $(document).on('change', '.pilih-kurir', function() {
        if ($(this).val() != '') {
            let id = $(this).data("id");
            $.ajax({
                url: base_url + "/kurir",
                type: "POST",
                data: {
                    'origin': $(this).data("kota_asal"),
                    'destination': $(this).data("kota_penerima"),
                    'weight': $(this).data("total_berat"),
                    'courier': $(this).val(),
                    'id_transaksi': id
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    if (data.rajaongkir.status.code == 400) {
                        Swal.fire({
                            title: '404',
                            html: data.rajaongkir.status.description,
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: true,
                        });
                    } else {
                        var data_kurir = data.rajaongkir.results;
                        console.log(JSON.parse(res));
                        var datas = data_kurir[0].costs;
                        var isi = '<option value="">- Pilih Layanan -</option>';

                        for (var i = 0; i < datas.length; i++) {
                            ongkir = datas[i].cost[0].value;
                            let rupiah = ongkir.toLocaleString('id', {
                                style: 'currency',
                                currency: 'IDR'
                            });

                            isi += "<option value='" + datas[i].service + "' data-cost='" + datas[i].cost[0].value + "'>" + datas[i].description + " (estimasi " + datas[i].cost[0].etd + " hari) - " + rupiah.replace(",00", "") + " </option>";
                        }
                        $('#layanan_' + id).html(isi);
                    }
                }
            })
        };
    });

    $(document).on('change', '.pilih-layanan', function() {
        let id_transaksi = $(this).data('id');
        let service = $(this).find(':selected').text();
        let ongkir = $(this).find(':selected').data('cost');

        $.ajax({
            url: base_url + "/set_kurir",
            cache: false,
            type: 'POST',
            data: {
                'id_transaksi': id_transaksi,
                'ongkir': ongkir,
                'service': service,
            },
            success: function(msg) {
                if (msg == true) {
                    let sum_ongkir = 0;
                    let count = 0;
                    let count_selecter = 0;

                    $('.selecter').each(function(i) {
                        let ongkir = parseInt($(this).find(':selected').data('cost'));
                        if (isNaN(ongkir)) {
                            ongkir = 0;
                            count += 0;
                        } else {
                            count += 1;
                        }
                        count_selecter += 1;
                        sum_ongkir += ongkir;
                    });

                    if (count == count_selecter) {
                        $('#btn-order').prop("disabled", false);
                    } else {
                        $('#btn-order').prop("disabled", true);
                    }

                    let rupiah = sum_ongkir.toLocaleString('id', {
                        style: 'currency',
                        currency: 'IDR'
                    });

                    $('#shipping').html('<b>' + rupiah.replace(",00", "") + '</b>');

                    let subtotal = $('#total').html();
                    subtotal = Number(subtotal.replace(/[^0-9\-]+/g, ""));

                    let total = subtotal + sum_ongkir;
                    let rupiah_total = total.toLocaleString('id', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    $('#total_tagihan').val(total);
                    $('#total').html('<b>' + rupiah_total.replace(",00", "") + '</b>');
                }
            }
        });
    });

    $("#form-kerjasama").validate({
        errorClass: "is-invalid",
        rules: {
            nama: {
                required: true
            },
            alamat: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            nik: {
                required: true,
                number: true
            },
            kontrak: {
                required: true
            },
            'metode[]': {
                required: true
            },
            'layanan[]': {
                required: true
            }
        }
    });
})