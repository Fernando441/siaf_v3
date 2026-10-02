"use strict";
var Tabla = function() {

    var table;

    table = $("#kt_datatable_example_1").DataTable({
        select: {
            style: 'multi', // or 'os', 'multi', 'multi+shift'
            items: 'row'     // or 'column', 'cell'
        },
        language: {
            'lengthMenu': 'Display _MENU_',
            "url": $('#datatable_i18n').val()
        },
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, 50], [5, 10, 25, 50] ]
        ,

        "dom":
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
        buttons: [
            {extend: "excel", className: "invisible"},
            {extend: "pdf", className: "invisible"},
            {extend: "csv", className: "invisible"},
            {extend: "print", className: "invisible"},

        ],
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

     table.on('select', function(e, dt, type, indexes) {
        var row = table.row(indexes).nodes().to$();
        row.css('background-color', '#669933; !important;'); // naranja
    });


    // $.fn.dataTable.Api.register('column().title()', function() {
    //     return $(this.header()).text().trim();
    // });
    // console.log($.fn.dataTable.version);
   /*  var initTable1 = function() {
        // begin first table
        table = $('#kt_datatable_example_1').DataTable({
              select: {
                style: 'multi', // or 'os', 'multi', 'multi+shift'
                items: 'row'     // or 'column', 'cell'
            },
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
                        'folio', 'id_ubicacion', 'marca', 'modelo', 'serie',
                        'placa', 'year', 'estatus', 'permisos' ,'acciones', 'id_unidad_asignacion','vendido'],
                },

            },
            columns: [
                { data: 'folio' },
                { data: 'id_ubicacion' },
                { data: 'id_marca' },
                { data: 'id_modelo' },
                { data: 'no_serie' },
                { data: 'placa' },
                { data: 'unidad_year' },
                { data: 'id_status' },
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
                        var venta = "";
                        var opt_desactivar = "";

                         var check = `<label class="checkbox"><input type="checkbox" name="vehiculo[]" value="${full.id}"><span></span></label>`;

                        if (full.permisos.includes(9)){
                            opt_ver =`
                                <a href="/seminuevos/venta-ver-unidad/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;
                        }

                        if (full.permisos.includes(12) && full.vendido == 0){
                           opt_desactivar =  `
                                <button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar" data-toggle="modal" data-target="#modal_eliminar" data-toggle="tooltip" data-theme="dark" title="Cancelar Venta" data-unidad-id="`+full.id+`">
                                        <i class="flaticon-delete"></i>
                                </button>
                            `;
                        }
                        
                        if (full.vendido == 0) {
                            
                            venta =  `
                            <a href="/seminuevos/venta-final/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Vender Unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                            <i class="flaticon-price-tag"></i>
                            </a>
                            `;
                            
                        }

                        return  opt_ver + venta + opt_desactivar + check;

                    },
                },
                {
                    width: '280px',
                    targets: -2,
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
                },
                {
                    width: '100px',
                    targets: 0,
                    title: 'Serie',
                    orderable: true,
                    render: function(data, type, full, meta) {
                        var venta =  ``;    
                        
                            venta =  `
                            <span class="">` + full.folio + `</span>
                            `;

                        return  venta;

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

    }; */


    var initEvents = function() {

        jQuery(document).on("click", ".hrefEliminar" , function(e) {
            e.preventDefault();
            var unidad_id = $(this).attr("data-unidad-id");
            $('#unidad_id').val(unidad_id);
        });

        $("#btn_eliminar").click(function(){
           document.getElementById("submit_desactivar").submit();
        });

        jQuery(document).on("click", "#btn_apartar" , function(e) {
            e.preventDefault();
            var nodos = table.rows({ selected: true }).nodes();

            // Extraer el atributo personalizado "data-id"
            var ids = [];
            $(nodos).each(function() {
                ids.push($(this).attr('data-id'));
            });

            console.log(ids);
            if (ids.length === 0) {
                toastr.warning("Debe seleccionar al menos una unidad para apartar.");
                KTUtil.scrollTop();
                return;
            }
            
            // Convertir a cadena separada por comas
            var cadena = ids.join(',');
            $('#unidades_id').val(cadena);
            var btnGuardar = document.getElementById('btn_apartar');
            KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
            document.getElementById("frm_apartar").submit();
        });
    };


    return {

        //main function to initiate the module
        init: function() {
            //initTable1();
            initEvents();
        },

    };

}();

jQuery(document).ready(function() {
    Tabla.init();
});
 