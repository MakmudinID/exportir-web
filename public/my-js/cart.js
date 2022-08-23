"use strict";

let table; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/cart_",
            type: "post",
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        paginate:false,
        filter:false,
        info:false,
        ordering:false,
        columns: [{
                "data": 'close',
                "sortable": false,
            },
            { "data": "photo" },
            { "data": "produk" },
            { "data": "harga", render: $.fn.dataTable.render.number('.', ',', '')},
            { "data": "qty" },
            { "data": "total", render: $.fn.dataTable.render.number('.', ',', '')},
        ],
        columnDefs: [{
            targets: [0],
            className: "product-remove"
        },{
            targets: [1],
            className: "product-image"
        },{
            targets: [2],
            className: "product-name"
        },{
            targets: [3],
            className: "product-price"
        },{
            targets: [4],
            className: "product-quantity"
        },{
            targets: [5],
            className: "product-total"
        }],
        footerCallback: function(row, data, start, end, display) {
            let api = this.api();
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            var total = api
                    .column(5)  
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            // console.log(total);
            let rp = total.toLocaleString('id');
            let rp1 = rp.replace(",00", "");
            $('#subtotal').html(rp1);
        },
    });

    $(document).on('click', '.remove', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: base_url + '/remove_cart',
            type:'POST',
            data:{
                id: id
            },
            success:function(res){
                // console.log(res);
                var data = JSON.parse(res);
                table.ajax.reload();
                $('.total-cart').html(data.total);
            }
        })
    })

    $(document).on('change', '#qty', function(){
        var rowId = $(this).data('rowid');
        var qty = $(this).val();
        console.log(rowId, qty)
        $.ajax({
            url: base_url + '/update_qty',
            type:'POST',
            data: {
                rowId: rowId,
                qty: qty
            },
            success: function(res){
                // console.log(res)
                table.ajax.reload();
            }
        })
    })

})