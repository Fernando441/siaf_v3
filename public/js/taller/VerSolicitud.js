"use strict";
var VerSolicitud = function() {

    var validador; //validador del formulario Informacion Legal

    var validacion = function() {
        var toggleInformacionButton = document.getElementById('toggleInformacion');
        //obtenemos el formulario por su id      
        const form = document.getElementById('formAgendarcita');

        if (form) {
            validador = FormValidation.formValidation(
                form,
                {
                    locale: 'es_ES',
                    localization: FormValidation.locales.es_ES,
                    fields: {
                        fecha_cita: {
                            validators: {
                                notEmpty: {
                                    message: 'La fecha de la cita es requerida'
                                },
                            }
                        },
                        proveedor: {
                            validators: {
                                notEmpty: {
                                    message: 'El proveedor es requerido'
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
                        })
                    }
                }
            ).on('core.form.valid', function() {
                toastr.success("Solicitando, Por favor Espere...");
            }).on('core.form.invalid', function() {
                toastr.warning("Por favor, Ingrese la información marcada en rojo.");
                $('#informacion').hide();
                toggleInformacionButton.setAttribute('data-original-title', 'Mostrar información');
                KTUtil.scrollTop();
            });
        }

        //validar y enviar formulario
        $( "#btn-aceptar-solicitud" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('registrarSolicitud');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });

    };


    var toggleInformacion = function () {
        var toggleInformacionButton = document.getElementById("toggleInformacion");
        var informacion = document.getElementById("informacion");

        toggleInformacionButton.addEventListener("click", function () {
          $("#informacion").toggle();
          if (informacion.style.display === "none") {
            KTApp.hideTooltips();
            toggleInformacionButton.innerHTML = '<i class="fas fa-angle-down"></i>';
            toggleInformacionButton.setAttribute(
              "data-original-title",
              "Mostrar información"
            );
          } else {
            KTApp.hideTooltips();
            toggleInformacionButton.innerHTML = '<i class="fas fa-angle-up"></i>';
            toggleInformacionButton.setAttribute(
              "data-original-title",
              "Ocultar información"
            );
          }
        });
      };

    var initControls = function() {
        $('#kt_datetimepicker_1').datetimepicker(
            {
                minDate: moment(),
                locale: 'es',
            }
        );
        $('#solicitud_fecha_cita').on('focus', function() {
            $('#kt_datetimepicker_1').datetimepicker('show');
        });


    };


    return {

        init: function() {
            initControls();
            toggleInformacion();
            validacion();
        },

    };

}();

jQuery(document).ready(function() {
    VerSolicitud.init();
});



$("#btn-rechazar").click(function(){
    $("#rechazar-div").show();
     $("#select_ejecutivo").hide();
});


$("#btn-autorizar").click(function(){
    $("#rechazar-div").hide();
    $("#select_ejecutivo").show();
    
    // Swal.fire({
    //   title: "Estas seguro de enviar la solicitud",
    //   icon: "warning",
    //   showCancelButton: true,
    //   confirmButtonText: "Si, Enviar!",
    //   cancelButtonText: "No, Cancelar!",
    //   reverseButtons: true
    // }).then(function(result) {
    //   if (result.value) {
    //     Swal.fire({
    //       position: "top-center",
    //       icon: "success",
    //       title: "Espere un momento, la información esta siendo procesada",
    //       showConfirmButton: false
    //     });
    //     document.getElementById("validar_form").submit();
    //   } else if (result.dismiss === "cancel") {
    //     Swal.fire(
    //       "Cancelada",
    //       "La acción fue cancelada",
    //       "error"
    //     )
    //   }
    // });

});


    $("#btn-rechazar-form").click(function () {
        var motivo = document.getElementById("motivo").value;
        if (motivo == "") {
            Swal.fire("Para continuar debes agregar el motivo por el cual rechazas la solicitud");
        } else {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("rechazar_form").submit();
        }
    });



    $("#uno_select").click(function(){
        
        Swal.fire({
          title: "Estas seguro de enviar la solicitud al ejecutivo de mantenimiento seleccionado?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Si, Enviar!",
          cancelButtonText: "No, Cancelar!",
          reverseButtons: true
        }).then(function(result) {
          if (result.value) {
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: "Espere un momento, la información esta siendo procesada",
              showConfirmButton: false
            });
            document.getElementById("select_ejecutivo_uno").submit();
          } else if (result.dismiss === "cancel") {
            Swal.fire(
              "Cancelada",
              "La acción fue cancelada",
              "error"
            )
          }
        });

    });

    

    $("#uno_aleatorio").click(function(){
        
        Swal.fire({
          title: "El ejecutivo de cuenta se asignara aleatoriamente a la solicitud",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Si, Enviar!",
          cancelButtonText: "No, Cancelar!",
          reverseButtons: true
        }).then(function(result) {
          if (result.value) {
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: "Espere un momento, la información esta siendo procesada",
              showConfirmButton: false
            });
            document.getElementById("validar_form").submit();
          } else if (result.dismiss === "cancel") {
            Swal.fire(
              "Cancelada",
              "La acción fue cancelada",
              "error"
            )
          }
        });

    });


$("#kdatatable_mantenimientos").DataTable({
    language: {
        'lengthMenu': 'Display _MENU_',
        "url": $('#datatable_i18n').val()
    },

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