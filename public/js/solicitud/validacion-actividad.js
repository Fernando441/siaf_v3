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
            table = $('#kt_datatable_example_1').DataTable({
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
                                <a href="javascript: void(0);" id="id_`+full.id+`" rel-unidad-id="`+full.id+`" rel-actividad-unidad-id="`+actividadUnidadId+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Validar Actividad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-edit-1"></i>
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

        // frmProgramarActividad
        $("#btn_rechazar").on('click', function (e) {
            e.preventDefault();
            $('#opcion_guardar').val(2);

            validatorActividadGeneral.validate().then(function (status) {
                if (status === "Valid") {
                    var btnGuardar = document.getElementById('btn_rechazar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    _formEl.submit(); 
                } 
            });

        });

        //btnGuardarFinalizar
        $("#btnGuardarFinalizar").on('click', function (e) {
            e.preventDefault();
            $('#opcion_guardar').val(1);
            validatorActividadGeneral.validate().then(function (status) {
                if (status === "Valid") {
                    var btnGuardar = document.getElementById('btnGuardarFinalizar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    _formEl.submit(); 
                } 
            });
        });

    };

    var validateFormActividadGeneral = function() {
        validatorActividadGeneral = FormValidation.formValidation(
			_formEl,
			{
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
				fields: {
               
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		).on("core.form.invalid", function () {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });
    };

	return {
		// public functions
		init: function () {
            _formEl = KTUtil.getById('frm-solicitud-validacion');
            
            initTable1();
            initEvents();
            validateFormActividadGeneral();
		}
	};
}();

var dropZone = function (id, actividadUnidadId) {

    var previewNode = $(id + " .dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parent('.dropzone-items').html();
    previewNode.remove();

    let options = {
        url: "/solicitud/validacion-archivo", // Set the url for your upload script location
        parallelUploads: 3,
        maxFiles: 10,
        maxFilesize: 500, // Max filesize in MB
        previewTemplate: previewTemplate,
        previewsContainer: id + " .dropzone-items", // Define the container to display the previews
        clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
        timeout: 10800000,
        params: {
            solicitud_id: $('#solicitud_id').val(),
            _token: $("[name='_token']").val()
        },
        dictMaxFilesExceeded: "Solo se permite adjuntar 10 archivos por cada actividad.",
        init: function() {
            this.on("sending", function(file, xhr, formData) {
              formData.append("actividad_unidad_id", $('#actividad-unidad-id').val());
            });
        },
        thumbnailWidth:"250",
        thumbnailHeight:"250",
        maxThumbnailFilesize: 20,
    };

    var myDropzone5;
    Dropzone.autoDiscover = false;
    let dropzoneInstance = document.querySelector(id);
    if (dropzoneInstance.dropzone) {
        dropzoneInstance.dropzone.options.params['solicitud_id'] = $('#solicitud_id').val();
        dropzoneInstance.dropzone.options.params['actividad_unidad_id'] = $('#actividad-unidad-id').val();
        dropzoneInstance.dropzone.options.params['_token'] = $("[name='_token']").val();
        myDropzone5 = dropzoneInstance.dropzone;
    }else{
        myDropzone5 = new Dropzone(id, options);
    }

    myDropzone5.on("addedfile", function(file) {
        $(document).find( id + ' .dropzone-item').css('display', '');
    });

    myDropzone5.on("totaluploadprogress", function(progress) {
        $( id + " .progress-bar").css('width', progress + "%");
    });

    myDropzone5.on("sending", function(file) {
        $( id + " .progress-bar").css('opacity', "1");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone5.on("complete", function(file) {
        var thisProgressBar = id + " .dz-complete";
        setTimeout(function(){
            $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").css('opacity', '0');
        }, 300);
    });

    myDropzone5.on("success", function(file, response) {
        file.archivo_id = response.solicitud_documento_id;
    });

    myDropzone5.on("removedfile", function(file) {
        var ruta = "/solicitud/validacion-archivo-eliminar";
        $.ajax({
            type: "DELETE",
            url: ruta,
            dataType:'json',
            data: {
                'id': file.archivo_id,
                _token: $("[name='_token']").val()
            },
            success : function(response){
            }
        });
    });

    $.getJSON('/solicitud/validacion-archivo-listar/' + actividadUnidadId, function(data) {
        $.each(data, function(index, val) {
        
        let mockFile = { archivo_id: val.id, name: val.documento, size: val.size };
        myDropzone5.emit("addedfile", mockFile);
        myDropzone5.emit("thumbnail", mockFile, "solicitud/validacion-archivo-ver/" + val.actividad_unidad_id);
        myDropzone5.emit("complete", mockFile);
        });
    });

};

jQuery(document).ready(function () {
	KTWizard3.init();
});

var clearFieldModal = function () {
    $('#idgps').val('');    
    $('#comentarios_detalle').val('');    
    $('#actividad-unidad-id').val('');
}

var setFieldModal = function (idgps, comentarios) {
    $('#idgps').html(idgps);    
    $('#comentarios_detalle').html(comentarios); 
    let actividadUnidadId = $('#actividad-unidad-id').val(); 
    dropZone('#dropzone-validacion', actividadUnidadId);   
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
                setFieldModal(response.idgps, response.comentarios);
            }else{
                toastr.error("No es posible obtener la actividad, por favor intente más tarde.");
            }
        }
    });
}