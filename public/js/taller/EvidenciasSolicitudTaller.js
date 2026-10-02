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

    //construye  elementos de la lista
    // var construyeElementosLista = function () {
    //     var tipoArchivo = $("#tipoArchivo").val();
    //     var colTipoArchivo = JSON.parse(tipoArchivo);
    //     var opcion ="";

    //     $.each(colTipoArchivo, function(i, item) {
    //         opcion += "<option value='"+i+"' >"+item+"</option>";
    //     });

    //     return opcion;
    // };

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
            "    <td>",
            "       <div class='form-group mb-0'>",
            "               <input type='text' required class='form-control observaciones' id='observaciones" + contadorDocumentos + "' name='observaciones[" + contadorDocumentos + "]'  />",
            "       </div>",
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
        validador.addField('id_documento[' + contadorDocumentos + ']', tipoArchivoValidador);
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
            validador.removeField('id_documento[' + idDocumento + ']');
            $('#trDocumento'+idDocumento).remove();//elimina el elemento
        });
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



    const validarInput = {
        validators: {
            notEmpty: {
                message: 'Por favor introduce un valor',
            },
        },
    };


    $(document).on('change', 'select[id^="id_estado"]', function () {
        var id = $(this).attr('id');
        var idGrupo = $(this).val();
        var idDocumento = id.replace('id_estado', '');
        var url = $('#url_municipios').val();
        var data = {
            id: idGrupo,
            _token: $("[name='_token']").val()
        };
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                var html = '';
                html += (`
                    <option value=''>Selecciona un opción</option>
                    `);

                var colSubgrupo = JSON.parse(response.success);

                $.each(colSubgrupo, function (i, item) {
                    html += (`
                        <option value='${i}'>${item}</option>
                        `);
                });
                console.log(html);
                $('#id_municipio').html(html);

                // validador.addField('id_municipio[' + idDocumento + ']', validarInput);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });



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


$('#tecnica_uno').change(function(){

    if($(this).val() == 1){
        $("#tecnica_uno_st1").show();
        $("#tecnica_uno_st2").hide();
        $("#tecnica_uno_st3").hide();
        $("#tecnica_uno_st4").hide();
        $("#tecnica_uno_st5").hide();
    }
    if($(this).val() == 2){
        $("#tecnica_uno_st1").hide();
        $("#tecnica_uno_st2").show();
        $("#tecnica_uno_st3").hide();
        $("#tecnica_uno_st4").hide();
        $("#tecnica_uno_st5").hide();
    }
    if($(this).val() == 3){
        $("#tecnica_uno_st1").hide();
        $("#tecnica_uno_st2").hide();
        $("#tecnica_uno_st3").show();
        $("#tecnica_uno_st4").hide();
        $("#tecnica_uno_st5").hide();
    }
    if($(this).val() == 4){
        $("#tecnica_uno_st1").hide();
        $("#tecnica_uno_st2").hide();
        $("#tecnica_uno_st3").hide();
        $("#tecnica_uno_st4").show();
        $("#tecnica_uno_st5").hide();
    }
    if($(this).val() == 5){
        $("#tecnica_uno_st1").hide();
        $("#tecnica_uno_st2").hide();
        $("#tecnica_uno_st3").hide();
        $("#tecnica_uno_st4").hide();
        $("#tecnica_uno_st5").show();
    }
});



$('#operativa_uno').change(function(){

    if($(this).val() == 1){
        $("#operativa_uno_st1").show();
        $("#operativa_uno_st2").hide();
        $("#operativa_uno_st3").hide();
        $("#operativa_uno_st4").hide();
        $("#operativa_uno_st5").hide();
    }
    if($(this).val() == 2){
        $("#operativa_uno_st1").hide();
        $("#operativa_uno_st2").show();
        $("#operativa_uno_st3").hide();
        $("#operativa_uno_st4").hide();
        $("#operativa_uno_st5").hide();
    }
    if($(this).val() == 3){
        $("#operativa_uno_st1").hide();
        $("#operativa_uno_st2").hide();
        $("#operativa_uno_st3").show();
        $("#operativa_uno_st4").hide();
        $("#operativa_uno_st5").hide();
    }
    if($(this).val() == 4){
        $("#operativa_uno_st1").hide();
        $("#operativa_uno_st2").hide();
        $("#operativa_uno_st3").hide();
        $("#operativa_uno_st4").show();
        $("#operativa_uno_st5").hide();
    }
    if($(this).val() == 5){
        $("#operativa_uno_st1").hide();
        $("#operativa_uno_st2").hide();
        $("#operativa_uno_st3").hide();
        $("#operativa_uno_st4").hide();
        $("#operativa_uno_st5").show();
    }
});

$('#operativa_dos').change(function(){

    if($(this).val() == 1){
        $("#operativa_dos_st1").show();
        $("#operativa_dos_st2").hide();
        $("#operativa_dos_st3").hide();
        $("#operativa_dos_st4").hide();
        $("#operativa_dos_st5").hide();
    }
    if($(this).val() == 2){
        $("#operativa_dos_st1").hide();
        $("#operativa_dos_st2").show();
        $("#operativa_dos_st3").hide();
        $("#operativa_dos_st4").hide();
        $("#operativa_dos_st5").hide();
    }
    if($(this).val() == 3){
        $("#operativa_dos_st1").hide();
        $("#operativa_dos_st2").hide();
        $("#operativa_dos_st3").show();
        $("#operativa_dos_st4").hide();
        $("#operativa_dos_st5").hide();
    }
    if($(this).val() == 4){
        $("#operativa_dos_st1").hide();
        $("#operativa_dos_st2").hide();
        $("#operativa_dos_st3").hide();
        $("#operativa_dos_st4").show();
        $("#operativa_dos_st5").hide();
    }
    if($(this).val() == 5){
        $("#operativa_dos_st1").hide();
        $("#operativa_dos_st2").hide();
        $("#operativa_dos_st3").hide();
        $("#operativa_dos_st4").hide();
        $("#operativa_dos_st5").show();
    }
});

$('#operativa_tres').change(function(){

    if($(this).val() == 1){
        $("#operativa_tres_st1").show();
        $("#operativa_tres_st2").hide();
        $("#operativa_tres_st3").hide();
        $("#operativa_tres_st4").hide();
        $("#operativa_tres_st5").hide();
    }
    if($(this).val() == 2){
        $("#operativa_tres_st1").hide();
        $("#operativa_tres_st2").show();
        $("#operativa_tres_st3").hide();
        $("#operativa_tres_st4").hide();
        $("#operativa_tres_st5").hide();
    }
    if($(this).val() == 3){
        $("#operativa_tres_st1").hide();
        $("#operativa_tres_st2").hide();
        $("#operativa_tres_st3").show();
        $("#operativa_tres_st4").hide();
        $("#operativa_tres_st5").hide();
    }
    if($(this).val() == 4){
        $("#operativa_tres_st1").hide();
        $("#operativa_tres_st2").hide();
        $("#operativa_tres_st3").hide();
        $("#operativa_tres_st4").show();
        $("#operativa_tres_st5").hide();
    }
    if($(this).val() == 5){
        $("#operativa_tres_st1").hide();
        $("#operativa_tres_st2").hide();
        $("#operativa_tres_st3").hide();
        $("#operativa_tres_st4").hide();
        $("#operativa_tres_st5").show();
    }
});


$('#admin_uno').change(function(){

    if($(this).val() == 1){
        $("#admin_uno_st1").show();
        $("#admin_uno_st2").hide();
        $("#admin_uno_st3").hide();
        $("#admin_uno_st4").hide();
        $("#admin_uno_st5").hide();
    }
    if($(this).val() == 2){
        $("#admin_uno_st1").hide();
        $("#admin_uno_st2").show();
        $("#admin_uno_st3").hide();
        $("#admin_uno_st4").hide();
        $("#admin_uno_st5").hide();
    }
    if($(this).val() == 3){
        $("#admin_uno_st1").hide();
        $("#admin_uno_st2").hide();
        $("#admin_uno_st3").show();
        $("#admin_uno_st4").hide();
        $("#admin_uno_st5").hide();
    }
    if($(this).val() == 4){
        $("#admin_uno_st1").hide();
        $("#admin_uno_st2").hide();
        $("#admin_uno_st3").hide();
        $("#admin_uno_st4").show();
        $("#admin_uno_st5").hide();
    }
    if($(this).val() == 5){
        $("#admin_uno_st1").hide();
        $("#admin_uno_st2").hide();
        $("#admin_uno_st3").hide();
        $("#admin_uno_st4").hide();
        $("#admin_uno_st5").show();
    }
});

$('#admin_dos').change(function(){

    if($(this).val() == 1){
        $("#admin_dos_st1").show();
        $("#admin_dos_st2").hide();
        $("#admin_dos_st3").hide();
        $("#admin_dos_st4").hide();
        $("#admin_dos_st5").hide();
    }
    if($(this).val() == 2){
        $("#admin_dos_st1").hide();
        $("#admin_dos_st2").show();
        $("#admin_dos_st3").hide();
        $("#admin_dos_st4").hide();
        $("#admin_dos_st5").hide();
    }
    if($(this).val() == 3){
        $("#admin_dos_st1").hide();
        $("#admin_dos_st2").hide();
        $("#admin_dos_st3").show();
        $("#admin_dos_st4").hide();
        $("#admin_dos_st5").hide();
    }
    if($(this).val() == 4){
        $("#admin_dos_st1").hide();
        $("#admin_dos_st2").hide();
        $("#admin_dos_st3").hide();
        $("#admin_dos_st4").show();
        $("#admin_dos_st5").hide();
    }
    if($(this).val() == 5){
        $("#admin_dos_st1").hide();
        $("#admin_dos_st2").hide();
        $("#admin_dos_st3").hide();
        $("#admin_dos_st4").hide();
        $("#admin_dos_st5").show();
    }
});

$('#admin_tres').change(function(){

    if($(this).val() == 1){
        $("#admin_tres_st1").show();
        $("#admin_tres_st2").hide();
        $("#admin_tres_st3").hide();
        $("#admin_tres_st4").hide();
        $("#admin_tres_st5").hide();
    }
    if($(this).val() == 2){
        $("#admin_tres_st1").hide();
        $("#admin_tres_st2").show();
        $("#admin_tres_st3").hide();
        $("#admin_tres_st4").hide();
        $("#admin_tres_st5").hide();
    }
    if($(this).val() == 3){
        $("#admin_tres_st1").hide();
        $("#admin_tres_st2").hide();
        $("#admin_tres_st3").show();
        $("#admin_tres_st4").hide();
        $("#admin_tres_st5").hide();
    }
    if($(this).val() == 4){
        $("#admin_tres_st1").hide();
        $("#admin_tres_st2").hide();
        $("#admin_tres_st3").hide();
        $("#admin_tres_st4").show();
        $("#admin_tres_st5").hide();
    }
    if($(this).val() == 5){
        $("#admin_tres_st1").hide();
        $("#admin_tres_st2").hide();
        $("#admin_tres_st3").hide();
        $("#admin_tres_st4").hide();
        $("#admin_tres_st5").show();
    }
});


$('#serv_uno').change(function(){

    if($(this).val() == 1){
        $("#serv_uno_st1").show();
        $("#serv_uno_st2").hide();
        $("#serv_uno_st3").hide();
        $("#serv_uno_st4").hide();
        $("#serv_uno_st5").hide();
    }
    if($(this).val() == 2){
        $("#serv_uno_st1").hide();
        $("#serv_uno_st2").show();
        $("#serv_uno_st3").hide();
        $("#serv_uno_st4").hide();
        $("#serv_uno_st5").hide();
    }
    if($(this).val() == 3){
        $("#serv_uno_st1").hide();
        $("#serv_uno_st2").hide();
        $("#serv_uno_st3").show();
        $("#serv_uno_st4").hide();
        $("#serv_uno_st5").hide();
    }
    if($(this).val() == 4){
        $("#serv_uno_st1").hide();
        $("#serv_uno_st2").hide();
        $("#serv_uno_st3").hide();
        $("#serv_uno_st4").show();
        $("#serv_uno_st5").hide();
    }
    if($(this).val() == 5){
        $("#serv_uno_st1").hide();
        $("#serv_uno_st2").hide();
        $("#serv_uno_st3").hide();
        $("#serv_uno_st4").hide();
        $("#serv_uno_st5").show();
    }
});


$('#serv_dos').change(function(){

    if($(this).val() == 1){
        $("#serv_dos_st1").show();
        $("#serv_dos_st2").hide();
        $("#serv_dos_st3").hide();
        $("#serv_dos_st4").hide();
        $("#serv_dos_st5").hide();
    }
    if($(this).val() == 2){
        $("#serv_dos_st1").hide();
        $("#serv_dos_st2").show();
        $("#serv_dos_st3").hide();
        $("#serv_dos_st4").hide();
        $("#serv_dos_st5").hide();
    }
    if($(this).val() == 3){
        $("#serv_dos_st1").hide();
        $("#serv_dos_st2").hide();
        $("#serv_dos_st3").show();
        $("#serv_dos_st4").hide();
        $("#serv_dos_st5").hide();
    }
    if($(this).val() == 4){
        $("#serv_dos_st1").hide();
        $("#serv_dos_st2").hide();
        $("#serv_dos_st3").hide();
        $("#serv_dos_st4").show();
        $("#serv_dos_st5").hide();
    }
    if($(this).val() == 5){
        $("#serv_dos_st1").hide();
        $("#serv_dos_st2").hide();
        $("#serv_dos_st3").hide();
        $("#serv_dos_st4").hide();
        $("#serv_dos_st5").show();
    }
});

$('#serv_tres').change(function(){

    if($(this).val() == 1){
        $("#serv_tres_st1").show();
        $("#serv_tres_st2").hide();
        $("#serv_tres_st3").hide();
        $("#serv_tres_st4").hide();
        $("#serv_tres_st5").hide();
    }
    if($(this).val() == 2){
        $("#serv_tres_st1").hide();
        $("#serv_tres_st2").show();
        $("#serv_tres_st3").hide();
        $("#serv_tres_st4").hide();
        $("#serv_tres_st5").hide();
    }
    if($(this).val() == 3){
        $("#serv_tres_st1").hide();
        $("#serv_tres_st2").hide();
        $("#serv_tres_st3").show();
        $("#serv_tres_st4").hide();
        $("#serv_tres_st5").hide();
    }
    if($(this).val() == 4){
        $("#serv_tres_st1").hide();
        $("#serv_tres_st2").hide();
        $("#serv_tres_st3").hide();
        $("#serv_tres_st4").show();
        $("#serv_tres_st5").hide();
    }
    if($(this).val() == 5){
        $("#serv_tres_st1").hide();
        $("#serv_tres_st2").hide();
        $("#serv_tres_st3").hide();
        $("#serv_tres_st4").hide();
        $("#serv_tres_st5").show();
    }
});



$('#fin_uno').change(function(){

    if($(this).val() == 1){
        $("#fin_uno_st1").show();
        $("#fin_uno_st2").hide();
        $("#fin_uno_st3").hide();
        $("#fin_uno_st4").hide();
        $("#fin_uno_st5").hide();
    }
    if($(this).val() == 2){
        $("#fin_uno_st1").hide();
        $("#fin_uno_st2").show();
        $("#fin_uno_st3").hide();
        $("#fin_uno_st4").hide();
        $("#fin_uno_st5").hide();
    }
    if($(this).val() == 3){
        $("#fin_uno_st1").hide();
        $("#fin_uno_st2").hide();
        $("#fin_uno_st3").show();
        $("#fin_uno_st4").hide();
        $("#fin_uno_st5").hide();
    }
    if($(this).val() == 4){
        $("#fin_uno_st1").hide();
        $("#fin_uno_st2").hide();
        $("#fin_uno_st3").hide();
        $("#fin_uno_st4").show();
        $("#fin_uno_st5").hide();
    }
    if($(this).val() == 5){
        $("#fin_uno_st1").hide();
        $("#fin_uno_st2").hide();
        $("#fin_uno_st3").hide();
        $("#fin_uno_st4").hide();
        $("#fin_uno_st5").show();
    }
});


$('#fin_dos').change(function(){

    if($(this).val() == 1){
        $("#fin_dos_st1").show();
        $("#fin_dos_st2").hide();
        $("#fin_dos_st3").hide();
        $("#fin_dos_st4").hide();
        $("#fin_dos_st5").hide();
    }
    if($(this).val() == 2){
        $("#fin_dos_st1").hide();
        $("#fin_dos_st2").show();
        $("#fin_dos_st3").hide();
        $("#fin_dos_st4").hide();
        $("#fin_dos_st5").hide();
    }
    if($(this).val() == 3){
        $("#fin_dos_st1").hide();
        $("#fin_dos_st2").hide();
        $("#fin_dos_st3").show();
        $("#fin_dos_st4").hide();
        $("#fin_dos_st5").hide();
    }
    if($(this).val() == 4){
        $("#fin_dos_st1").hide();
        $("#fin_dos_st2").hide();
        $("#fin_dos_st3").hide();
        $("#fin_dos_st4").show();
        $("#fin_dos_st5").hide();
    }
    if($(this).val() == 5){
        $("#fin_dos_st1").hide();
        $("#fin_dos_st2").hide();
        $("#fin_dos_st3").hide();
        $("#fin_dos_st4").hide();
        $("#fin_dos_st5").show();
    }
});




$("#btnGuardarevaluacion").click(function() {

    Swal.fire({
        title: "Estas seguro de guardar la evaluacion ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Guardar!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            // document.getElementById("id_convenio_act").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("formevaluacion").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});