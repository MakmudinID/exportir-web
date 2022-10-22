"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    //Date range picker
    $('#date_transaction').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        }
    });

    var today = moment().startOf('month');
    var endDate = moment().endOf('month');
    $('#date_transaction').val(moment(today).format('YYYY-MM-DD HH:mm:ss') + " - " + moment(endDate).format('YYYY-MM-DD HH:mm:ss'));


    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/reseller/kerjasama_",
            type: "POST",
            data: function(data) {
                data.tgl_transaksi = $('#date_transaction').val();
                data.status = $('#status').val();
            }
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        pageLength: 30,
        order: [],
        columns: [{
                "data": 'tanggal_pengajuan',
            },
            { "data": "no_kerjasama" },
            { "data": "umkm" },
            { "data": "kontrak" },
            { "data": "status" },
            { "data": "progress" },
            { "data": "detail" },
        ],
        columnDefs: [{
            targets: [-1, -2],
            orderable: false,
            searchable: false,
            className: "text-center"
        }],
    });

    $('#btn-filter').click(function() { //button filter event click
        table.ajax.reload(); //just reload table
    });
});