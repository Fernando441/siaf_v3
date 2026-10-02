"use strict";
var Modulo = function() {

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_segmento');
        var validador = FormValidation.formValidation(
            form,
            {
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
                fields: {
                    codigo_postal: {
                        validators: {
                            notEmpty: {
                            },
                            regexp: {
                                regexp: CP_MX_REGEXP,
                                message: CP_MX_MESSAGE,
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                        //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                    }),
                }
            }
        ).on('core.form.valid', function() {
            toastr.success("Guardando, Por favor Espere...");
        }).on('core.form.invalid', function() {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });

        $( "#btnGuardar" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });
    };

    var initEvents = function() {


        $("#tipo_vehiculo").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#puertas").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#carroceria").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#no_cilindros").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#cilindros").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#pasajeros").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#motor").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#llanta_refaccion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
        $("#potencia").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#transmision").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#radio").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#direccion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#blindaje").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#capacidad").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#gps").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#en_inventario").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });


    };

    return {

        //main function to initiate the module
        init: function() {
            initEvents();
            validacion();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});
