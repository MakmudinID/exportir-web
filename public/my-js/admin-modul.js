"use strict";

let editor, table;
jQuery(document).ready(function() {
    var today = moment().startOf('day');
    var endDate = moment().endOf('day');
    $('.daterange-picker').val(moment(today).format('YYYY-MM-DD HH:mm:ss') + " - " + moment(endDate).format('YYYY-MM-DD HH:mm:ss'));

    table = $("#table").DataTable({
        dom: "<'row mb-3'<'col-md-4 mb-3 mb-md-0'l><'col-md-8 text-right'<'d-flex justify-content-end'fB>>>rt<'row align-items-center'<'mr-auto col-md-6 mb-3 mb-md-0 mt-n2 'i><'mb-0 col-md-6'p>>",
        ajax: {
            url: base_url + "/admin/modul_",
            type: "POST",
        },
        lengthMenu: [10, 20, 30, 40, 50],
        serverSide: true,
        processing: true,
        autoWidth: true,
        pageLength: 30,
        columns: [
            { data: "no" },
            { data: "nama" },
            { data: "group" },
            { data: "status" },
            { data: "action" },
        ],
        columnDefs: [{
            targets: [4],
            orderable: false,
            searchable: false,
        }, ],
        order: [],
        buttons: [{
            text: "<i class ='fa fa-plus-square'></i> New",
            className: "btn-primary",
            action: function(e, dt, node, config) {
                window.location.href = base_url + "/penyaluran/create-mustahik";
            },
        }, ],
    });

    $("#btn-filter").click(function() {
        table.ajax.reload();
    });

    $("#btn-reset").click(function() {
        $("#form-filter")[0].reset();
        $("#kategori_donatur").val([]).trigger("change");
        $("#propinsi").val([]).trigger("change");
        $("#kota").val([]).trigger("change");
        $("#kecamatan").val([]).trigger("change");
        $("#kelurahan").val([]).trigger("change");
        table.ajax.reload();
    });
});