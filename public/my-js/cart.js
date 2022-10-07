"use strict";

let table; // use a global for the submit and return data rendering in the examples
function load_cart() {
    $.ajax({
        url: base_url + '/cart_',
        type: 'POST',
        success: function(res) {
            $('#isi_keranjang').html(res);
        }
    })
}

function qty(id) {
    var val = $("#qty_" + id).val();
    $.ajax({
        url: base_url + '/update_qty',
        cache: false,
        type: 'POST',
        data: {
            'id': id,
            'jumlah': val
        },
        success: function(msg) {
            load_cart();
        }
    });
}

function catatan(id) {
    var val = $("#catatan_" + id).val();
    $.ajax({
        url: base_url + '/update_catatan',
        cache: false,
        type: 'POST',
        data: {
            'id': id,
            'catatan': val
        },
        success: function(msg) {
            load_cart();
        }
    });
}

function calculateAll() {
    var count = 0;
    var jumlah_barang = 0;
    var id_transaksi = '';
    $("input[type='checkbox']").each(function(index, checkbox) {
        if (checkbox.checked) {
            count += parseInt(checkbox.value);
            jumlah_barang += parseInt($(this).data('jumlah_barang'));
            id_transaksi += $(this).data('id_transaksi') + ',';
        }
    });

    if (count > 0) {
        $('#btn-checkout').prop("disabled", false);
    } else {
        $('#btn-checkout').prop("disabled", true);
    }

    var rupiah = (count).toLocaleString('id', {
        style: 'currency',
        currency: 'IDR'
    });
    var rp = rupiah.replace(",00", "");

    $('.jumlah_checkout').text(jumlah_barang);
    $('.jumlah_total').text(rp);
    $('#id_transaksi').val(id_transaksi);
}

jQuery(document).ready(function() {
    load_cart();

    $(document).on('click', '.remove', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var id_transaksi = $(this).data('id_transaksi');
        $.ajax({
            url: base_url + '/remove_cart',
            type: 'POST',
            data: {
                id: id,
                id_transaksi: id_transaksi
            },
            success: function(res) {
                var data = JSON.parse(res);
                $('.total-cart').html(data.total);
                Swal.fire({
                    title: 'Berhasil',
                    html: "1 barang telah dihapus",
                    icon: 'success',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttons: false,
                });
                load_cart();
            }
        })
    })
})