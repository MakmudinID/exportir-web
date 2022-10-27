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

    $(document).on('click', '.unggah-perjanjian', function() {
        document.getElementById("btn-unduh-kerjasama").href = $(this).data('url');
        $('[name="no_kerjasama"]').val($(this).data('no_kerjasama'));
        $('#modal-default').modal('show');
    });

    $("#form-dokumen").validate({
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
            url = base_url + '/admin/pdf_upload';

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
            url: base_url + "/admin/kerjasama_",
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