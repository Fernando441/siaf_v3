"use strict";
var Modulo = function() {

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_proposicion');
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
                        //  eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                        //  eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                    }),
                }
            }
        ).on('core.form.valid', function() {
            toastr.success("Guardando, Por favor Espere...");
        }).on('core.form.invalid', function() {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });

        
        const dataTable = $("#kdatatable_proposicion_economica").DataTable({
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val(),
        
            },
            lengthMenu: [
                [100],
                [100],
            ],
        
        
            "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +
        
            "<'table-responsive'tr>" +
        
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
        });
        
        $( "#btnGuardar" ).click(function( e ) {
            e.preventDefault();
            
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    dataTable.search('').draw();
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




$("#pre_diario").click(function(){
    // alert("Precio iario");
    $("#div_precio_mensual").hide();
    $("#div_precio_anual").hide();
    $("#div_precio_diario").show();
});

$("#pre_mensual").click(function(){
    // alert("Precio iario");
    $("#div_precio_diario").hide();
    $("#div_precio_anual").hide();
    $("#div_precio_mensual").show();
});

$("#pre_anual").click(function(){
    // alert("Precio iario");
    $("#div_precio_mensual").hide();
    $("#div_precio_diario").hide();
    $("#div_precio_anual").show();
});