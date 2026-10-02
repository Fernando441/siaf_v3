"use strict";
var Modulo = function() {

    var listaGestor = '';

    //indices contadores de elementos agregados en los formularios
    var contadorDocumentos=0;
    var contadorDocumentosAdministrativos=0;
    var contadorDocumentosFiscal=0;
    var contadorDocumentosFinanciera=0;
    var contadorDocumentosOtros=0;
    var contadorDocumentosGestor=0;

    //validadores de los formularios
    var validador; //validador del formulario Informacion Legal

    var validacion = function() {

        //obtenemos el formulario por su id      
        const form = document.getElementById('submit_propuesta');

        //validador de formulario
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
                        //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                        //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                    })
                }
            }
        ).on('core.form.valid', function() {
            toastr.success("Guardando, Por favor Espere...");
        }).on('core.form.invalid', function() {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });



        //validar y enviar formulario
        $( "#btnGuardarPropuesta" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardarPropuesta');
                    KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });

    };

    var inicioControles = function () {

        listaGestor = construyeElementosListaGestor();


        $( ".hrefAgregarOtroLegal" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });

        $( ".hrefAgregarOtroAdministrativa" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoAdministrativo();
        });

        $( ".hrefAgregarOtroFiscal" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoFiscal();
        });

        $( ".hrefAgregarOtroFinanciera" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoFinanciera();
        });

        $( ".hrefAgregarOtroOtros" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoOtros();
        });


        delArchivo();
        delArchivoAdministrativa();
        delArchivoFiscal();
        delArchivoFinanciera();
        delArchivoOtros();

        // Inicializar datatables
        var tblDocumentos = $('#tblDocumentos').DataTable({
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },
        });

        var tblDocumentosAdministrativos = $('#tblDocumentosAdministrativa').DataTable({
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },
        });

        var tblDocumentosFiscal = $('#tblDocumentosFiscal').DataTable({
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },
        });

        var tblDocumentosFinanciera = $('#tblDocumentosFinanciera').DataTable({
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },
        });

    };

    //construye  elementos de la lista Legal
    var construyeElementosListaLegal = function () {
        var tipoArchivo = $("#tipoArchivoLegal").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    //construye  elementos de la lista Administrativa
    var construyeElementosListaAdministrativa = function () {
        var tipoArchivo = $("#tipoArchivoAdministrativa").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    //construye  elementos de la lista Fiscal
    var construyeElementosListaFiscal = function () {
        var tipoArchivo = $("#tipoArchivoFiscal").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };
    
    //construye  elementos de la lista Financiera
    var construyeElementosListaFinanciera = function () {
        var tipoArchivo = $("#tipoArchivoFinanciera").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    var construyeElementosListaGestor = function () {
        var tipoArchivo = $("#tipoArchivoGestor").val();
        var subText = $("#cadenaSelectSubtext").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var colSubText = JSON.parse(subText); //nombre del archivo y extension
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"'>"+item+" - "+colSubText[i]+"</option>";
        });

        return opcion;
    };

    //Validador de elementos agregados para archivo
    const archivoValidador = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
            file: {
                extension: 'jpeg,jpg,png,pdf,doc,xls,gif,ppt,bmp,docx,xlsx,pptx',
                type: 'image/jpeg,image/png,application/pdf,application/msword,application/vnd.ms-excel,image/gif,application/vnd.ms-powerpoint,image/x-ms-bmp,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation',
                message: 'Por favor ingrese un archivo válido, solo se permite imágenes, archivos de office y PDF',
            },
        },
    };

    //Validador de elementos agregados para archivo
    const tipoArchivoValidador = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
        },
    };

    //agrega el elemento archivo y lista desplegable para el formulario Legal
    var addArchivo = function () {
        contadorDocumentos++;
        var html = '';

        html += ([    "",
            "<tr id='trDocumento"+contadorDocumentos+"'>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control select2' name='id_documento_legal["+contadorDocumentos+"]' id='id_documento_legal"+contadorDocumentos+"' required>",
            "              <option value=''>Selecciona un opción</option>",
                            listaGestor,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarLegal' data-id='"+contadorDocumentos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos tbody").append(html); //agrega el html creado
        validador.addField('id_documento_legal[' + contadorDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        
        $('#id_documento_legal'+contadorDocumentos).select2({
            placeholder: "Selecciona un opción",
            allowClear: true,
            width: '100%',
        });
    };

    //agrega el elemento archivo y lista desplegable para el formulario Administrativa
    var addArchivoAdministrativo = function () {
        contadorDocumentosAdministrativos++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoAdministrativa"+contadorDocumentosAdministrativos+"'>",
            "    <td >" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control select2' name='id_documento_administrativa["+contadorDocumentosAdministrativos+"]' id='id_documento_administrativa"+contadorDocumentosAdministrativos+"' required>",
            "              <option value=''>Selecciona un opción</option>",
                            listaGestor,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarAdministrativa' data-id='"+contadorDocumentosAdministrativos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentosAdministrativa tbody").append(html); //agrega el html creado
        validador.addField('id_documento_administrativa[' + contadorDocumentosAdministrativos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        
        $('#id_documento_administrativa'+contadorDocumentosAdministrativos).select2({
            placeholder: "Selecciona un opción",
            allowClear: true,
            width: '100%'
        });
    };

    //agrega el elemento archivo y lista desplegable para el formulario Fiscal
    var addArchivoFiscal = function () {
        contadorDocumentosFiscal++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoFiscal"+contadorDocumentosFiscal+"'>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control select2' name='id_documento_fiscal["+contadorDocumentosFiscal+"]' id='id_documento_fiscal"+contadorDocumentosFiscal+"' required>",
            "              <option value=''>Selecciona un opción</option>",
                            listaGestor,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarFiscal' data-id='"+contadorDocumentosFiscal+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentosFiscal tbody").append(html); //agrega el html creado
        validador.addField('id_documento_fiscal[' + contadorDocumentosFiscal + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        
        $('#id_documento_fiscal'+contadorDocumentosFiscal).select2({
            placeholder: "Selecciona un opción",
            allowClear: true,
            width: '100%'
        });
    };

    //agrega el elemento archivo y lista desplegable para el formulario Financiera
    var addArchivoFinanciera = function () {
        contadorDocumentosFinanciera++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoFinanciera"+contadorDocumentosFinanciera+"'>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control select2' name='id_documento_financiera["+contadorDocumentosFinanciera+"]' id='id_documento_financiera"+contadorDocumentosFinanciera+"' required>",
            "              <option value=''>Selecciona un opción</option>",
                            listaGestor,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarFinanciera' data-id='"+contadorDocumentosFinanciera+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentosFinanciera tbody").append(html); //agrega el html creado
        validador.addField('id_documento_financiera[' + contadorDocumentosFinanciera + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        
        $('#id_documento_financiera'+contadorDocumentosFinanciera).select2({
            placeholder: "Selecciona un opción",
            allowClear: true,
            width: '100%'
        });
    };

    //agrega el elemento archivo y lista desplegable para el formulario Otros
    var addArchivoOtros = function () {
        contadorDocumentosOtros++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoOtros"+contadorDocumentosOtros+"'>",
            "    <td>",
            "        <div class='form-group mb-0'>",
            "           <div class='custom-file'>",
            "               <input type='file' class='custom-file-input' id='archivo_otros"+contadorDocumentosOtros+"' name='archivo_otros["+contadorDocumentosOtros+"]' required />",
            "               <label class='custom-file-label' for='archivo_otros"+contadorDocumentosOtros+"'>Selecciona un archivo</label>",
            "           </div>",
            "        </div>",
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "           <input type='text' class='form-control' name='descripcion_otros["+contadorDocumentosOtros+"]' id='descripcion_otros"+contadorDocumentosOtros+"' placeholder='Descripción del documento' required />",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarOtros' data-id='"+contadorDocumentosOtros+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentosOtros tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('archivo_otros[' + contadorDocumentosOtros + ']', archivoValidador);
        validador.addField('descripcion_otros[' + contadorDocumentosOtros + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };

    //elimina un elemento del formulario legal
    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminarLegal" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            validador.removeField('id_documento_legal[' + idDocumento + ']');
            $('#trDocumento'+idDocumento).remove();//elimina el elemento
        });
    };

    //elimina un elemento del formulario administrativa
    var delArchivoAdministrativa = function () {
        jQuery(document).on("click", ".hrefEliminarAdministrativa" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            validador.removeField('id_documento_administrativa[' + idDocumento + ']');
            $('#trDocumentoAdministrativa'+idDocumento).remove();//elimina el elemento
        });
    };

    //elimina un elemento del formulario fiscal
    var delArchivoFiscal = function () {
        jQuery(document).on("click", ".hrefEliminarFiscal" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            validador.removeField('id_documento_fiscal[' + idDocumento + ']');
            $('#trDocumentoFiscal'+idDocumento).remove();//elimina el elemento
        });
    };

    //elimina un elemento del formulario financiera
    var delArchivoFinanciera = function () {
        jQuery(document).on("click", ".hrefEliminarFinanciera" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            validador.removeField('id_documento_financiera[' + idDocumento + ']');
            $('#trDocumentoFinanciera'+idDocumento).remove();//elimina el elemento
        });
    };

    //elimina un elemento del formulario otros
    var delArchivoOtros = function () {
        jQuery(document).on("click", ".hrefEliminarOtros" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo_otros[' + idDocumento + ']');
            validador.removeField('descripcion_otros[' + idDocumento + ']');
            $('#trDocumentoOtros'+idDocumento).remove();//elimina el elemento
        });
    };

    //swal to eliminate a document from the form
    var initSwalEliminar = function() {
        $(".hrefEliminarDocumento").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var tipo = $(this).attr('data-tipo');
            var folio = $(this).attr('data-folio');

            Swal.fire({
                title: "¿Desea eliminar el documento?.",
                text: "El documento se eliminará permanentemente.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Documento",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#propuestaTecnicaEliminarPath').val(),
                        data: {
                            id: id,
                            tipo: tipo,
                            folio: folio,
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function() {
                        }
                    }).done(function(data) {
                        $('#trStorageDocumento'+tipo+id).remove();
                        KTApp.hideTooltips();
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success("El documento se elimino correctamente.");
                    });
                }
            });
        });
    };


    return {

        //main function to initiate the module
        init: function() {
            inicioControles();
            validacion();
            initSwalEliminar();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});

