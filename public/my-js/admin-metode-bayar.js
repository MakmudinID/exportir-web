"use strict";

let editor, table, save_method; // use a global for the submit and return data rendering in the examples

jQuery(document).ready(function() {
    table = $('#table').DataTable({
        ajax: {
            url: base_url + "/admin/metode_bayar_",
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
            },
            { "data": "nama" },
            { "data": "nomor_rekening" },
            { "data": "status" },
            { "data": "aksi" },
        ],
        columnDefs: [{
            targets: [0, 2, 3, 4],
            className: "text-center"
        }, {
            targets: [0],
            orderable: false,
            searchable: false,
        }],
    });

    $(document).on('click', '.add', function() {
        save_method = 'add';
        $('#form-metode-bayar')[0].reset();
        $('#modal-default').modal('show');
        $('.modal-title').text('Tambah metode_bayar');
    });

    $(document).on('click', '.edit', function() {
        save_method = 'update';
        $('#form-metode-bayar')[0].reset();
        $('#modal-default').modal('show');
        $('.update').text('Update');
        $('.modal-title').text('Edit metode_bayar');
        $('[name="id"]').val($(this).data('id'));
        $('[name="nama"]').val($(this).data('nama'));
        $('[name="nomor_rekening"]').val($(this).data('nomor_rekening'));
        $('[name="status"]').val($(this).data('status'));
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Anda Yakin?',
            html: "Metode bayar " + nama + "<br><br><b>Akan Dihapus!</b>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "/admin/delete_metode_bayar",
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


    $("#form-metode-bayar").validate({
        errorClass: "is-invalid",
        // validClass: "is-valid",
        rules: {
            nama: {
                required: true
            },
            nomor_rekening: {
                required: true,
                number: true
            },
            status: {
                required: true
            },
        },
        submitHandler: function(form) {
            let url;
            if (save_method == 'update') {
                url = base_url + '/admin/update_metode_bayar';
            } else {
                url = base_url + '/admin/create_metode_bayar';
            }
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(document.getElementById("form-metode-bayar")),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.result != true) {
                        Swal.fire({
                            title: 'Gagal',
                            html: "Gagal Tambah Metode Bayar",
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
                            html: "Metode Bayar Berhasil Disimpan!",
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