let kategori;
let keyword;

function filter() {
    $.ajax({
        url: base_url + '/list_berita_',
        method: 'POST',
        data: {
            keyword: $('#keyword').val(),
            kategori: $('#kategori').val()
        },
        success: function(res) {
            $('#list-berita').html(res);
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $(document).on('click', '.filter', function() {
        filter();
    });
})