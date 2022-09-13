function filter() {
    // console.log('asd');
    $.ajax({
        url: base_url + '/list_produk_',
        method: 'POST',
        data: {
            umkm: $('#umkm').val(),
            kategori: $('#kategori').val()
        },
        success: function(res) {
            $('#list-produk').html(res);
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $('#umkm').on('change', function() {
        filter();
    })

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
        add_cart(id, umkm, img, produk, qty, harga)
    })
})