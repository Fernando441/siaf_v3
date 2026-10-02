"use strict";
var Modulo = function() {

    var validador; //validador del formulario
    var validadorRequired; //validador del formulario
    var contadorDocumentos=0; //indice contador de elementos


    var initEvents = function() {

        var arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>',
        };
        
        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });
        delArchivo();

        $("#fecha_pago").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_entrega").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });
        
        $("#fecha_registro_venta").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });
        
        $("#fecha_venta").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#pedido_fecha").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        initSwalEliminarDdocumento();

        document.getElementById('precio_venta').addEventListener('input', calcularMedia);
        document.getElementById('compra').addEventListener('input', calcularMedia);

        document.getElementById('compra').addEventListener('input', calcularAutometrica);
        document.getElementById('ajustes_sobre_valor').addEventListener('input', calcularAutometrica);

        document.getElementById('ajustes_conversion').addEventListener('input', calcularPrecioConversion);
        document.getElementById('conversion').addEventListener('input', calcularPrecioConversion);

        document.getElementById('conversion').addEventListener('input', calcularPrecioVentaFinal);

        documentosRequeridos();
    };

    var calcularMedia = function() {
        document.getElementById('media').value = (
            (parseFloat(document.getElementById('precio_venta').value) || 0) +
            (parseFloat(document.getElementById('compra').value) || 0)
        ) / 2;
    }
    var calcularAutometrica = function() {
        document.getElementById('autometrica').value = (
            (parseFloat(document.getElementById('compra').value) || 0) +
            ((parseFloat(document.getElementById('compra').value) || 0) * ((parseFloat(document.getElementById('ajustes_sobre_valor').value) || 0) / 100) )
        );
    }

    var calcularPrecioConversion = function() {
        document.getElementById('conversion_ajuste').value = (
            (((parseFloat(document.getElementById('ajustes_conversion').value) || 0) /100 ) * (parseFloat(document.getElementById('conversion').value) || 0) )
        );
    }

    var calcularPrecioVentaFinal = function() {
        document.getElementById('venta_final').value = (
            (parseFloat(document.getElementById('autometrica').value) || 0) +
            (parseFloat(document.getElementById('conversion_ajuste').value) || 0)
        );
    }

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('vender_unidad');
        validador = FormValidation.formValidation(
            form,
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

        validadorRequired = FormValidation.formValidation(
            form,
            {
                locale: 'es_ES',
                localization: FormValidation.locales.es_ES,
                fields: {
                    placas: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    gps: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    apartado: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    confirmacion: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    precio_mercado: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    precio_venta: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    fecha_pago: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    fecha_entrega: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    fecha_registro_venta: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    fecha_venta: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    numero_factura: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    vendedor_unidad: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    nombre_cliente: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    direccion_cliente: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    identificacion_cliente: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    rfc: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    tipo_persona: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },

                    compra: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    media: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    ajutes_sobre_valor: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    autometrica: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    ajuste_conversion: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    conversion: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    conversion_ajuste: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    venta_final: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    cedula_fiscal: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    ine_vigente: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
                            }
                        },
                    },
                    comprobante_pago: {
                        validators: {
                            notEmpty: {
                                message: 'Esta opción es requerida',
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
            document.getElementById('opcion_guardar').value = 1;
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardar');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });


        $( "#btnVender" ).click(function( e ) {
            e.preventDefault();
            document.getElementById('opcion_guardar').value = 2;
            validadorRequired.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnVender = document.getElementById('btnVender');
                    KTUtil.btnWait( btnVender, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });
    };
 
    //validador de elementos agregados para archivo
    const archivoValidador = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
            file: {
                extension: 'jpeg,jpg,png,pdf,docx,xls,gif,ppt,bmp',
                type: 'image/jpeg,image/png,application/pdf,application/msword,application/vnd.ms-excel,image/gif,application/vnd.ms-powerpoint,image/x-ms-bmp',
                message: 'Por favor ingrese un archivo válido, solo se permite imágenes, archivos de office y PDF',
            },
        },
    };

    //validador de elementos agregados para archivo
    const tipoArchivoValidador = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
        },
    };

    //agrega el elemento archivo y lista desplegable
    var addArchivo = function () {
        contadorDocumentos++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumento"+contadorDocumentos+"'>",
            "    <td>",
            "        <div class='form-group mb-0'>",
            "           <div class='custom-file'>",
            "               <input type='file' class='custom-file-input' id='archivo"+contadorDocumentos+"' name='archivo["+contadorDocumentos+"]' required />",
            "               <label class='custom-file-label' for='archivo"+contadorDocumentos+"'>Selecciona un archivo</label>",
            "           </div>",
            "        </div>",
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <input type='text' class='form-control' name='archivo_descripcion["+contadorDocumentos+"]' id='archivo_descripcion"+contadorDocumentos+"' required>",
            "          </input>",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='"+contadorDocumentos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('archivo[' + contadorDocumentos + ']', archivoValidador);
        validador.addField('archivo_descripcion[' + contadorDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };

    //elimina un elemento
    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminar" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo[' + idDocumento + ']');
            validador.removeField('archivo_descripcion[' + idDocumento + ']');
            $('#trDocumento'+idDocumento).remove();//elimina el elemento
        });
    };

     var initSwalEliminarDdocumento = function() {
        $(".hrefEliminarDocumentosCargados").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var documento = $(this).attr('data-documento');
            var block = $('#submit_contrato_edit');

            Swal.fire({
                title: "¿Desea eliminar el documento?.",
                text: documento,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Documento",
                cancelButtonText: "Cerrar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#eliminarDocumentoPath').val(),
                        data: {
                            id: id,
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function() {
                            KTApp.block(block, {
                                state: 'primary',
                                message: 'Espere por favor...'
                            });
                        }
                    }).done(function(data) {
                        KTApp.unblock(block);
                        if (data.estatus){
                            $('#trDocumentoCargados'+id).remove();//elimina el elemento html
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success("El documento se elimino correctamente.");

                        }else{
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.error("No es posible eliminar el documento, por favor intente más tarde.");
                        }
                    });
                }
            });
        });
    };

    var documentosRequeridos = function() {
        const tipoPersonas = document.getElementsByName('tipo_persona');
        const contenedor = document.getElementById('documentos_requeridos');

        tipoPersonas.forEach(tipoPersona => {
            tipoPersona.addEventListener('change', function() {
                if ((tipoPersona.value == 1 || tipoPersona.value == 2) && tipoPersona.checked) {
                    contenedor.style.visibility = 'visible';
                } else {
                    contenedor.style.visibility = 'hidden';
                }

                if (tipoPersona.value == 2 && tipoPersona.checked) {
                    const lblIn = document.getElementById('lbl_ine');
                    lblIn.textContent = 'INE vigente del representante legal';
                }

                if (tipoPersona.value == 1 && tipoPersona.checked) {
                    const lblIn = document.getElementById('lbl_ine');
                    lblIn.textContent = 'INE vigente';
                }
            });
        });
    };

    const validarInput = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
        },
    };

    return {

        //main function to initiate the module
        init: function() {
            validacion();
            initEvents();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});



