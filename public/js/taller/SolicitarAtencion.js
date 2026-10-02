"use strict";
var SolicitarAtencion = (function () {
  //validadores de los formularios
  var validador;

  var validacion = function () {
    var toggleInformacionButton = document.getElementById("toggleInformacion");
    //obtenemos el formulario por su id
    const form = document.getElementById("solicitaratencion");

    //validador de formulario
    validador = FormValidation.formValidation(form, {
      locale: "es_ES",
      localization: FormValidation.locales.es_ES,
      fields: {
        tiposolicitud: {
          validators: {
            notEmpty: {
              message:
                "Seleccione el tipo de solicitud de atención que desea realizar",
            },
          },
        },
        kilometraje: {
          validators: {
            notEmpty: {
              message: "El kilometraje es requerido",
            },
            numeric: {
              message: "El kilometraje debe ser un número",
            },
          },
        },
        observaciones: {
          validators: {
            notEmpty: {
              message: "Las observaciones son requeridas",
            },
            stringLength: {
              max: 800,
              message: "Las observaciones no pueden exceder los 800 caracteres",
            },
          },
        },
        domicilio: {
          validators: {
            notEmpty: {
              message: "El domicilio es requerido",
            },
          },
        },
        codigopostal: {
          validators: {
            notEmpty: {
              message: "El código postal es requerido",
            },
            stringLength: {
              min: 5,
              max: 5,
              message: "El código postal debe tener 5 caracteres",
            },
            numeric: {
              message: "El código postal debe ser un número",
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
          //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
          //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
        }),
      },
    })
      .on("core.form.valid", function () {
        toastr.success("Solicitando, Por favor Espere...");
      })
      .on("core.form.invalid", function () {
        toastr.warning("Por favor, Ingrese la información marcada en rojo.");
        $("#informacion").hide();
        toggleInformacionButton.setAttribute(
          "data-original-title",
          "Mostrar información"
        );
        KTUtil.scrollTop();
      });

    //validar y enviar formulario
    $("#registrarSolicitud").click(function (e) {
      e.preventDefault();
      validador.validate().then(function (status) {
        if (status === "Valid") {
          var btnGuardar = document.getElementById("registrarSolicitud");
          KTUtil.btnWait(
            btnGuardar,
            "spinner spinner-right spinner-white pr-15",
            "Espere...",
            true
          );
          form.submit();
        }
      });
    });
  };


  var toggleInformacion = function () {
    var toggleInformacionButton = document.getElementById("toggleInformacion");
    var informacion = document.getElementById("informacion");
    //toggle informacion div when toggleInformacionButton is clicked
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

  return {
    //main function to initiate the module
    init: function () {
      validacion();
      toggleInformacion();
    },
  };
})();

jQuery(document).ready(function () {
  SolicitarAtencion.init();
});
