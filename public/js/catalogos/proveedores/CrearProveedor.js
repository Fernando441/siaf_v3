"use strict";
var Modulo = function() {

    var validacion = function() {

        const tk = document.getElementsByName('_token');

        //validacion de formulario
        const form = document.getElementById('submit_proveedor');
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

                    telefono: {
                        validators: {
                            notEmpty: {
                            },
                            regexp: {
                                regexp: TELEFONO_REGEXP,
                                message: TELEFONO_MESSAGE,
                            },
                        }
                    },
                    correo: {
                        validators: {
                            notEmpty: {
                            },
                            regexp: {
                                regexp: CORREO_REGEXP,
                                message: CORREO_MESSAGE,
                            },
                        }
                    },

                    rfc: {
                        message: 'Proveedor ya esta registrado',
                        validators: {
                            notEmpty: {
                            },
                            remote: {
                                data: {
                                    _token: tk[0].value,
                                },
                                message: 'El proveedor ya esta registrado en sistema, Por favor, verifique en catálogos de provedores activos e inactivos.',
                                method: 'POST',
                                url: 'check-proveedor',
                            },
                            stringLength: {
                                min: 13,
                                message: 'Por favor, Ingrese un RFC Valido.',
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //  eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                        //  eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                    }),
                    transformer: new FormValidation.plugins.Transformer({
                        rfc: {
                            notEmpty: function (field, element, validator) {
                                // Get the field value
                                const value = element.value;

                                // Remove the spaces from beginning and ending
                                return value.trim();
                            },
                        },
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

