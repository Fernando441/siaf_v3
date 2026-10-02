"use strict";
var Modulo = function() {

    var validador; //validador del formulario
    var validadorRequired; //validador del formulario

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('frmApartadosEditar');
        validadorRequired = FormValidation.formValidation(
            form,
            {
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
                fields: {
                    dias_apartado: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            },
                            min: {
                                value: 0,
                                message: 'El número minimo es 0'
                            },
                            max: {
                                value: 365,
                                message: 'El número máximo es 365'
                            }


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
                    })
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
            validadorRequired.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });
    };
 
    return {

        //main function to initiate the module
        init: function() {
            validacion();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});

