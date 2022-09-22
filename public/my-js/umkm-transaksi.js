"use strict";

let table; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        dom: "<'row mb-3'<'col-md-4 mb-3 mb-md-0'l><'col-md-8 text-right'<'d-flex justify-content-end'fB>>>rt<'row align-items-center'<'mr-auto col-md-6 mb-3 mb-md-0 mt-n2 'i><'mb-0 col-md-6'p>>",
        ajax: {
            url: base_url + "/umkm/transaksi_",
            type: "POST",
            data: function(data) {
                
            }
        },

        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: false,
        serverSide: true,
        processing: true,
        pageLength: 30,
        columns: [{
                className: 'details-control',
                searchable: false,
                orderable: false,
                data: null,
                defaultContent: ''
            },
            { data: 'tanggal_pemesanan' },
            { data: 'nama_pemesan' },
            { data: 'status' },
            { data: 'tagihan', render: $.fn.dataTable.render.number('.', ',', '') },
            { data: 'kode_transaksi' },
            { data: 'act' }
        ],
        columnDefs: [{
            targets: [0,4,5,6],
            orderable: false,
            searchable: false,
        }],
        
        order: [],
        buttons: [
            {
            extend: 'collection',
            text: 'Export',
            buttons: [{
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i> Copy',
                    titleAttr: 'Copy',
                    exportOptions: {
                        columns: ':not(:eq(9))',
                    }
                },
                {
                    extend: 'excel',
                    title: 'Transaksi',
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: ':not(:eq(9))',
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    titleAttr: 'CSV',
                    exportOptions: {
                        columns: ':not(:eq(9))',
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Transaksi',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    orientation: 'landscape',
                    // pageSize: 'LEGAL',
                    titleAttr: 'PDF',
                    exportOptions: {
                        columns: ':not(:eq(9))',
                    }
                },
                {
                    extend: 'print',
                    title: 'Transaksi',
                    text: '<i class="fa fa-print"></i> Print',
                    titleAttr: 'Print',
                    exportOptions: {
                        columns: ':not(:eq(9))',
                    }
                }
            ]
        }]

    });

    function format(d) { 
        return '<table class="table text-nowrap" style="width:100%;">' +
            '<tr>' +
            '<td>' +
            '<h5>Detail Pengiriman</h5>' +
            '<b>Nama:</b> ' + d.nama_penerima + '<br>' +
            '<b>E-mail:</b> ' + d.email_penerima + '<br>' +
            '<b>Nomor Hp:</b> ' + d.nohp_penerima + '<br>' +
            '<b>Alamat:</b> ' + d.alamat_penerima + '<br>' +
            '<b>Kurir: </b>'+ d.kurir+'<br>'+
            '<b>Service: </b>'+ d.service+ '<br>'+
            '<b>Keterangan :</b> '+ d.ket_penerima+'</td><td>' +
            '<h5>Detail Pemabayaran</h5>' +
            '<b>Bukti Pembayaran :</b>'+d.bukti +'<br>'+
            '<b>Status :</b>'+d.status_pembayaran+'<br></td>'+
            d.det +
            '</tr>' +
            '</table>';
    }

    $('#table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

})