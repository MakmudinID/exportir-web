function filter() {
    // console.log('asd');
    $.ajax({
        url: base_url + '/list_produk_',
        method: 'POST',
        data: {
            kategori: $('#kategori').val()
        },
        success: function(res) {
            $('#list-produk').html(res);
        }
    })
}

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
            if (res.result != true) {
                Swal.fire({
                    title: 'Gagal',
                    html: "Maaf Anda Belum Login !",
                    icon: 'error',
                    timer: 3000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttons: false,
                });
            } else {
                Swal.fire({
                    title: 'Berhasil',
                    html: "Produk Berhasil Masuk Keranjang",
                    icon: 'success',
                    timer: 3000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    buttons: false,
                });
            }
            // console.log(res)
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $('#kategori').on('change', function() {
        filter();
    })

    $(document).on('click', '.add-cart', function(e) {
        e.preventDefault();
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