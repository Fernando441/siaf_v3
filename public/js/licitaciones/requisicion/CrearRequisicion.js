"use strict";
var Modulo = function () {

    var tipo_vehiculo = ''; //lista de elementos
    var contadorDocumentos = 0; //indice contador de elementos
    var contadorFotografia = 0;
    var validador; //validador del formulario

    var validacion = function () {
        //validacion de formulario
        const form = document.getElementById('formCrearRequisicion');
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

        $("#btnGuardarUnidad").click(function (e) {
            e.preventDefault();
            validador.validate().then(function (status) {
                if (status === 'Valid') {
                    var btnGuardar = document.getElementById('btnGuardarUnidad');
                    KTUtil.btnWait(btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });
    };

    var initEvents = function () {

        var arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }


        tipo_vehiculo = construyeElementosLista();
        //botón agregar otro archivo
        $(".hrefAgregarOtro").on("click", function (event) {
            event.preventDefault();
            addArchivo();
        });

        delArchivo();


        $('#kt_datetimepicker_1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'es',
            defaultDate: new Date()
        });

    };

    //construye  elementos de la lista
    var construyeElementosLista = function () {
        var tipoArchivo = $("#tipovehiculo").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";

        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
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
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control' name='descripcion[" + contadorDocumentos + "]' id='descripcion" + contadorDocumentos + "' required>",
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
            "               <input type='text' class='form-control observaciones' id='observaciones" + contadorDocumentos + "' name='observaciones[" + contadorDocumentos + "]' required />",
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
        validador.addField('descripcion[' + contadorDocumentos + ']', archivoValidador);
        validador.addField('cantidad[' + contadorDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };

    //elimina un elemento
    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminar", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('descripcion[' + idDocumento + ']');
            validador.removeField('cantidad[' + idDocumento + ']');
            $('#trDocumento' + idDocumento).remove();//elimina el elemento
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
