"use strict";

Dropzone.autoDiscover = false;

// Class definition
var KTWizard3 = function () {
	// Base elements
	var _formEl;
    var table;
    var validatorActividadGeneral;

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTable1 = function() {
            table = $('#tabla-vehiculos').DataTable({
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
                url:$('#unidaddatatable').val(),
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    columnsDef: [
                        'folio', 'id_ubicacion', 'contrato','marca', 'modelo', 'serie',
                        'placa', 'year', 'estatus', 'numero_economico', 'clave_vehicular', 'permisos' ,'acciones', 'id_unidad_asignacion', 'actividad_unidad_idgps'
                    ],
                    solicitud_id: document.getElementById('solicitud_id').value,
                    solicitud_ejecucion_id: document.getElementById('solicitud_ejecucion_id').value
                },

            },
            columns: [
                { data: 'folio' },
                { data: 'id_marca' },
                { data: 'id_modelo' },
                { data: 'no_serie' },
                { data: 'placa' },
                { data: 'unidad_year' },
                { data: 'actividad_unidad_idgps' },
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
                        var opt_archivo = ``, opt_solicitud ="";

                        var actividadUnidadId = '';
                        if (full.actividad_unidad_id) {
                            actividadUnidadId = full.actividad_unidad_id;
                        }
                        opt_solicitud =`
                                <a href="javascript: void(0);" id="id_`+full.id+`" rel-unidad-id="`+full.id+`" rel-actividad-unidad-id="`+actividadUnidadId+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ver Actividad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-eye"></i>
                                </a>
                                `;

                        return opt_solicitud;

                    },
                },

                {
                    width: '100px',
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
                modalPDF();
            }

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

    var modalPDF = function() {

        $(".modal-pdf").on('click', function () {
            var unidad_id = $(this).attr('rel-unidad-id');
            var actividad_unidad_id = $(this).attr('rel-actividad-unidad-id');
            $("#unidad_id").val(unidad_id);
            let modal = $("#modal_programar_actividad");
            if (actividad_unidad_id) {
                setDetalleActividad(actividad_unidad_id);
                $('#actividad-unidad-id').val(actividad_unidad_id);
            }
            modal.modal("show");
        });

    };

    var initEvents = function() {

        $('#modal_programar_actividad').on('hidden.bs.modal', function (e) {
            clearFieldModal();
        });

        

    };

    

	return {
		// public functions
		init: function () {
            initTable1();
            initEvents();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard3.init();
});

var clearFieldModal = function () {
    $('#idgps').val('');    
    $('#comentarios_detalle').val('');    
    $('#actividad-unidad-id').val('');
}

var setFieldModal = function (idgps, comentarios, solicitud_documentos) {
    $('#idgps').html(idgps);    
    $('#comentarios_detalle').html(comentarios); 
    let actividadUnidadId = $('#actividad-unidad-id').val(); 
    setFilesView(solicitud_documentos);
    
}

var setDetalleActividad = function(actividadUnidadId) {
    $.ajax({
        url: "/solicitud/detalle-actividad/" + actividadUnidadId,
        data: {
            actividad_unidad_id: actividadUnidadId
        },
        type:'get',
        dataType:'json',
        success : function(response){
            if(response.estatus){
                setFieldModal(response.idgps, response.comentarios, response.solicitud_documentos);
            }else{
                toastr.error("No es posible obtener la actividad, por favor intente más tarde.");
            }
        }
    });
}

var setFilesView = function(data) {

    var requisitos_html = '';

    if (data.length>0){
        data.forEach(function(elemento) {

            requisitos_html += ([    "" +
                "<div class='dropzone-item dz-complete dz-image-preview' style=''>",
                "    <div class='dropzone-file'>",
                "        <div class='dropzone-filename' title='"+elemento.documento+"'>",
                "            <span data-dz-name=''>",
                "                <a href='/solicitud/validacion-archivo-ver/"+elemento.id+"' target='_blank' title='Ver Archivo' data-theme='dark' data-toggle='tooltip' data-placement='top'>",
                    elemento.documento,
                "                </a>",
                "            </span>",
                "            <strong>",
                "                (",
                "                <span data-dz-size=''>",
                "                <strong>"+formatBytes(elemento.size)+"</strong>",
                "                </span>",
                "                )",
                "            </strong>",
                "        </div>",
                "    </div>",
                "    <div class='dropzone-progress'><div class='progress' style='opacity: 0;'></div></div>",
                "    <div class='dropzone-toolbar'></div>", 
                "</div>",
                ""].join(""));

        });

        $("#dropzone-items").html('');
        $("#dropzone-items").append(requisitos_html);
    }

};

function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
}