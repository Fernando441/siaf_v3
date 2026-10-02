"use strict";
var ListadoRequisiciones = function() {

    var table;

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
            table = $('#tablaRequisiciones').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            // read more: https://datatables.net/examples/basic_init/dom.html

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            order: [[ 0, "asc" ]], //ordenamiento default
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },

            processing: true,
            serverSide: true,
            ajax: {
                    url:$('#requisicionesurl').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'folio', 'solicitante', 'area', 'estatus', 'fecha_solicitud','op_estatus', 'permisos' ,'acciones'
                    ],
                },

            },
            columns: [
                {data: 'folio', orderable: true},
                {data: 'solicitante', orderable: true},
                {data: 'area', orderable: true},
                {data: 'estatus', orderable: true},
                {data: 'fecha_solicitud', orderable: true},
                {data: 'acciones', responsivePriority: -1, orderable: false},
            ],

            columnDefs: [
                {
                    width: '200px',
                    targets: -1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        let verrequisicionurl = $('#verrequisicionurl').val();
                        let editarrequisicionurl = $('#editarrequisicionurl').val();
                        let ordencompraurl = $('#generarordencompraurl').val();
                        verrequisicionurl = verrequisicionurl.substring(0, verrequisicionurl.lastIndexOf('/') + 1);
                        editarrequisicionurl = editarrequisicionurl.substring(0, editarrequisicionurl.lastIndexOf('/') + 1);
                        ordencompraurl = ordencompraurl.substring(0, ordencompraurl.lastIndexOf('/') + 1);

                        var opt_ver = ``; var opt_orden =""; var opt_back =""; var opt_asignacion ="";
                        if (full.permisos.includes(131)){
                            opt_ver =`
                                <a href="`+verrequisicionurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;
                        }
                        if (full.permisos.includes(131)){
                            if(full.op_estatus == 2){
                                opt_back =`
                                    <a href="#" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="regresarrequisicion(`+full.id+`)" data-toggle="modal" data-target="#model_back_requisicion" title="Regresar requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon2-reply "></i>
                                    </a>
                                `;
                            }
                        }
                        if (full.permisos.includes(132)){
                            opt_orden =`
                                <a href="`+ordencompraurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Unidades a requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-crisp-icons"></i>
                                </a>
                            `;
                        }

                        // if (full.permisos.includes(132)){
                        //     opt_asignacion =`
                        //         <a href="`+asignacionunidadesurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Asignación unidades" data-theme="dark" data-toggle="tooltip" data-placement="top">
                        //                 <i class="flaticon2-delivery-truck"></i>
                        //         </a>
                        //     `;
                        // }

                        return opt_ver + opt_back + opt_orden ;
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
                initSwalEliminar();
                initSwalFinanzas();
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

    var initSwalEliminar = function() {
        $(".eliminarRequisicion").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Estas seguro de desactivar el registro?.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Desactivarlo!",
                cancelButtonText: "No, Cancelar!",
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: $('#eliminarrequisicionurl').val(),
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Requisición eliminada.",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(function(result) {
                                    if (result.value) {
                                        $('#tablaRequisiciones').DataTable().ajax.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    };

    var initSwalFinanzas = function() {
        $(".finanzasRequisicion").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Estas seguro de enviar a finanzas?.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Enviar!",
                cancelButtonText: "No, Cancelar!",
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: $('#finanzasrequisicionurl').val(),
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Requisición enviada a finanzas.",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(function(result) {
                                    if (result.value) {
                                        $('#tablaRequisiciones').DataTable().ajax.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    };


    return {

        init: function() {
            initTable1();
            initSwalEliminar();
            initSwalFinanzas();
        },

    };

}();

jQuery(document).ready(function() {
    ListadoRequisiciones.init();
});



$("#kdatatable_patios").DataTable({
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

$("#kdatatable_unidades_req").DataTable({
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

$("#vistobueno").click(function(){

    Swal.fire({
      title: "Estas seguro de dar visto bueno a la requisición?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, continuar!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("vistobueno_firm").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});



$(".eliminar-unidad").click(function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
        title: "Estas seguro de eliminar la unidad "+nombre,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminarlo de la requisición!",
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
            document.getElementById("unidad_act_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});