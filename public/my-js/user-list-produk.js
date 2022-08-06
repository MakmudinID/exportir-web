function filter(){
    // console.log('asd');
    $.ajax({
        url: base_url+'/list_produk_',
        method: 'POST',
        data: {
            umkm : $('#umkm').val(),
            kategori: $('#kategori').val()
        },
        success: function(res){
            $('#list-produk').html(res);
        }
    })
}

jQuery(document).ready(function() {
    filter();

    $('#umkm').on('change', function(){
        filter();
    })

    $('#kategori').on('change', function(){
        filter();
    })
})