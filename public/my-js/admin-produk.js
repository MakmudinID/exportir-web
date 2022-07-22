"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/admin/produk_",
            type: "POST",
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        pageLength: 30,
        order: [],
        columns: [
            { "data": "no" },
            { "data": "umkm" },
            { "data": "foto" },
            { "data": "nama" },
            { "data": "kategori" },
            { "data": "qty" },
        ],
        columnDefs: [{
            targets: [0,2],
            orderable: false,
            searchable: false,
            className: 'text-center'
        }],
    });
});
