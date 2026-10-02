"use strict";
var Tabla = function() {

    var table;

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
            table = $('#kt_datatable_example_1').DataTable({
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
                    url:$('#licitaciondatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'folio', 'no_licitacion', 'cliente', 'titulo_servicio','id_licitacion_prioridad','publicacion_licitacion', 'fecha_visita', 'tipo_contratacion', 'permisos', 'acto_fallo', 'tipo_contrato',
                        'acciones'],
                },

            },
            columns: [
                { data: 'folio' },
                { data: 'no_licitacion' },
                { data: 'cliente' },
                { data: 'titulo_servicio' },
                { data: 'id_licitacion_prioridad' },
                { data: 'publicacion_licitacion' },
                { data: 'fecha_visita' },
                { data: 'tipo_contratacion' },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    width: '50px',
                    targets: -5,
                    orderable: true,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: {'title': 'Alta', 'class': 'label-outline-danger'},
                            2: {'title': 'Media', 'class': 'label-outline-warning'},
                            3: {'title': 'Baja', 'class': 'label-outline-primary'},
                        };
                        if (typeof status[full.id_licitacion_prioridad] === 'undefined') {
                            return data;
                        }
                        return '<span class="label font-weight-bold ' + status[full.id_licitacion_prioridad].class + ' label-inline" >' + status[full.id_licitacion_prioridad].title + '</span>';
                    },
                },
                {
                    width: '250px',
                    targets: -1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var opt_ver = ``; var opt_edit = ``; var opt_contrato = ``; var opt_pro_economica=``; var opt_pro_tecnica =``; var opt_desactivar =`` ; var opt_fianzas =`` ;
                        var opt_pdf = ``; var opt_requisicion = ``;
                        if (full.permisos.includes(114)){
                           opt_ver =  `
                                <a href="/licitacion/ver-licitacion/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;
                            
                            opt_pdf =  `
                                <button rel-path="/licitacion/ver-licitacion-pdf/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver PDF" data-theme="dark"  data-toggle="tooltip" data-placement="top">
                                        <i class="far fa-file-pdf"></i>
                                </button>
                            `;
                        }

                        if (full.permisos.includes(116)){
                           opt_edit =  `
                                <a href="/licitacion/editar-licitacion/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar concurso" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-edit"></i>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(133)){
                            if(full.acto_fallo == null || full.acto_fallo == ""){
                                opt_contrato = ``; 
                            }else{
                               opt_contrato =  `
                                    <a href="/licitacion/agregar-proyecto/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear contrato" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon-file-1"></i>
                                    </a>
                                `;
                            }
                        }

                        if (full.permisos.includes(134)){
                               opt_pro_economica =  `
                                    <a href="/licitacion/crear-propuesta-economica/`+full.id+`/op/1/contrato/`+full.tipo_contrato+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta económica" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon-presentation-1"></i>
                                    </a>
                                `;
                        }

                        if(full.permisos.includes(143)){
                            opt_fianzas =  `
                                    <a href="/licitacion/agregar-informacion-finanzas/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información de las fianzas y seguros" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                            <i class="flaticon-notepad"></i>
                                    </a>
                                `;
                        }

                        if (full.permisos.includes(135)){
                           opt_pro_tecnica =  `
                                <a href="/licitacion/crear-propuesta-tecnica/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Crear propuesta" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-website"></i>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(135)){
                           opt_requisicion =  `
                                <a href="/licitacion/listado-requisiciones-concurso/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Requisiciones" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-delivery-truck"></i>
                                </a>
                            `;
                        }


                        if (full.permisos.includes(117)){
                           opt_desactivar =  `
                                <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deleteconcurso(`+ full.nombre +`,`+full.id+`)" data-toggle="modal" data-target="#model_delete_concurso" data-toggle="tooltip" data-theme="dark" title="Desactivar concurso">
                                        <i class="flaticon-delete"></i>
                                </button>
                            `;
                        }


                        return opt_ver + opt_pdf + opt_edit + opt_contrato + opt_pro_economica + opt_fianzas + opt_pro_tecnica + opt_requisicion + opt_desactivar;

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
                modalPDF();
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

    var modalPDF = function() {

        $(".modal-pdf").on('click', function () {
            var path = $(this).attr('rel-path');
            var modal = $("#exampleModalSizeSm");
            var object_pdf = $("#modal-body");
            var content = `<object id="object_pdf" type="application/pdf" data="`+path+`" width="100%" height="500" style="height: 85vh;">No Support</object>`;
            object_pdf.html(content);
            modal.modal("show");
        });
    };

    var initSwalEliminar = function() {
        $(".hrefEliminar").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var folio = $(this).attr('data-folio');
            var block = $('#kt_datatable_example_1');

            Swal.fire({
                title: "¿Desea eliminar la licitación?.",
                text: folio,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Licitación",
                cancelButtonText: "Cerrar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#licitacionEliminarPath').val(),
                        data: {
                            id: id,
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function() {
                            KTApp.block(block, {
                                state: 'primary',
                                message: 'Espere por favor...'
                            });
                        }
                    }).done(function(data) {
                        KTApp.unblock(block);
                        table.table().draw();
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success("La licitación se elimino correctamente.");
                    });
                }
            });
        });
    };


    return {

        //main function to initiate the module
        init: function() {
            initTable1();
            initSwalEliminar();
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


function deleteconcurso(nombre, id) {
  document.getElementById("id_del_lic").value = id;
  document.getElementById("name_concurso").value = nombre;
}

$("#send_desactivar").click(function(){
    var id_motivo_concurso = document.getElementById("id_motivo_concurso").value;
    if(id_motivo_concurso == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas el concurso");
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


$("#kdatatable_licitaciones_inactivas").DataTable({
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

$(".activar-licitacion").click(function() {
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
      document.getElementById("id_lic_act").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
      });
      document.getElementById("lic_act_form").submit();
    } else if (result.dismiss === "cancel") {
      Swal.fire(
         "Cancelada",
        "La acción fue cancelada",
        "error"
      )
    }
  });
});
