"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    $("#form-chat").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            no_kerjasama: {
                required: true
            },
            dokumen: {
                required: true
            }
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/reseller/pdf_upload';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-dokumen")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Unggah Dokumen",
                            icon: 'error',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            html: "Dokumen Berhasil Diunggah!",
                            icon: 'success',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        $('#modal-default').modal('hide');
                        $('body').removeClass('modal-open');
                        table.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    });

    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/reseller/chatting_",
            type: "POST",
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        pageLength: 30,
        order: [],
        columns: [{
                "data": 'tanggal',
            },
            {
                "data": 'kode_transaksi',
            },
            { "data": "pengirim" },
            { "data": "penerima" },
            { "data": "topik" },
            { "data": "detail" },
        ],
        columnDefs: [{
            targets: [-1, -2, 3, 4],
            orderable: false,
            searchable: false,
            className: "text-center"
        }],
    });

    $('#btn-filter').click(function() { //button filter event click
        table.ajax.reload(); //just reload table
    });
});