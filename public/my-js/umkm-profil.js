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

    $("#edit-umkm").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama_umkm:{
                required: true
            },
            deskripsi_umkm: {
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
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: base_url + "/umkm/edit_umkm",
                type: "POST",
                data: new FormData(document.getElementById("edit-umkm")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Update UMKM",
                            icon: 'error',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil',
                            html: "UMKM Berhasil Diupdate!",
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

    get_kota($('#hidden_kota').val());

    $(document).on('click','#propinsi', function(){
        get_kota();
    })

});

function preview_image_profil(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('output_image_foto');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function preview_image(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function get_kota(id=''){
    var id_propinsi = $('#propinsi').val();
        $.ajax({
            url: base_url+"/wilayah/city/"+id_propinsi,
            type: "GET",
            success:function(res){
                var kot = JSON.parse(res);
                var data = kot.rajaongkir.results;
                var isi = '<option value="">- Pilih Kota -</option>';
                for(var i = 0; i < data.length; i++){
                    isi += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
                }
                $('#kota').html(isi);
                $('#kota').val(id);
            }
        })
}