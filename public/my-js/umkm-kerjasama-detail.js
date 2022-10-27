"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    $("#form-bukti-kirim").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            no_resi: {
                required: true
            },
            foto: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/umkm/update_kirim';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-bukti-kirim")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Unggah Bukti Kirim",
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
                            html: "Bukti Kirim Berhasil Diunggah!",
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

    $(document).on('click', '.update-status', function() {
        $('[name="id_transaksi"]').val($(this).data('id_transaksi'));
        $('#modal-default').modal('show');
    });

    $(document).on('click', '.update-konfirmasi', function() {
        $('[name="no_kerjasama"]').val($(this).data('no_kerjasama'));
        $('#modal-kerjasama').modal('show');
    });

    $(document).on('click', '.update-batal', function() {
        $('[name="no_kerjasama"]').val($(this).data('no_kerjasama'));
        $('#modal-batal').modal('show');
    });

    $("#form-kerjasama").validate({
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
            url = base_url + '/umkm/pdf_upload';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-kerjasama")),
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

    $("#form-batal").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            no_kerjasama: {
                required: true
            },
            alasan_ditolak: {
                required: true
            }
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/umkm/batal_kerjasama';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-batal")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Batal Kerjasama",
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
                            html: "Kerjasama Berhasil Dibatalkan!",
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