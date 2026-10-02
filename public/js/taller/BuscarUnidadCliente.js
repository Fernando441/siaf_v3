"use strict";
var BuscarUnidad = function() {

    //validadores de los formularios
    var validador; //validador del formulario Informacion Legal

    var validacion = function() {
        //obtenemos el formulario por su id      
        const form = document.getElementById('buscarunidad');

        //validador de formulario
        validador = FormValidation.formValidation(
            form,
            {
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
                fields: {
                    no_serie: {
                        validators: {
                            notEmpty: {
                                message: 'El número de serie es requerido'
                            }
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
                    })
                }
            }
        ).on('core.form.valid', function() {
            toastr.success("Buscando, Por favor Espere...");
        }).on('core.form.invalid', function() {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });



        //validar y enviar formulario
        $( "#buttonBuscarUnidad" ).click(function( e ) {
            e.preventDefault();

            let input_servicio = $('#servicio').val();

            if(input_servicio == '' || input_servicio == null || input_servicio == undefined){
                toastr.warning("Por favor, Seleccione un servicio.");
                return false;
            }

            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('buttonBuscarUnidad');
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
    BuscarUnidad.init();
});

