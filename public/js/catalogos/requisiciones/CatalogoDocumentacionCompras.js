"use strict";
var Tabla = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
        var table = $('#kdatatable_documento').DataTable({
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
                url:$('#documentaciondatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'id', 'tipo_documento', 'acciones'],
                },

            },
            columns: [
                { data: 'id', orderable: true },
                { data: 'tipo_documento', orderable: true },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    width: '200px',
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {

                            return '\
                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="editardocumento(\'' + full.tipo_documento + '\', '+full.id+')" data-toggle="modal" data-target="#model_edit_documento" data-toggle="tooltip" data-theme="dark" title="Editar documento">\
                                    <i class="flaticon-edit"></i></a>\
                                <a class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="deletedocumento(\'' + full.tipo_documento + '\', '+full.id+')" data-toggle="tooltip" data-theme="dark" title="Desactivar documento">\
                                    <i class="flaticon-delete "></i>\
                                </a>\
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

$("#send_tipodocumento").click(function(){
    var tipo_documento = document.getElementById("tipo_documento").value;
    if(tipo_documento == "" ){
        Swal.fire("Para continuar debes agregar la información solicitada");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_documento").submit();
    }
});

function editardocumento(nombre, id) {
  document.getElementById("id_documento_edit").value = id;
  document.getElementById("documento_edit").value = nombre;
}

$("#edit_documento_submit").click(function(){
    var documento_edit = document.getElementById("documento_edit").value;

    if(documento_edit == ""){
        Swal.fire("Para continuar debes agregar el nombre del documento");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_documento_edit").submit();
    }
});

function deletedocumento(nombre, id) {
    Swal.fire({
      title: "Estas seguro de desactivar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Desactivarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_documento_delete").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("documento_delete_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
}


$("#kdatatable_documentos_inactiva").DataTable({
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


$(".activar-documento").click(function() {
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
            document.getElementById("id_documento_act").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("documento_act_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});
