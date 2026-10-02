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
                url:$('#clientedatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'rfc', 'razon_social', 'alias', 'calle_numero','colonia', 'municipio', 'estado',
                        'codigo_postal', 'permisos' ,'acciones'],
                },

            },
            columns: [
                { data: 'rfc', orderable: true },
                { data: 'razon_social', orderable: true },
                { data: 'alias', orderable: true },
                { data: 'calle_numero' },
                { data: 'colonia', orderable: true },
                { data: 'id_municipio', orderable: true },
                { data: 'id_estado', orderable: true },
                { data: 'codigo_postal', orderable: true },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {

                        if (full.permisos.includes(33) && full.permisos.includes(35)  && full.permisos.includes(36)){
                           return `
                                <a href="/cliente/ver-cliente/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                                <a href="/cliente/editar-cliente/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deletecliente(`+ full.nombre +`,`+full.id+`)" data-toggle="modal" data-target="#model_delete_user" data-toggle="tooltip" data-theme="dark" title="Desactivar cliente">
                                        <i class="flaticon-delete"></i>
                                 </a>
                            `;
                        }

                        if (full.permisos.includes(33)  && full.permisos.includes(35)){
                           return `
                                <a href="/cliente/ver-cliente/`+full.permisos+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                                <a href="/usuario/editar-usuario/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-edit"></i>
                                </a>
                            `;
                        }
                        if (full.permisos.includes(33)  && full.permisos.includes(36)){
                           return `
                                <a href="/cliente/ver-cliente/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deletecliente(`+ full.nombre +`,`+full.id+`)" data-toggle="modal" data-target="#model_delete_user" data-toggle="tooltip" data-theme="dark" title="Desactivar cliente">
                                        <i class="flaticon-delete"></i>
                                 </a>
                            `;
                        }

                        if (full.permisos.includes(33)){
                           return `
                                <a href="/cliente/ver-cliente/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver cliente" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;
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

        }).on( 'init.dt', function () {
            KTApp.initTooltips();
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

function deletecliente(nombre, id) {
  document.getElementById("id_cliente_desc").value = id;
  document.getElementById("name_cliente").value = nombre;
}

$("#send_desactivar").click(function(){
    var id_cli_unidad = document.getElementById("id_cli_unidad").value;
    if(id_cli_unidad == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas al cliente");
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

$("#kdatatable_clientes_inactivos").DataTable({
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


$(".activar-cliente").click(function() {
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
      document.getElementById("id_cli_act").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
      });
      document.getElementById("cli_act_form").submit();
    } else if (result.dismiss === "cancel") {
      Swal.fire(
         "Cancelada",
        "La acción fue cancelada",
        "error"
      )
    }
  });
});