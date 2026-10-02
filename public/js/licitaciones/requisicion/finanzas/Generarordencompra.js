
"use strict";
var Modulo = function() {

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_user');
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
        $("#proveedor").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
        $("#forma_pago").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
        $("#metodo_pago").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#precio_unitario").inputmask('$ 999,999,999.99', {
            numericInput: true
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



$(function() {
  
  $('#proveedor').on('change', function() {

    let mSelect=$('option:selected', this);
    let opcion = mSelect.val();
    let Nombre = mSelect.data('nombre');
    let Contacto = mSelect.data('contacto');
    let Telefono = mSelect.data('telefono');
    let Correo = mSelect.data('correo');
    let Direccion = mSelect.data('direccion');
    let Rfc = mSelect.data('rfc');
    let Convenio = mSelect.data('convenio');
    
    $(".info_proveedor").show();
    document.getElementById("contacto_proveedor").innerHTML = Contacto;
    document.getElementById("telefono_proveedor").innerHTML = Telefono;
    document.getElementById("correo_proveedor").innerHTML = Correo;
    document.getElementById("direccion_proveedor").innerHTML = Direccion;
    document.getElementById("rfc_proveedor").innerHTML = Rfc;
    document.getElementById("convenio_proveedor").innerHTML = Convenio;

  });


  $(".limit-num").on('keyup',function(){
    var limit = $(this).attr('data-limit');
    var cons = $(this).attr('data-cons');
    var vlue = this.value;
    console.log(parseInt(limit));
    console.log(parseInt(vlue));

    if( parseInt(limit) < parseInt(vlue) || parseInt(vlue) < 0){
      Swal.fire("Verifica la cantidad agregada");
      document.getElementsByClassName("limit-num")[cons].value = "";
    }

  });

});

$(".eliminar-partida").click(function(){
    var id = $(this).attr('data-id');
    var nombre = $(this).attr('data-nombre');
    var orden = $(this).attr('data-orden');
    var requisicion = $(this).attr('data-requisicion');

    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_delete").value = id;
        document.getElementById("id_orden").value = orden;
        document.getElementById("id_requisicion").value = requisicion;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("partida_delete_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });


});


$("#kdatatable_unidades_req").DataTable({
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