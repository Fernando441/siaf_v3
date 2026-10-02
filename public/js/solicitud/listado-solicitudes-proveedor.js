"use strict";
var Tabla = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        var table = $('#kt_datatable_example_1').DataTable({
            responsive: true,
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
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
                url:$('#datos_listado').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'id', 'solicitud_tipo', 'nombre','vehiculos', 'fecha', 'solicitud_estatus', 'acciones', 'solicitud_tipo_id'
                    ],
                },

            },
            columns: [
                { data: 'id' },
                { data: 'solicitud_tipo_id' },
                { data: 'nombre'},
                { data: 'vehiculos' },
                { data: 'fecha' },
                { data: 'solicitud_estatus_id' },
                {data: 'acciones', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    width: '280px',
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var opt_ver = ``, opt_editar = ``;

                        if (full.permisos.includes(9)){
                            if (full.solicitud_estatus_id == 2 && full.solicitud_ejecucion_id == null) {
                                opt_ver =`
                                <a href="/solicitud/programar-actividad/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modalVer" title="Programar Actividad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-calendar-with-a-clock-time-tools"></i>
                                </a>
                                `;
                            }

                            if (
                                (full.solicitud_estatus_id == 2 && full.solicitud_ejecucion_id != null) ||
                                (full.solicitud_estatus_id == 6 && full.solicitud_ejecucion_id != null)
                            ) {
                                opt_editar =`
                                <a href="/solicitud/editar-detalle-actividad/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modalVer" title="Editar Actividad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-calendar-with-a-clock-time-tools"></i>
                                </a>
                                `;
                            }
                        }

                        return opt_ver + opt_editar;

                    },
                },

                {
                    width: '280px',
                    targets: -2,
                    title: 'Estatus',
                    orderable: true,
                    render: function(data, type, full, meta) {
                        let label = '';
                        switch (full.solicitud_estatus_id) {
                            case 1:
                                label ='warning';
                                break;
                            case 2:
                                label ='success';
                                break;
                            case 6:
                                label ='danger';
                                break;
                            case 3:
                                label ='primary';
                                break;
                        
                            default:
                                break;
                        }
                        var estatus =  `
                        <span class="label label-lg label-light-`+label+` label-inline">`+full.solicitud_estatus+`</span>
                        `;
                        return estatus;

                    },
                },
                {
                    targets: -6,
                    orderable: true,
                    render: function(data, type, full, meta) {
                        return full.solicitud_tipo;
                    },
                },
                {
                    targets: -4,
                    orderable: false,
                },
                {
                    targets: -2,
                    orderable: true,
                    render: function(data, type, full, meta) {
                        return full.solicitud_estatus;
                    },
                },

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
    };


    return {

        //main function to initiate the module
        init: function() {
            initTable1();
            initEvents();

            KTApp.initTooltips();
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
    }else{
        $("#card-busqueda").hide();
    }
});