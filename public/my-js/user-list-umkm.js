let keyword;
let kategori;
let umkm;

function filter() {
    $.ajax({
        url: base_url + '/list_umkm_',
        method: 'POST',
        data: {
            kategori: $('#kategori').val(),
            keyword: $('#keyword').val(),
        },
        success: function(res) {
            $('#list-umkm').html(res);
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $(document).on('click', '.filter', function() {
        filter();
    });
})