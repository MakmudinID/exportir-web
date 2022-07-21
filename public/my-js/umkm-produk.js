"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/umkm/produk_",
            type: "POST",
        },
        lengthMenu: [10, 20, 30, 40, 50, 60, 80, 100],
        responsive: true,
        serverSide: true,
        processing: true,
        pageLength: 30,
        order: [],
        columns: [{
                "data": 'no',
                "sortable": false,
                "searchable": false,
            },
            { "data": "nama" },
            { "data": "deskripsi" },
            { "data": "qty" },
            { "data": "aksi" },
        ],
        columnDefs: [{
            targets: [0, 4],
            orderable: false,
            searchable: false,
            className: 'text-center'
        }],
    });

    $(document).on('click', '.add', function() {
        save_method = 'add';
        document.getElementById('form-produk').reset()
        $('#modal-default').modal('show');
        $('.modal-title').text('Tambah Produk');
    });

    $(document).on('click', '.edit', function() {
        save_method = 'update';
        document.getElementById('form-produk').reset()
        $('#modal-default').modal('show');
        $('.update').text('Update');
        $('.modal-title').text('Edit Produk');
        $('[name="id"]').val($(this).data('id'));
        $('[name="nama"]').val($(this).data('nama'));
        $('[name="deskripsi"]').val($(this).data('deskripsi'));
        $('[name="qty"]').val($(this).data('qty'));
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda Yakin?',
            html: "Produk " + nama + "<br><br><b>Akan Dihapus!</b>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "/umkm/delete_produk",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#table').DataTable().ajax.reload();
                        Swal.fire({
                            title: data.title,
                            html: nama + '<br><br><b>' + data.status + "</b>",
                            icon: data.icon,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            buttons: false,
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error');
                    }
                });
            }
        })
    });


    $("#form-produk").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama: {
                required: true
            },
            deskripsi: {
                required: true
            },
            qty: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            if (save_method == 'update') {
                url = base_url + '/umkm/update_produk';
            } else {
                url = base_url + '/umkm/create_produk';
            }
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-produk")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Tambah Produk",
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
                            html: "Produk Berhasil Ditambahkan!",
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
});