"use strict";

var validatorActividadDetalle;
// Class definition
var KTWizard3 = function () {
	// Base elements
	var _formEl;
	var _formElDetalle;
	var _validations = [];
    var table;
    var validatorActividadGeneral;
    var estatus;
 
	var _initValidation = function () {
	}

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
                        'placa', 'year', 'estatus', 'numero_economico', 'clave_vehicular', 'permisos' ,'acciones', 'id_unidad_asignacion'
                    ],
                    solicitud_id: document.getElementById('solicitud_id').value,
                    solicitud_ejecucion_id: document.getElementById('solicitud_ejecucion_id').value
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
                {data: 'acciones', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    width: '280px',
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var opt_ver = ``, opt_solicitud ="";

                        var actividadUnidadId = '';
                        if (full.actividad_unidad_id) {
                            actividadUnidadId = full.actividad_unidad_id;
                        }
                        opt_solicitud =`
                                <a href="javascript: void(0);" id="id_`+full.id+`" rel-unidad-id="`+full.id+`" rel-actividad-unidad-id="`+actividadUnidadId+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon modal-pdf" title="Ingresar IDGPS (ID de dispositivo GPS)" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                <i class="flaticon-edit-1"></i>
                                </a>
                                `;

                        return opt_solicitud;

                    },
                },

                {
                    width: '280px',
                    targets: -3,
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
            validatorActividadGeneral.validate().then(function (status) {
                if (status === "Valid") {
                    let modal = $("#modal_programar_actividad");
                    if (actividad_unidad_id) {
                        setDetalleActividad(actividad_unidad_id);
                    }
                    modal.modal("show");
                } 
            });
        });

    };

    var initEvents = function() {

        $('#kt_datetimepicker_9').datetimepicker({
            format: 'DD/MM/YYYY h:mm A'
        });

        $('#modal_programar_actividad').on('hidden.bs.modal', function (e) {
            clearFieldModal();
        });

        // frmProgramarActividad
        $("#btnGuardarContinuarDespues").on('click', function (e) {
            e.preventDefault();
            $('#opcion_guardar').val(2);

            validatorActividadGeneral.validate().then(function (status) {
                if (status === "Valid") {
                    var btnGuardar = document.getElementById('btnGuardarContinuarDespues');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    _formEl.submit(); 
                } 
            });

        });

        //btnGuardarFinalizar
        $("#btnGuardarFinalizar").on('click', function (e) {
            e.preventDefault();
            $('#opcion_guardar').val(1);

            ///int: check acitivities
            let solicitudId = $('#solicitud_id').val();
            $.ajax({
                url: "/solicitud/check-actividad/" + solicitudId,
                data: {
                    solicitud_id: solicitudId
                },
                type:'get',
                dataType:'json',
                'success': function (data) {
                    if (data.estatus == false) {
                        Swal.fire({
                            title: "Para continuar es necesario que ingrese todas las activides realizadas.",
                            icon: "warning",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#73ab17",
                            cancelButtonColor: "#cc0c73"
                        });
                    } else {
                        validatorActividadGeneral.validate().then(function (status) {
                            if (status === "Valid") {
                                var btnGuardar = document.getElementById('btnGuardarFinalizar');
                                KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                                _formEl.submit(); 
                            } 
                        });
                    }
                }
            });
            ///end: check acitivities


        });
    };

    var checkActivities = function(solicitudId) {
        
        $.ajax({
            url: "/solicitud/check-actividad/" + solicitudId,
            data: {
                solicitud_id: solicitudId
            },
            type:'get',
            dataType:'json',
            'success': function (data) {
                // console.log(data);
                return data;
            }
        });
        
        // return estatus;
    };

    
    function updateResult(data) {
        estatus = data;
    }

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

    var validateFormActividadDetalle = function() {
        validatorActividadDetalle = FormValidation.formValidation(
			_formElDetalle,
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
			_formEl = KTUtil.getById('frmProgramarActividad');
			_formElDetalle = KTUtil.getById('frmProgramarActividadDetalle');

            initTable1();
            initEvents();
			_initValidation();
            validateFormActividadGeneral();
            validateFormActividadDetalle();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard3.init();
});


$("#btnGuardarDetalle").on('click', function () {
    unAssign();
});

var unAssign = async () => {
    try{
        const result = await processAjaxRequest();
        toastr.success(result);
    }catch(err){
        toastr.error(err);
    }
}

var processAjaxRequest = () => {
    return new Promise((res,rej)=>{
        return validatorActividadDetalle.validate().then(function (status) {
            console.log(status);
            if (status === "Valid") {
                let unidad_id = $("#unidad_id").val();
                $.ajax({
                    url: $('#guardar_detalle_path').val(),
                    data: {
                        idgps: $('#idgps').val(),
                        comentarios: $('#comentarios_detalle').val(),
                        solicitud_id: $('#solicitud_id').val(),
                        unidad_id: unidad_id,
                        nombre_tecnico: $('#nombre_tecnico').val(),
                        fecha_actividad: $('#fecha_actividad').val(),
                        _token: $("[name='_token']").val()
                    },
                    type:'post',
                    dataType:'json',
                    beforeSend: function() {
                        toastr.warning("Por favor Espere...");
                        const btnGuardar = $('#btnGuardarDetalle');
                        btnGuardar.addClass('spinner spinner-right spinner-white pr-15');
                        btnGuardar.prop('disabled', true);
                    },
                    success : response => {
                        if(response.estatus){
                            toastr.success("La actividad se guardo correctamente.");
                            var modal = $("#modal_programar_actividad");
                            modal.modal("hide");
                            $("#id_"+unidad_id).attr('rel-actividad-unidad-id', response.actividad_unidad_id);
                            $("#solicitud_ejecucion_id").val(response.solicitud_ejecucion_id);
                            clearFieldModal();
                        }else{
                            toastr.error("No es posible guardar la actividad, por favor intente más tarde.");
                        }
                    }
                });
            } 
        });

    });
}

var clearFieldModal = function () {
    $('#idgps').val('');    
    $('#comentarios_detalle').val('');    
    const btnGuardar = $('#btnGuardarDetalle');
    btnGuardar.removeClass('spinner spinner-right spinner-white pr-15');
    btnGuardar.prop('disabled', false);
}

var setFieldModal = function (idgps, comentarios) {
    $('#idgps').val(idgps);    
    $('#comentarios_detalle').val(comentarios);    
}

var setDetalleActividad = function(actividadUnidadId) {
    $.ajax({
        url: "/solicitud/detalle-actividad/" + actividadUnidadId,
        data: {
            actividad_unidad_id: actividadUnidadId
        },
        type:'get',
        dataType:'json',
        success : response => {
            if(response.estatus){
                setFieldModal(response.idgps, response.comentarios);
            }else{
                toastr.error("No es posible obtener la actividad, por favor intente más tarde.");
            }
        }
    });
}