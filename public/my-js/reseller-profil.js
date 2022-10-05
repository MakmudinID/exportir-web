"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    $(document).on('change', '#propinsi', function() {
        $.ajax({
            url: base_url + "/get_kota/" + $(this).val(),
            type: "GET",
            success: function(isi) {
                $('#kota').html(isi);
            }
        });
    });

    $("#form-profil").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama: {
                required: true
            },
            re_password: {
                required: {
                    depends: function(element) {
                        return $("[name=password]").val() != '';
                    },
                },
            },
            tgl_lahir: {
                required: true
            },
            no_hp: {
                required: true
            },
            alamat: {
                required: true
            },
            propinsi: {
                required: true
            },
            kota: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            url = base_url + '/reseller/update_profil';

            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-profil")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: data.title,
                            html: data.status,
                            icon: data.icon,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                    } else {
                        Swal.fire({
                            title: data.title,
                            html: data.status,
                            icon: data.icon,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    });
});