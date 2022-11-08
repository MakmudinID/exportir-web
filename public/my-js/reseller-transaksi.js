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

    $(document).on('click', '.unggah-bukti-bayar', function() {
        $('[name="id_pembayaran"]').val($(this).data('id_pembayaran'));
        $('#modal-default').modal('show');
    });

    table = $('#table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: base_url + "/reseller/transaksi_",
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
                "data": 'tanggal_transaksi',
            },
            { "data": "kode_bayar" },
            { "data": "metode_bayar" },
            { "data": "total_tagihan" },
            { "data": "batas_bayar" },
            { "data": "status" },
            { "data": "detail" },
        ],
        columnDefs: [{
            targets: [-1, -2, 3],
            orderable: false,
            searchable: false,
            className: "text-center"
        }],
    });

    $("#form-bukti").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            foto: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/reseller/update_bayar';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-bukti")),
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
                            html: "Bukti Berhasil Diunggah!",
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

    $('#btn-filter').click(function() { //button filter event click
        table.ajax.reload(); //just reload table
    });
});

function preview_image(event) {
    document.getElementById("row-display").style.display = "block";
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}