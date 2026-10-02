"use strict";
var Modulo = function () {

    var tipo_vehiculo = ''; //lista de elementos
    var contadorDocumentos = 0; //indice contador de elementos
    var contadorFotografia = 0;
    var validador; //validador del formulario

    var validacion = function () {
        //validacion de formulario
        const form = document.getElementById('frmConversion');
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
        ).on('core.form.valid', function () {
            toastr.success("Guardando, Por favor Espere...");
        }).on('core.form.invalid', function () {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });

        $("#btnGuardar").click(function (e) {
            e.preventDefault();
            validador.validate().then(function (status) {
                if (status === 'Valid') {
                    var btnGuardar = document.getElementById('btnGuardar');
                    KTUtil.btnWait(btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });
    };

    var initFechaInput = function () {
        var arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }

        $('.datepicker').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });
    };

    var initEvents = function () {

        tipo_vehiculo = construyeElementosLista();
        //botón agregar otro archivo
        $(".hrefAgregarOtro").on("click", function (event) {
            event.preventDefault();
            addArchivo();
        });

        delArchivo();
        initSwalEliminarDdocumento();
    };

    //construye  elementos de la lista
    var construyeElementosLista = function () {
        var tipoArchivo = $("#requisicionGrupo").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";

        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + item.id + "' >" + item.descripcion + "</option>";
        });

        return opcion;
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
        html += (["",
            "<tr id='trDocumento" + contadorDocumentos + "'>",
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
            "          <select class='form-control' name='conversion[" + contadorDocumentos + "]' id='conversion" + contadorDocumentos + "' required>",
            "              <option value=''>Selecciona un opción</option>",
                            tipo_vehiculo,
            "          </select>",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='number' class='form-control cantidad' id='cantidad" + contadorDocumentos + "' name='cantidad[" + contadorDocumentos + "]' required />",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control fecha datepicker' id='fecha" + contadorDocumentos + "' name='fecha[" + contadorDocumentos + "]' required />",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='" + contadorDocumentos + "' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('archivo[' + contadorDocumentos + ']', archivoValidador);
        validador.addField('conversion[' + contadorDocumentos + ']', tipoArchivoValidador);
        validador.addField('cantidad[' + contadorDocumentos + ']', tipoArchivoValidador);
        validador.addField('fecha[' + contadorDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
        initFechaInput();
    };

    //elimina un elemento
    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminar", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo[' + idDocumento + ']');
            validador.removeField('conversion[' + idDocumento + ']');
            validador.removeField('cantidad[' + idDocumento + ']');
            validador.removeField('fecha[' + idDocumento + ']');
            $('#trDocumento' + idDocumento).remove();//elimina el elemento
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

    var eventosEspeciales = function () {
        $('#elemento1').val();
    };

    return {

        //main function to initiate the module
        init: function () {
            initEvents();
            validacion();
            eventosEspeciales();
        },

    };

}();

jQuery(document).ready(function () {
    Modulo.init();
});
