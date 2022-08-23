"use strict";

function add_cart(id,id_umkm,img,produk,qty,harga){
    $.ajax({
        url: base_url+'/add-cart',
        type: 'POST',
        data: {
            id: id,
            id_umkm : id_umkm,
            img: img,
            produk: produk,
            qty: qty,
            harga: harga,
        },
        dataType: 'JSON',
        success:function(res){
            $('.total-cart').html(res.total);
            if(res.result != true){
                Swal.fire({
                    title: 'Gagal',
                    html: "Maaf Anda Belum Login !",
                    icon: 'error',
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

    $(document).on('click', '.add-cart', function(){
        var id = $(this).data('id');
        var umkm = $(this).data('umkm');
        var img = $(this).data('img');
        var produk = $(this).data('produk');
        var qty = $(this).data('qty');
        var harga = $(this).data('harga');
        add_cart(id,umkm,img,produk,qty,harga)
    })

})