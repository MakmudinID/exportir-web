"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    //Date range picker
    $('#date_transaction').daterangepicker()

    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/reseller/kerjasama_",
            type: "POST",
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
            { "data": "dokumen_kerjasama" },
            { "data": "status" },
            { "data": "detail" },
        ],
        columnDefs: [{
            targets: [0, -1],
            orderable: false,
            searchable: false,
            className: "text-center"
        }],
    });
});