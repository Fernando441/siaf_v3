"use strict";
var Tabla = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
        var table = $('#kt_datatable_example_1').DataTable({
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
                url:$('#contratodatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'folio', 'id_contrato', 'no_contrato', 'emisor', 'cliente', 'titulo_servicio', 'tipo_contrato', 'permisos' ,'acciones'],
                },

            },
            columns: [
                { data: 'no_folio', orderable: true},
                { data: 'id_contrato', orderable: true},
                { data: 'no_contrato', orderable: true },
                { data: 'id_emisor', orderable: true },
                { data: 'id_cliente', orderable: true },
                { data: 'titulo_servicio', orderable: true },
                { data: 'tipo_contrato', orderable: true },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var opt_ver = ``; var opt_edit = ``;  var opt_desactivar = ``; var opt_clientes = ``; var opt_unidades_asignadas = ``; var opt_estimaciones = ``;
                        if (full.permisos.includes(128)){
                            opt_ver =`
                                <a href="/proyecto/ver-proyecto/`+full.licitacion+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(129)){
                            opt_edit =`
                                <a href="/proyecto/editar-proyecto/`+full.licitacion+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-edit"></i>
                                    </span>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(142)){
                            opt_clientes =`
                                <a href="/proyecto/asignar-proyecto-usd/`+full.licitacion+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Asignar clientes al contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon2-user-1"></i>
                                    </span>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(144)){
                            opt_unidades_asignadas =`
                                <a href="/proyecto/unidades-asignadas-proyecto/`+full.licitacion+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Unidades asignadas" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-truck"></i>
                                    </span>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(145)){
                            opt_estimaciones =`
                                <a href="/proyecto/estimaciones/`+full.licitacion+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Estimaciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-file-1"></i>
                                    </span>
                                </a>
                            `;
                        }


                        if (full.permisos.includes(130)){
                           opt_desactivar =  `
                                <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deletecontrato(`+ full.nombre +`,`+full.id+`)" data-toggle="modal" data-target="#model_delete_proyectos" data-toggle="tooltip" data-theme="dark" title="Desactivar Contrato">
                                    <span class="svg-icon svg-icon-md">
                                        <i class="flaticon-delete"></i>
                                    </span>
                                </button>
                            `;
                        }
                            return opt_ver + opt_edit + opt_clientes + opt_unidades_asignadas + opt_estimaciones + opt_desactivar;

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


$("#busqueda_pro").click(function(){
    var op_busqueda = document.getElementById("op_busqueda").value;
    if(op_busqueda == 1){
        $("#card-busqueda").show();
        document.getElementById("op_busqueda").value= 2;
    }else{
        $("#card-busqueda").hide();
        document.getElementById("op_busqueda").value= 1;
    }
});

function deletecontrato(nombre, id) {
  document.getElementById("id_delete").value = id;
}

$("#send_desactivar").click(function(){
    var id_motivo_contrato = document.getElementById("id_motivo_contrato").value;
    if(id_motivo_contrato == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas el contrato");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_desactivar").submit();
    }
});

$("#kdatatable_contrato_inactivo").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
});


$(".activar-contrato").click(function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
        title: "Estas seguro de activar el registro "+nombre,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Activarlo!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            document.getElementById("id_delete").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("contrato_activar_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});