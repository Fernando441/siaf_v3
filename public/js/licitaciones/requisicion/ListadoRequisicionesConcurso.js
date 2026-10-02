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
                        verrequisicionurl = verrequisicionurl.substring(0, verrequisicionurl.lastIndexOf('/') + 1);
                        editarrequisicionurl = editarrequisicionurl.substring(0, editarrequisicionurl.lastIndexOf('/') + 1);
                        let addinfor = $('#addinfo').val();
                        addinfor = addinfor.substring(0, addinfor.lastIndexOf('/') + 1);

                        var opt_ver = ``; var opt_edit = ``; var opt_add_info = ``; var opt_send_finanzas = ``; var opt_delete = ``;

                        if(full.op_estatus== 1 || full.op_estatus== 7){
                            if (full.permisos.includes(118)){
                                opt_ver =`
                                    <a href="`+verrequisicionurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon-eye"></i>
                                    </a>
                                `;
                            }


                            if (full.permisos.includes(120)){
                                opt_add_info =`
                                    <a href="`+addinfor+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Agregar información" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon2-open-text-book"></i>
                                    </a>
                                `;
                            }

                            if (full.permisos.includes(136)){
                                opt_send_finanzas =`
                                    <a  class="finanzasRequisicion btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Enviar a finanzas" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="`+full.id+`">
                                            <i class="flaticon2-delivery-truck"></i>
                                    </a>
                                `;
                            }

                            return opt_ver + opt_add_info + opt_send_finanzas;

                        }else{
                            if (full.permisos.includes(118)){
                                opt_ver =`
                                    <a href="`+verrequisicionurl+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver requisición" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon-eye"></i>
                                    </a>
                                `;
                            }  
                            return opt_ver + opt_add_info + opt_send_finanzas;
                        }
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

            document.getElementById("id_del_req").value = id;
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


$("#send_desactivar").click(function(){
    var id_motivo_requisicion = document.getElementById("id_motivo_requisicion").value;
    if(id_motivo_requisicion == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas la requisición");
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



$("#kdatatable_requisicones_inactiva").DataTable({
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

$(".activar-requisicion").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
      title: "Estas seguro de activar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Activarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
        confirmButtonColor: "#73ab17",
        cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_requisicion_act").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("requisicion_act_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});





$("#tablaRequisicionesenconcurso").DataTable({
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

        $(".finanzasRequisicionlic").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var licitacion = $(this).attr('data-licitacion');

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
                            licitacion: licitacion,
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
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });