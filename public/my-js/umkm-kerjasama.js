"use strict";

let table // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/umkm/kerjasama_",
            type: "POST",
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        pageLength: 30,
        order: [],
        columns: [{
                "data": 'no',
                "sortable": false,
                "searchable": false,
            },
            { "data": "nama" },
            { "data": "umkm" },
            { "data": "file" },
            { "data": "status" },
        ],
        columnDefs: [{
            targets: [0, 3],
            orderable: false,
            searchable: false,
            className: 'text-center'
        }],
    });
});