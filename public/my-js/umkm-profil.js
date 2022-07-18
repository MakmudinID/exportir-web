jQuery(document).ready(function() {
    $("#edit-profil").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            email:{
                required: true
            },
            nama: {
                required: true
            },
            nohp: {
                required: true
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: base_url + "/umkm/edit_profil",
                type: "POST",
                data: new FormData(document.getElementById("edit-profil")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Update Profil",
                            icon: 'error',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            html: "Profil Berhasil Diupdate!",
                            icon: 'success',
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