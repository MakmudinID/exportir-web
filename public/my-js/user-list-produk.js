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

jQuery(document).ready(function() {
    filter();

    $('#kategori').on('change', function() {
        filter();
    })
})