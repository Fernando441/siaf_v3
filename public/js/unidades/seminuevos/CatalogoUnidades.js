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
                url:$('#unidaddatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'folio', 'id_ubicacion', 'contrato','marca', 'modelo', 'serie',
                        'placa', 'year', 'estatus', 'numero_economico', 'clave_vehicular', 'no_tarjeta_circulacion', 'no_poliza_seguro', 'permisos' ,'acciones', 'id_unidad_asignacion'],
                },

            },
            columns: [
                { data: 'folio' },
                { data: 'id_ubicacion' },
                { data: 'contrato'},
                { data: 'id_marca' },
                { data: 'id_modelo' },
                { data: 'no_serie' },
                { data: 'placa' },
                { data: 'unidad_year' },
                { data: 'id_status' },
                { data: 'numero_economico' },
                { data: 'clave_vehicular' },
                { data: 'no_tarjeta_circulacion' },
                { data: 'no_poliza_seguro' },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    width: '280px',
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var opt_ver = ``;
                        var opt_pdf = ``;

                        if (full.permisos.includes(9)){
                            opt_ver =`
                                <a href="/seminuevos/ver-unidad/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;

                            if (full.vendido == 1) {
                                opt_pdf = `
                                    <button rel-path="/seminuevos/venta-documento-pdf/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Documento PDF" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="far fa-file-pdf"></i>
                                    </button>
                                `;
                            }
                        }

                        return opt_ver + opt_pdf;

                    },
                },

                {
                    width: '280px',
                    targets: -6,
                    title: 'Estatus',
                    orderable: true,
                    render: function(data, type, full, meta) {
                        var venta =  ``;    
                        var estatus =  `
                        <span class="label label-lg label-light-warning label-inline">`+full.id_status+`</span>
                        `;

                        if (full.vendido == 1) {
                            venta =  `
                            <span class="label label-lg label-light-success label-inline">VENDIDO</span>
                            `;
                        }

                        return estatus + venta;

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


    var initEvents = function() {

        var arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }

        $('#fecha_asignacion').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        jQuery(document).on('click', '.modal-pdf', function (e) {
            e.preventDefault();
            var path = $(this).attr('rel-path');
            var modal = $('#modal_documento_pdf');
            var object_pdf = $('#modal-body-pdf');
            var content = `<object id="object_pdf" type="application/pdf" data="` + path + `" width="100%" height="500" style="height: 85vh;">No Support</object>`;
            object_pdf.html(content);
            modal.modal('show');
        });
    };


    return {

        //main function to initiate the module
        init: function() {
            initTable1();
            initEvents();

        },

    };

}();

jQuery(document).ready(function() {
    Tabla.init();
});


$("#busqueda").click(function(){
    var op_busqueda = document.getElementById("op_busqueda").value;
    if(op_busqueda == 1){
        $("#card-busqueda").show();
        document.getElementById("op_busqueda").value= 2;
    }else{
        $("#card-busqueda").hide();
        document.getElementById("op_busqueda").value= 1;
    }
});

function deleteunidad(id) {
    document.getElementById("id_delete_unidad").value = id;
}

$("#send_desactivar").click(function(){
    var id_motivo_unidad = document.getElementById("id_motivo_unidad").value;
    if(id_motivo_unidad == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas la unidad");
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


$("#kdatatable_vehiculos_inactivas").DataTable({
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

$(".activar-unidad").click(function() {
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
      document.getElementById("id_act_unidad").value = id;
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

$("#instrucciones").click(function(){
  $(".instruccion").show();
});

$("#send_carga").click(function(){
    var file_carga = document.getElementById("file_carga").value;

    if(file_carga == ""){
        Swal.fire("Para continuar debes agregar un archivo .csv");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_carga").submit();
    }

});

// Buscador

$("#ch_folio").click(function(){
    var inp_folio = document.getElementById("inp_folio").value;
    if(inp_folio == 0){
        $("#dv_folio").show();
        document.getElementById("inp_folio").value = 1;
    }else{
        $("#dv_folio").hide();
        document.getElementById("inp_folio").value = 0;
    }
});

$("#ch_patio").click(function(){
    var inp_patio = document.getElementById("inp_patio").value;
    if(inp_patio == 0){
        $("#dv_patio").show();
        document.getElementById("inp_patio").value = 1;
    }else{
        $("#dv_patio").hide();
        document.getElementById("inp_patio").value = 0;
    }
});

$("#ch_contrato").click(function(){
    var inp_contrato = document.getElementById("inp_contrato").value;
    if(inp_contrato == 0){
        $("#dv_contrato").show();
        document.getElementById("inp_contrato").value = 1;
    }else{
        $("#dv_contrato").hide();
        document.getElementById("inp_contrato").value = 0;
    }
});

$("#ch_marca").click(function(){
    var inp_marca = document.getElementById("inp_marca").value;
    if(inp_marca == 0){
        $("#dv_marca").show();
        document.getElementById("inp_marca").value = 1;
    }else{
        $("#dv_marca").hide();
        document.getElementById("inp_marca").value = 0;
    }
});

$("#ch_modelo").click(function(){
    var inp_modelo = document.getElementById("inp_modelo").value;
    if(inp_modelo == 0){
        $("#dv_modelo").show();
        document.getElementById("inp_modelo").value = 1;
    }else{
        $("#dv_modelo").hide();
        document.getElementById("inp_modelo").value = 0;
    }
});

$("#ch_serie").click(function(){
    var inp_serie = document.getElementById("inp_serie").value;
    if(inp_serie == 0){
        $("#dv_serie").show();
        document.getElementById("inp_serie").value = 1;
    }else{
        $("#dv_serie").hide();
        document.getElementById("inp_serie").value = 0;
    }
});

$("#ch_placa").click(function(){
    var inp_placa = document.getElementById("inp_placa").value;
    if(inp_placa == 0){
        $("#dv_placa").show();
        document.getElementById("inp_placa").value = 1;
    }else{
        $("#dv_placa").hide();
        document.getElementById("inp_placa").value = 0;
    }
});

$("#ch_year").click(function(){
    var inp_year = document.getElementById("inp_year").value;
    if(inp_year == 0){
        $("#dv_year").show();
        document.getElementById("inp_year").value = 1;
    }else{
        $("#dv_year").hide();
        document.getElementById("inp_year").value = 0;
    }
});

$("#ch_economico").click(function(){
    var inp_economico = document.getElementById("inp_economico").value;
    if(inp_economico == 0){
        $("#dv_economico").show();
        document.getElementById("inp_economico").value = 1;
    }else{
        $("#dv_economico").hide();
        document.getElementById("inp_economico").value = 0;
    }
});

$("#ch_clave").click(function(){
    var inp_clave = document.getElementById("inp_clave").value;
    if(inp_clave == 0){
        $("#dv_clave").show();
        document.getElementById("inp_clave").value = 1;
    }else{
        $("#dv_clave").hide();
        document.getElementById("inp_clave").value = 0;
    }
});

$("#ch_circulacion").click(function(){
    var inp_circulacion = document.getElementById("inp_circulacion").value;
    if(inp_circulacion == 0){
        $("#dv_circulacion").show();
        document.getElementById("inp_circulacion").value = 1;
    }else{
        $("#dv_circulacion").hide();
        document.getElementById("inp_circulacion").value = 0;
    }
});

$("#ch_seguro").click(function(){
    var inp_seguro = document.getElementById("inp_seguro").value;
    if(inp_seguro == 0){
        $("#dv_seguro").show();
        document.getElementById("inp_seguro").value = 1;
    }else{
        $("#dv_seguro").hide();
        document.getElementById("inp_seguro").value = 0;
    }
});

$("#kdatatable_dicha_tecnica").DataTable({
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