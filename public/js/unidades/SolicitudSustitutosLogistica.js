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
                        'nombre_responsable', 'fecha', 'motivo', 'unidadbase', 'contrato', 'estado', 'municipio', 'estatus', 'permisos' ,'acciones'],
                },

            },
            columns: [
                { data: 'nombre_responsable', orderable: true },
                { data: 'fecha', orderable: true },
                { data: 'motivo', orderable: true },
                { data: 'unidadbase', orderable: true },
                { data: 'contrato', orderable: true },
                { data: 'estado', orderable: true },
                { data: 'municipio', orderable: true },
                { data: 'estatus', orderable: true },
                // { data: 'motivo', orderable: true },
                // { data: 'unidad_base', orderable: true },
                // { data: 'contrato' },
                // { data: 'nombre_responsable', orderable: true },
                // { data: 'id_estado', orderable: true },
                // { data: 'id_municipio', orderable: true },
                {data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {



                        if(full.estatus == 4){
                           return `
                                <a href="/unidad/ver-solicitud-sustitutos/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver solicitud" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>

                            `;   
                        }

                        if(full.estatus == 2 || full.estatus == 3){
                           return `
                                <a href="/unidad/ver-solicitud-sustitutos/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver solicitud" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>


                                <a href="/unidad/asignar-unidad-sustituta/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Agregar unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <i class="flaticon-file-1"></i>
                                </a>

                            `;
                        }


                    },
                },
                {
                    targets: -2,
                    responsivePriority: 2,
                    title: 'Estatus',
                    render: function(data, type, full, meta) {
                        var estado = full.estado;
                        estado = estado.toUpperCase();
                        // switch (estado) {
                        //     case '1':
                        //         return `<span style="color:black; background-color:#caf7c9;width:120px;" class="label label-lg font-weight-bold label-light-success label-inline">Solicitud creada</span>`;
                        //         break;
                        //     case 'ENVIADO A REVISIÓN':
                        //         return `<span class="label label-lg font-weight-bold label-light-warning label-inline">EN ESPERA DE CONFIRMACIÓN</span>`;
                        //         break;
                        //     case 'AUTORIZADO':
                        //         return `<span class="label label-lg font-weight-bold label-light-success label-inline">${estatus}</span>`;
                        //         break;
                        //     case 'RECHAZADO':
                        //         return `<span class="label label-lg font-weight-bold label-light-danger label-inline">${estatus}</span>`;
                        //         break;
                        //     case 'FINALIZADO':
                        //         return `<span class="label label-lg font-weight-bold label-dark label-inline">${estatus}</span>`;
                        //         break;

                        //     case 'ENVIADO PARA VALIDACIÓN':
                        //         return `<span class="label label-lg font-weight-bold label-light-warning label-inline">EN ESPERA DE CONFIRMACIÓN</span>`;
                        //         break;
                                
                        // }

                        if(full.estatus ==1){
                            return `<span style="color:black; background-color:#caf7c9;width:130px;" class="label label-lg font-weight-bold label-light-success label-inline">Solicitud creada</span>`;
                        }


                        if(full.estatus ==3){
                             return `<span style="color:black; background-color:#44ffe3 ;width:150px; height 35px;" class="label label-lg font-weight-bold label-light-success label-inline">Unidad sustituta asignada</span>`;
                        }

                        if(full.estatus ==4){
                            return `<span style="color:black; background-color:#20ff3b ;width:150px; height 36px;" class="label label-lg font-weight-bold label-light-success label-inline">Solicitud Finalizada</span>`;
                        }
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


