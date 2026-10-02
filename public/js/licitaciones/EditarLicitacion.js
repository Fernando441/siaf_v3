"use strict";
var Modulo = function() {

    var lista = ''; //lista de elementos
    var contadorDocumentos=0; //indice contador de elementos
    var validador; //validador del formulario

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_editlicitacion_uno');
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

        $( "#btnGuardarLicitacion" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnGuardarLicitacion');
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

        // $('#fecha_visita').datepicker({
        //     todayHighlight: true,
        //     orientation: "bottom left",
        //     templates: arrows,
        //     language: "es",
        //     format: "dd/mm/yyyy",
        // });


        $('#apertura_proposiciones').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $('#acto_fallo').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        // $("#fecha_entrega").datepicker({
        //     todayHighlight: true,
        //     orientation: "bottom left",
        //     templates: arrows,
        //     language: "es",
        //     format: "dd/mm/yyyy",
        // });

        $("#acto_fallo_info").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });


        $("#fecha_cierre").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_fianza").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_final_servicios").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_apertura_tecnica").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_apertura_economica").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });


        $("#fecha_subasta").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_compra_bases").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#fecha_repreguntas").datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $("#cliente_id").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#tipo_contratacion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#publicacion_licitacion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#monto_ofertado").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#monto_ganado").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#monto_fianza").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#monto_fianza_liberada").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        lista = construyeElementosLista();
        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });
        delArchivo();

    };

    var initSwalEliminar = function() {
        $(".hrefEliminar").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var documento = $(this).attr('data-documento');
            var block = $('#submit_editlicitacion_uno');

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
                        url: $('#licitacionEliminarPath').val(),
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

    //validador de elementos agregados para archivo
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
            "<tr id='trDocumentoNuevo"+contadorDocumentos+"'>",
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
            "          <select class='form-control' name='id_documento["+contadorDocumentos+"]' id='id_documento"+contadorDocumentos+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            lista,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarNuevo' data-id='"+contadorDocumentos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "			<i class='flaticon-delete'></i>",
            "		</a>",
            "	 </td>",
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
        jQuery(document).on("click", ".hrefEliminarNuevo" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo[' + idDocumento + ']');
            validador.removeField('id_documento[' + idDocumento + ']');
            $('#trDocumentoNuevo'+idDocumento).remove();//elimina el elemento
        });
    };


    return {

        //main function to initiate the module
        init: function() {
            initEvents();
            validacion();
            initSwalEliminar();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();
});


$("#cp_con").click(function(){
    $(".div_perdido").hide();
    $(".div_ganado").hide();
});

$("#cp_uno").click(function(){
    $(".div_perdido").show();
    $(".div_ganado").hide();
});

$("#cp_dos").click(function(){
    $(".div_perdido").hide();
    $(".div_ganado").show();
});


$("#ftp_uno").click(function(){
    document.getElementById("op_fecha").value = 1;
    var op_fecha = document.getElementById("op_fecha").value;
    if(op_fecha == 1){
        $("#div_fecha_visita").show();
    }

});


$("#ftp_dos").click(function(){
    document.getElementById("op_fecha").value = 2;
    var op_fecha = document.getElementById("op_fecha").value;
    if(op_fecha == 2){
        $("#div_fecha_visita").hide();
    }

});


$("#fsp_uno").click(function(){
    document.getElementById("op_fecha").value = 1;
    var op_fecha = document.getElementById("op_fecha").value;
    if(op_fecha == 1){
        $("#fecha_subasta_div").show();
    }

});


$("#fsp_dos").click(function(){
    document.getElementById("op_fecha_subasta").value = 2;
    var op_fecha_subasta = document.getElementById("op_fecha_subasta").value;
    if(op_fecha_subasta == 2){
        $("#fecha_subasta_div").hide();
    }

});

$("#frp_uno").click(function(){
    document.getElementById("op_fecha_repreguntas").value = 1;
    var op_fecha_repreguntas = document.getElementById("op_fecha_repreguntas").value;
    if(op_fecha_repreguntas == 1){
        $("#fecha_repreguntas_div").show();
    }

});


$("#frp_dos").click(function(){
    document.getElementById("op_fecha_repreguntas").value = 2;
    var op_fecha_repreguntas = document.getElementById("op_fecha_repreguntas").value;
    if(op_fecha_repreguntas == 2){
        $("#fecha_repreguntas_div").hide();
        document.getElementById("fecha_repreguntas").value = "";   
    }

});