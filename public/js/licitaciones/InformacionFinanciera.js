"use strict";
var Modulo = function() {

    var lista = ''; //lista de elementos
    var listados = '';
    var contadorDocumentos=0; //indice contador de elementos
    var contadorDocumentosdos=0; //indice contador de elementos
    var validador; //validador del formulario

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_informacion_financiera');
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

        $( "#btnGuardarInformacion" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardarInformacion');
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

        lista = construyeElementosLista();
        listados = construyeElementosListaDos();
        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });
        delArchivo();

    
        $( ".hrefAgregarOtrodos" ).on( "click", function(event) {
            event.preventDefault();
            addArchivodos();
        });
        delArchivodos();

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

    var initSwalEliminarDdocumentoseguros = function() {
        $(".hrefEliminarDocumentodos").click(function(e) {

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
                        url: $('#documentoEliminarPathSeguros').val(),
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

    //construye  elementos de la lista
    var construyeElementosLista = function () {
        var tipoArchivo = $("#tipoArchivo").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    //construye  elementos de la lista
    var construyeElementosListaDos = function () {
        var tipoArchivo = $("#tipoArchivos").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
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

    var addArchivo = function () {
        contadorDocumentos++;
        var html = '';
        html += (`
            <tr id='trDocumento${contadorDocumentos}'>
                <td>
                    <div class='form-group mb-0'>
                        <div class='custom-file'>
                            <input type='file' class='custom-file-input' id='select_documento${contadorDocumentos}' name='select_documento[${contadorDocumentos}]' required />
                            <label class='custom-file-label' for='archivo"+contadorDocumentos+"'>Selecciona un archivo</label>
                        </div>

                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <select class='form-control' name='tipo_fianza[${contadorDocumentos}]' id='tipo_fianza${contadorDocumentos}' required>
                        <option value=''>Selecciona un opción</option>
                            ${listados}
                        </select>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <select class='form-control' name='nombre_fianza[${contadorDocumentos}]' id='nombre_fianza${contadorDocumentos}' required>
                        <option value=''>Selecciona un opción</option>
                            ${lista}
                        </select>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='vigencia_inicial[${contadorDocumentos}]' readonly id='vigencia_inicial${contadorDocumentos}' required>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='vigencia_final[${contadorDocumentos}]' readonly id='vigencia_final${contadorDocumentos}' required>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='number' class='form-control' name='porcentaje[${contadorDocumentos}]' id='porcentaje${contadorDocumentos}' required min='1'>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <span> El importe se calculara al guardar la información </span>
                    </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistro' data-id='${contadorDocumentos}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblRegistros tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('select_documento[' + contadorDocumentos + ']', validarInput);
        validador.addField('tipo_fianza[' + contadorDocumentos + ']', validarInput);
        validador.addField('nombre_fianza[' + contadorDocumentos + ']', validarInput);
        validador.addField('vigencia_inicial[' + contadorDocumentos + ']', validarInput);
        validador.addField('vigencia_final[' + contadorDocumentos + ']', validarInput);
        validador.addField('porcentaje[' + contadorDocumentos + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        $('#vigencia_inicial' + contadorDocumentos).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

        $('#vigencia_final' + contadorDocumentos).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

    };



    var delArchivo = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('select_documento[' + idDocumento + ']');
            validador.removeField('tipo_fianza[' + idDocumento + ']');
            validador.removeField('nombre_fianza[' + idDocumento + ']');
            validador.removeField('vigencia_inicial[' + idDocumento + ']');
            validador.removeField('vigencia_final[' + idDocumento + ']');
            validador.removeField('porcentaje[' + idDocumento + ']');
            $('#trDocumento' + idDocumento).remove();//elimina el elemento
        });
    };


    var addArchivodos = function () {
        contadorDocumentosdos++;
        var html = '';
        html += (`
            <tr id='trDocumentodos${contadorDocumentosdos}'>
                <td>
                    <div class='form-group mb-0'>
                        <div class='custom-file'>
                            <input type='file' class='custom-file-input' id='select_documentorc${contadorDocumentosdos}' name='select_documentorc[${contadorDocumentosdos}]' required />
                            <label class='custom-file-label' for='archivo"+contadorDocumentosdos+"'>Selecciona un archivo</label>
                        </div>

                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <select class='form-control' name='nombre_fianzarc[${contadorDocumentosdos}]' id='nombre_fianzarc${contadorDocumentosdos}' required>
                        <option value=''>Selecciona un opción</option>
                            ${lista}
                        </select>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='vigencia_inicialrc[${contadorDocumentosdos}]' readonly id='vigencia_inicialrc${contadorDocumentosdos}' required>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='vigencia_finalrc[${contadorDocumentosdos}]' readonly id='vigencia_finalrc${contadorDocumentosdos}' required>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='number' class='form-control' name='porcentajerc[${contadorDocumentosdos}]' id='porcentajerc${contadorDocumentosdos}' required min='1'>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <span> El importe se calculara al guardar la información </span>
                    </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistrodos' data-id='${contadorDocumentosdos}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblRegistrosdos tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('select_documentorc[' + contadorDocumentosdos + ']', validarInput);
        validador.addField('nombre_fianzarc[' + contadorDocumentosdos + ']', validarInput);
        validador.addField('vigencia_iniciarc[' + contadorDocumentosdos + ']', validarInput);
        validador.addField('vigencia_finalrc[' + contadorDocumentosdos + ']', validarInput);
        validador.addField('porcentajerc[' + contadorDocumentosdos + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        $('#vigencia_inicialrc' + contadorDocumentosdos).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

        $('#vigencia_finalrc' + contadorDocumentosdos).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

    };

    var delArchivodos = function () {
        jQuery(document).on("click", ".buttonBorrarRegistrodos", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('select_documentorc[' + idDocumento + ']');
            validador.removeField('nombre_fianzarc[' + idDocumento + ']');
            validador.removeField('vigencia_iniciarc[' + idDocumento + ']');
            validador.removeField('vigencia_finalrc[' + idDocumento + ']');
            validador.removeField('porcentajerc[' + idDocumento + ']');
            $('#trDocumentodos' + idDocumento).remove();//elimina el elemento
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
            initSwalEliminarDdocumentoseguros();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});

