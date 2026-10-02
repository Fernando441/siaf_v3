"use strict";

// Class definition
var KTWizard3 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];
    var table;

	// Private functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}
            if (wizard.getNewStep() == 2) {
                table.ajax.reload();
            }

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						wizard.goTo(wizard.getNewStep());
						KTUtil.scrollTop();
					} else {
						toastr.warning("Por favor, Ingrese la información marcada en rojo.");
                        KTUtil.scrollTop();
					}
				});



			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Changed event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
			// Validate form before submit
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
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
		));

		jQuery(document).on("click", ".btnGuardar" , function(e) {
            var msgVehiculos = $('#msgVehiculos');
            if(validacionVehiculos()) {
                msgVehiculos.html('');
                var btnGuardar = document.getElementById('btnGuardar');
                KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                _formEl.submit(); // submit form
            }else {
                msgVehiculos.html('Por Favor, al menos seleccione un vehículo');
                toastr.warning("Por favor, Ingrese la información marcada en rojo.y");
                KTUtil.scrollTop();
            }
        });
	}


    var validacionVehiculos = function() {
            var total = jQuery(document).find('input[name="vehiculos[]"]:checked').length;
            if (total > 0) {
                return true;
            }
            return false;
    };


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
                        'placa', 'year', 'estatus', 'numero_economico', 'clave_vehicular', 'permisos' ,'acciones', 'id_unidad_asignacion'],
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

                        if (full.permisos.includes(9)){
                            opt_ver =`
                                <a href="/unidad/ver-unidad/`+full.id+`" class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" title="Ver unidad" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                        <i class="flaticon-eye"></i>
                                </a>
                            `;
                        }
                        opt_solicitud = `
                            <div class="checkbox-inline">
                                <label class="checkbox">
                                    <input type="checkbox" name="vehiculos[]" value="`+full.id+`" class="vehiculos" title="Seleccionar vehículo" data-theme="dark" data-toggle="tooltip" data-placement="top">
                                    <span></span>
                                </label>
                            </div>
                        `;

                        if (full.solicitud_activo == 1) {
                            opt_solicitud = `
                            <span class="label label-lg label-light-primary label-inline">Solicitud Activa</span>
                            `;
                        }

                        return opt_solicitud;

                    },
                },

                {
                    width: '280px',
                    targets: -4,
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
    };

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('wizard-solicitud');
			_formEl = KTUtil.getById('frmSolicitud');

			_initWizard();
            initTable1();
            initEvents();
			_initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard3.init();
});
