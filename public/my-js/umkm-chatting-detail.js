let kode = $("#kode_transaksi").val();

function manage() {
    clearInterval(this.intervalID);
    this.intervalID = setInterval(function() {
        loadHistoriObrolan(kode);
    }, 300);
}

function loadHistoriObrolan(kode) {
    $.ajax({
        url: base_url + "/umkm/historiObrolan",
        type: "POST",
        data: {
            kode_transaksi: kode,
        },
    }).done(function(response) {
        $("#historiObrolan").html(response);
    });
}

jQuery(document).ready(function() {
    loadHistoriObrolan(kode);

    $("#form-pesan").validate({
        error: "is-invalid",
        rules: {
            pesan: {
                required: true
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: base_url + '/umkm/kirim-chatting-isi',
                type: "POST",
                data: new FormData(document.getElementById("form-pesan")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: "Gagal",
                            html: "Gagal kirim pesan",
                            icon: "error",
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                        table.ajax.reload();
                    } else {
                        $("#pesan").val("");
                        manage();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error adding / update data");
                },
            });
        }
    });
});