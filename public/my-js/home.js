"use strict";

function add_cart(id, id_umkm, img, produk, qty, harga, weight) {
    $.ajax({
        url: base_url + '/add-cart',
        type: 'POST',
        data: {
            id: id,
            id_umkm: id_umkm,
            img: img,
            produk: produk,
            qty: qty,
            harga: harga,
            weight: weight,
        },
        dataType: 'JSON',
        success: function(res) {
            $('.total-cart').html(res.total);
            if (res.result == false) {
                Swal.fire({
                    title: 'Gagal',
                    html: "Anda tidak memiliki akses untuk bertransaksi!",
                    icon: 'error',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttons: false,
                });
            } else {
                Swal.fire({
                    title: 'Berhasil',
                    html: produk + " berhasil dimasukkan keranjang",
                    icon: 'success',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttons: false,
                });
            }
        }
    })
}

jQuery(document).ready(function() {

    $(document).on('click', '.add-cart', function() {
        var id = $(this).data('id');
        var umkm = $(this).data('umkm');
        var img = $(this).data('img');
        var produk = $(this).data('produk');
        var qty = $(this).data('qty');
        var harga = $(this).data('harga');
        var weight = $(this).data('weight');
        add_cart(id, umkm, img, produk, qty, harga, weight)
    })

})