"use strict";
var serviciosSolicitados = function() {

    var initControls = function() {
        $('#kt_datepicker_1').datepicker();
    }
    
    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
        // begin first table
        var table = $('#tblSolicitudes').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            // read more: https://datatables.net/examples/basic_init/dom.html

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },

            processing: true,
            serverSide: true,
            
            ajax: {
                url:$('#solicitudesdatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'id', 'fecha_solicitud', 'no_serie',  'tipo', 'concepto',  'estado', 'acciones', 'id_proceso', 'op_taller', 'op_validacion'
                    ],
                },
                

            },
            order: [[1, 'desc']],
            columns: [
                { data: 'id', orderable: true},
                { data: 'fecha_solicitud', orderable: true },
                { data: 'no_serie' },
                // { data: 'prioridad', orderable: true },
                { data: 'tipo', orderable: true },
                { data: 'concepto' },
                // { data: 'client', orderable: false },
                { data: 'estado', orderable: true },
                { data: 'acciones', responsivePriority: -1},
            ],

            columnDefs: [
                {

                    width: '110px',
                    targets: -1,
                    title: 'Opciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var url = $('#verSolicitud').val().replace(/\/\d+$/, '');
                        var documentosSolicitud = $('#documentosSolicitud').val().replace(/\/\d+$/, '');
                        var editarSolicitudUrl = $('#editarSolicitud').val().replace(/\/\d+$/, '');
                        var asignartallerSolicitudUrl = $('#asignarTallerSolicitud').val().replace(/\/\d+$/, '');
                        //button toolvar to view, edit and upload files
                        var opt_ver = ``; var opt_taller = ``; var opt_editar= ``; var opt_documentos = ``; var opt_enviar = `` ;
                        if(full.id_proceso == 0 && full.op_taller == 0 && full.estado == 'PENDIENTE'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_editar =`
                                    <a href="${editarSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_documentos =`
                                    <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Documentos de la solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                `;
                        }


                        if(full.id_proceso == 0 && full.op_taller == 1 && full.estado == 'PENDIENTE'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_editar =`
                                    <a href="${editarSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_documentos =`
                                    <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Documentos de la solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                `;
                                

                                opt_enviar =`
                                    <a  class="finanzasMantenimiento btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Enviar a revisión" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="`+full.id+`">
                                            <i class="flaticon2-delivery-truck"></i>
                                    </a>
                                `;

                        }

                        if(full.id_proceso == 1 && full.estado == 'AUTORIZADO'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_documentos =`
                                    <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Documentos de la solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                `;

                        }

                        if(full.id_proceso == 0 && full.op_taller == 1 && full.estado == 'RECHAZADO'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_editar =`
                                    <a href="${editarSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_documentos =`
                                    <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Documentos de la solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                `;

                                opt_enviar =`
                                    <a  class="finanzasMantenimiento btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Enviar a revisión" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="`+full.id+`">
                                            <i class="flaticon2-delivery-truck"></i>
                                    </a>
                                `;
                        }

                        if(full.id_proceso == 0 && full.op_taller == 0 && full.estado == 'RECHAZADO'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_editar =`
                                    <a href="${editarSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Editar solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_enviar =`
                                    <a  class="finanzasMantenimiento btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Enviar a revisión" data-theme="dark" data-toggle="tooltip" data-placement="top" data-id="`+full.id+`">
                                            <i class="flaticon2-delivery-truck"></i>
                                    </a>
                                `;
                        }

                        if(full.id_proceso == 1 && full.estado == 'ENVIADO A REVISIÓN'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                        }

                        if(full.id_proceso == 2 && full.estado == 'EN TALLER'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                        }

                        if(full.id_proceso == 0 && full.estado == 'AUTORIZADO'){
                                opt_ver =`
                                    <a href="${url}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" data-theme="dark" title="Ver solicitud" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                    </a>
                                `;

                                opt_taller =`
                                    <a href="${asignartallerSolicitudUrl}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Información del taller" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon2-gear"></i>
                                    </a>
                                `;

                                opt_documentos =`
                                    <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Documentos de la solicitud" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                `;

                                // opt_evaluar =`
                                //     <a href="${documentosSolicitud}/${full.id}" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Evaluar taller" data-toggle="tooltip" data-placement="top" data-theme="dark">
                                //         <i class="flaticon-attachment"></i>
                                //     </a>
                                // `;

                        }


                        return opt_ver + opt_taller + opt_editar + opt_documentos + opt_enviar;
                    },
                },
                {
                    targets: -2,
                    responsivePriority: 2,
                    title: 'Estatus',
                    render: function(data, type, full, meta) {
                        var estado = full.estado;
                        estado = estado.toUpperCase();
                        switch (estado) {
                            case 'PENDIENTE':
                                return `<span style="color:black; background-color:#caf7c9;width:120px;" class="label label-lg font-weight-bold label-light-success label-inline">${estado}</span>`;
                                break;
                            case 'ENVIADO A REVISIÓN':
                                return `<span class="label label-lg font-weight-bold label-light-warning label-inline">${estado}</span>`;
                                break;
                            case 'AUTORIZADO':
                                return `<span class="label label-lg font-weight-bold label-light-success label-inline">${estado}</span>`;
                                break;
                            case 'RECHAZADO':
                                return `<span class="label label-lg font-weight-bold label-light-danger label-inline">${estado}</span>`;
                                break;
                            case 'FINALIZADO':
                                return `<span class="label label-lg font-weight-bold label-dark label-inline">${estado}</span>`;
                                break;
                            case 'EN TALLER':
                                return `<span class="label label-lg font-weight-bold label-light-warning label-inline">${estado}</span>`;
                                break;
                        }
                    },
                },
                {
                    // targets: -3,
                    // title: 'Cliente',
                },
                {
                    targets: 1,
                    title: 'Fecha de solicitud',
                    render: function(data, type, full, meta) {
                        var date = new Date(full.fecha_solicitud);
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours ? hours : 12;
                        minutes = minutes < 10 ? '0'+minutes : minutes;
                        var strTime = hours + ':' + minutes + ' ' + ampm;
                        return date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear() + " " + strTime;
                    },
                },
                {
                    targets: 3,
                    title: 'Prioridad',
                    render: function(data, type, full, meta) {
                            if( full.prioridad == 0){
                                return `<span class="label label-lg font-weight-bold label-light-danger label-inline">ALTA</span>`;
                            }

                            if( full.prioridad == 1){
                                return `<span class="label label-lg font-weight-bold label-light-warning label-inline">MEDIA</span>`;
                            }


                            if( full.prioridad == 2){
                                return `<span class="label label-lg font-weight-bold label-light-success label-inline">BAJA</span>`;
                            }

                    },
                },
                {
                    targets: 4,
                    title: 'Tipo',
                    render: function(data, type, full, meta) {
                        if (full.tipo == null) {
                            return '';
                        }
                        return full.tipo.toUpperCase();
                    },
                },
                {
                    targets: 2,
                    title: 'No. serie',
                    render: function(data, type, full, meta) {
                        return `${full.no_serie}`;
                    },
                },  

            ],


            "drawCallback": function(settings, json) {
                KTApp.initTooltips();
                 initSwalFinanzas();
            },
            buttons: [
                {extend: "excel", className: "invisible"},
                {extend: "csv", className: "invisible"},
                {extend: "print", className: "invisible"},
            ],


        }).on('init.dt', function () {
        });

        $('#export-excel').on('click', function () {
            table.button(0).trigger();
        });
        $('#export-csv').on('click', function () {
            table.button(1).trigger();
        });
        $('#export-print').on('click', function () {
            table.button(2).trigger();
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


    var initSwalFinanzas = function() {
        $(".finanzasMantenimiento").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Estas seguro de enviar a revisión?.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Enviar!",
                cancelButtonText: "No, Cancelar!",
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: $('#finanzassolicitudurl').val(),
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Solicitud enviada a revisión.",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(function(result) {
                                    if (result.value) {
                                        $('#tblSolicitudes').DataTable().ajax.reload();
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

        //main function to initiate the module
        init: function() {
            initTable1();
            initSwalFinanzas();
        },

    };

}();

jQuery(document).ready(function() {
    serviciosSolicitados.init();
});