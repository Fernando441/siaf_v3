"use strict";
var Modulo = function() {

    var lista = ''; //lista de elementos
    var contadorDocumentos=0; //indice contador de elementos
    var validador; //validador del formulario

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('frmCliente');
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

        var arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }

        // $("#id_municipio").select2({
        //     placeholder: "Seleccione una opción",
        //     allowClear: true
        // });

        $("#id_estado").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        // lista = construyeElementosLista();
        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });
        delArchivo();

    };



    var initSwalEliminarDdocumento = function() {
        $(".hrefEliminarDocumento").click(function(e) {

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
                        url: $('#documentoEliminarPath').val(),
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
                            $('#trDocumento'+id).remove();//elimina el elemento html
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success("El documento se elimino correctamente.");
                            window.location.reload();

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




    var addArchivo = function () {
        contadorDocumentos++;
        var html = '';
        html += (`
            <tr id='trDocumento${contadorDocumentos}'>

                <td>
                    <div class='form-group mb-0'>
                       <div class='custom-file'>
                           <input type='file' class='custom-file-input' id='archivo[${contadorDocumentos}]' name='archivo[${contadorDocumentos}]' required />
                           <label class='custom-file-label' for='archivo"+contadorDocumentos+"'>Selecciona un archivo</label>
                       </div>
                    </div>
                </td>

                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='tipo_documento[${contadorDocumentos}]' id='tipo_documento${contadorDocumentos}'>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='importe[${contadorDocumentos}]' id='importe${contadorDocumentos}'>
                    </div>
                </td>

                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='observaciones[${contadorDocumentos}]' id='observaciones${contadorDocumentos}' required>
                    </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistro' data-id='${contadorDocumentos}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblDocumentos tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('archivo[' + contadorDocumentos + ']', validarInput);
        validador.addField('tipo_documento[' + contadorDocumentos + ']', validarInput);
        validador.addField('importe[' + contadorDocumentos + ']', validarInput);
        validador.addField('observaciones[' + contadorDocumentos + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };



    //elimina un elemento
    var delArchivo = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo[' + idDocumento + ']');
            validador.removeField('tipo_documento[' + idDocumento + ']');
            validador.removeField('importe[' + idDocumento + ']');
            validador.removeField('observaciones[' + idDocumento + ']');
            $('#trDocumento'+idDocumento).remove();//elimina el elemento
        });
    };

    const validarInput = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
        },
    };




    var eventosEspeciales = function () {
        $('#elemento1').val();
    };

    return {

        //main function to initiate the module
        init: function() {
            initEvents();
            validacion();
            eventosEspeciales();
             initSwalEliminarDdocumento();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});

