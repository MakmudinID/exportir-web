jQuery(document).ready(function() {
    $('#for-umkm').hide();

    $(document).on('change', '#role',
        function() {
            if ($(this).val() == 'UMKM') {
                $('#for-umkm').show();
            } else {
                //UMKM
                $('#for-umkm').hide();
            }
        });

    $(document).on('change', '#provinsi', function() {
        $.ajax({
            url: base_url + "/get_kota/" + $(this).val(),
            type: "GET",
            success: function(isi) {
                $('#kota').html(isi);
            }
        });
    });

    $("#form-daftar").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },
            no_hp: {
                required: true
            },
            alamat: {
                required: true
            },
            provinsi: {
                required: true
            },
            kota: {
                required: true
            },
            role: {
                required: true
            },
            nama_umkm: {
                required: {
                    depends: function(element) {
                        return $("[name=role]").val() == 'UMKM';
                    },
                },
            },
            kategori_umkm: {
                required: {
                    depends: function(element) {
                        return $("[name=role]").val() == 'UMKM';
                    },
                },
            },
            deskripsi_umkm: {
                required: {
                    depends: function(element) {
                        return $("[name=role]").val() == 'UMKM';
                    },
                },
            }
        }
    });
})