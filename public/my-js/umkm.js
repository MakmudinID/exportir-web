let keyword;
let kategori;
let umkm;

function filter() {
    $.ajax({
        url: base_url + '/list_produk_by_umkm',
        method: 'POST',
        data: {
            umkm: $('#umkm').val(),
            kategori: $('#kategori').val(),
            keyword: $('#keyword').val(),
        },
        success: function(res) {
            $('#list-produk').html(res);
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $(document).on('click', '.filter', function() {
        filter();
    });
})