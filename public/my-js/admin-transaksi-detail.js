"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
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
            url = base_url + '/admin/update_bayar';

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
                        window.location.reload();
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
                        window.location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    });

    $(document).on('click', '.unggah-bukti-bayar', function() {
        $('[name="id_pembayaran"]').val($(this).data('id_pembayaran'));
        $('#modal-default').modal('show');
    });

    $("#form-selesai").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            id_transaksi: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/admin/update_selesai';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-selesai")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Update Selesai",
                            icon: 'error',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                        window.location.reload();
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            html: "Status Pesanan Sudah Selesai!",
                            icon: 'success',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        $('#modal-selesai').modal('hide');
                        $('body').removeClass('modal-open');
                        window.location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    });

    $(document).on('click', '.update-status-selesai', function() {
        $('[name="id_transaksi"]').val($(this).data('id_transaksi'));
        $('#modal-selesai').modal('show');
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