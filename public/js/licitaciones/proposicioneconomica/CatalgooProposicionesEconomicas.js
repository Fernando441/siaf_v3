"use strict";
var Tabla = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
        var table = $('#kdatatable_proposicioneconomica').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            // read more: https://datatables.net/examples/basic_init/dom.html

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            order: [[ 0, "desc" ]], //ordenamiento default
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },

            processing: true,
            serverSide: true,
            ajax: {
                url:$('#proposicioneconomicadatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'id', 'nombre','titulo_servicio', 'observaciones' ,'acciones'],
                },

            },
            columns: [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'titulo_servicio' },
                { data: 'observaciones' },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {

                    width: '130px',
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {

                            return '\
                                <a href="/licitacion/ver-propuesta-economica/'+full.id+'" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver Propuesta Económica" data-toggle="tooltip" data-theme="dark"><i class="flaticon-eye"></i></a>\
                                <a href="/licitacion/crear-propuesta-economica/'+full.licid+'/op/2" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar Propuesta Económica" data-toggle="tooltip" data-theme="dark"><i class="flaticon-edit"></i></a>\
                                <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deletepropuesta(\'' + full.nombre + '\', '+full.id+')" data-toggle="tooltip" data-theme="dark" title="Eliminar Propuesta Económica">\
                                    <i class="flaticon-delete "></i>\
                                </button>\
                            ';
                    },
                }

            ],

            buttons: [
                {extend: "excel", className: "invisible"},
                {extend: "pdf", className: "invisible"},
                {extend: "csv", className: "invisible"},
                {extend: "print", className: "invisible"},

            ],

            "drawCallback": function(settings, json) {
                KTApp.initTooltips();
            }


        }).on( 'init.dt', function () {
        });

        $('#export-excel').on('click', function () {
            table.button(0).trigger();
        });
        $('#export-pdf').on('click', function () {
            table.button(1).trigger();
        });
        $('#export-csv').on('click', function () {
            table.button(2).trigger();
        });
        $('#export-print').on('click', function () {
            table.button(3).trigger();
        });

        var filter = function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
        };

        $('#kt_search').on('click', function(e) {
            e.preventDefault();
            var params = {};
            $('.datatable-input').each(function() {
                var i = $(this).data('col-index');
                if (params[i]) {
                    params[i] += '|' + $(this).val();
                }
                else {
                    params[i] = $(this).val();
                }
            });
            $.each(params, function(i, val) {
                table.column(i).search(val ? val : '', false, false);
            });
            table.table().draw();
        });

        $('#kt_reset').on('click', function(e) {
            e.preventDefault();
            $('.datatable-input').each(function() {
                $(this).val('');
                table.column($(this).data('col-index')).search('', false, false);
            });
            table.table().draw();
        });

    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

jQuery(document).ready(function() {
    Tabla.init();
});

function deletepropuesta(nombre, id) {
    Swal.fire({
        title: "Estas seguro de eliminar el registro "+nombre,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminarlo!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true,
        confirmButtonColor: "#73ab17",
        cancelButtonColor: "#cc0c73",
    }).then(function(result) {
        if (result.value) {
            document.getElementById("id_delete").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("propuesta_delete_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
}