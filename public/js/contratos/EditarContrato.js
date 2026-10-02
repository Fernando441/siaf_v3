"use strict";
var Modulo = function() {

    var lista = ''; //lista de elementos
    var pagos_lista = ''; //lista de elementos
    var penalizaciones = ''; //lista de penalizaciones
    var contadorDocumentos=0; //indice contador de elementos
    var validador = 0; //validador del formulario
    var conDocumentos  =0;
    var conDeductivas=0;
    var id_pro = 0;

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_contrato_edit');
        validador = FormValidation.formValidation(
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

        $( "#btnEditarcontrato" ).click(function( e ) {
            e.preventDefault();
            validador.validate().then(function(status) {
                if (status === 'Valid'){
                    var btnGuardar = document.getElementById('btnEditarcontrato');
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


        $('.fecha_contrato').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $('.fecha_vigencia').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $('#firma_contrato').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $('.fecha_final_vigencia').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });


        $(".no_licitacion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".id_emisor").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".id_clientes").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".id_contratacion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".id_responsable").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".id_fuenteproyecto").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $(".presuuesto_minimo").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $(".presuuesto_maximo").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $(".importe_general").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $(".iva").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        lista = construyeElementosLista();
        pagos_lista = construyeavancefinancieroLista();
        penalizaciones =construyepenalizacionesLista();
        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            var id_pro = $(this).data('id');
            console.log("pro id:" + id_pro);
            addArchivo(id_pro);
        });
        delArchivo();

        $( ".hrefAgregarOtroAvance" ).on( "click", function(event) {
            event.preventDefault();
            var id_pro = $(this).data('id');
            addArchivoAvanceFinanciero(id_pro);
        });
        delArchivoAvance();

        $( ".hrefAgregarOtroDeductiva" ).on( "click", function(event) {
            event.preventDefault();
            var id_pro = $(this).data('id');
            addArchivoDeductivaPago(id_pro);
        });
        delArchivoDeductiva();

    };

    var initSwalEliminar = function() {
        $(".hrefEliminar").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var documento = $(this).attr('data-documento');
            var block = $('#submit_contrato_edit');
            var proyecto = $(this).attr('data-proyecto');

            Swal.fire({
                title: "¿Desea eliminar el documento?.",
                text: documento,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Documento",
                cancelButtonText: "Cerrar",
                reverseButtons: true
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
                            $('#trDocumento'+id+"_"+proyecto).remove();//elimina el elemento html
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

    var initSwalEliminarAvance = function() {
        $(".hrefEliminarAvanc").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var documento = $(this).attr('data-documento');
            var block = $('#submit_contrato_edit');
            var proyecto = $(this).attr('data-proyecto');

            Swal.fire({
                title: "¿Desea eliminar el documento?.",
                text: documento,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Documento",
                cancelButtonText: "Cerrar",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#avanceEliminarPath').val(),
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
                            $('#trDocumentoAV'+id+"_"+proyecto).remove();//elimina el elemento html
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

    var initSwalEliminarDeductiva = function() {
        $(".hrefEliminarDeductivaP").click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var documento = $(this).attr('data-documento');
            var block = $('#submit_contrato_edit');
            var proyecto = $(this).attr('data-proyecto');

            Swal.fire({
                title: "¿Desea eliminar el documento?.",
                text: documento,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar Documento",
                cancelButtonText: "Cerrar",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#deductivaEliminarPath').val(),
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
                            $('#trDocumentoDP'+id+"_"+proyecto).remove();//elimina el elemento html
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

    //construye elementos de avances financiero
    var construyeavancefinancieroLista =function(){
        var tipoArchivo = $("#pagoAvance").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    //construye elementos de penalizaciones
    var construyepenalizacionesLista =function(){
        var tipoArchivo = $("#PenalziacionProyecto").val();
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
                extension: 'jpeg,jpg,png,pdf,docx,xls,gif,ppt,bmp,docx,xlsx,pptx',
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
    var addArchivo = function (id_pro) {
        contadorDocumentos++;

        var html = '';
        html += ([    "",
            "<tr id='trDocumento"+contadorDocumentos+"_"+id_pro+"'>",
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
            "          <select class='form-control' name='id_documento_"+id_pro+"["+contadorDocumentos+"]' id='id_documento"+contadorDocumentos+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            lista,
            "          </select>",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='"+contadorDocumentos+"' data-pro='"+id_pro+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tbodyDoc_"+id_pro+" tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('archivo[' + contadorDocumentos + ']', archivoValidador);
        validador.addField('id_documento_'+id_pro+'[' + contadorDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };

    //elimina un elemento
    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminar" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            var id_pro = $(this).attr("data-pro");
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('archivo[' + idDocumento + ']');
            validador.removeField('id_documento_'+id_pro+'[' + idDocumento + ']');
            $('#trDocumento'+idDocumento+"_"+id_pro).remove();//elimina el elemento
        });
    };

    // AVANCE FINANCIERO
    var addArchivoAvanceFinanciero = function (id_pro) {
        conDocumentos++;
        console.log("avance: "+id_pro);
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoAv"+conDocumentos+"_"+id_pro+"'>",
            "    <td>",
            "        <div class='form-group mb-0'>",
            "           <div class='custom-file'>",
            "               <input type='file' class='custom-file-input' id='pago"+conDocumentos+"' name='pago["+conDocumentos+"]' required />",
            "               <label class='custom-file-label' for='archivo"+conDocumentos+"'>Selecciona un archivo</label>",
            "           </div>",
            "        </div>",
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control fecha_avance' readonly id='fecha"+conDocumentos+"' name='fecha_"+id_pro+"["+conDocumentos+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control monto_avance' id='monto"+conDocumentos+"' name='monto_"+id_pro+"["+conDocumentos+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarAvance' data-id='"+conDocumentos+"' data-pro='"+id_pro+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos_avance_"+id_pro+" tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('pago[' + conDocumentos + ']', archivoValidador);
        validador.addField('fecha_'+id_pro+'[' + conDocumentos + ']', tipoArchivoValidador);
        validador.addField('monto_'+id_pro+'[' + conDocumentos + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado


        $('.fecha_avance').datepicker({
            todayHighlight: true,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $(".monto_avance").inputmask('$ 999,999,999.99', {
            numericInput: true
        });
    };


    var delArchivoAvance = function () {
        jQuery(document).on("click", ".hrefEliminarAvance" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            var id_pro = $(this).attr("data-pro");
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('pago[' + idDocumento + ']');
            validador.removeField('fecha_'+id_pro+'[' + idDocumento + ']');
            validador.removeField('monto_'+id_pro+'[' + idDocumento + ']');
            $('#trDocumentoAv'+idDocumento+"_"+id_pro).remove();//elimina el elemento
        });
    };

    // DEDUCTIVA DE PAGO
    var addArchivoDeductivaPago = function (id_pro) {
        conDeductivas++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoDP"+conDeductivas+"_"+id_pro+"'>",
            "    <td>",
            "        <div class='form-group mb-0'>",
            "           <div class='custom-file'>",
            "               <input type='file' class='custom-file-input' id='deductiva"+conDeductivas+"' name='deductiva["+conDeductivas+"]' required />",
            "               <label class='custom-file-label' for='archivo"+conDeductivas+"'>Selecciona un archivo</label>",
            "           </div>",
            "        </div>",
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control' name='id_avance_"+id_pro+"["+conDeductivas+"]' id='id_avance"+conDeductivas+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            pagos_lista,
            "          </select>",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "          <select class='form-control' name='id_penalizacion_"+id_pro+"["+conDeductivas+"]' id='id_avance"+conDeductivas+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            penalizaciones,
            "          </select>",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control fecha_deductiva' readonly redid='fechadp"+conDeductivas+"' name='fechadp_"+id_pro+"["+conDeductivas+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control monto_deductiva' id='montodp"+conDeductivas+"' name='montodp_"+id_pro+"["+conDeductivas+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDeductiva' data-id='"+conDeductivas+"' data-pro='"+id_pro+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos_deductiva_"+id_pro+" tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('deductiva[' + conDeductivas + ']', archivoValidador);
        validador.addField('id_avance_'+id_pro+'[' + conDeductivas + ']', archivoValidador);
        validador.addField('id_penalizacion_'+id_pro+'[' + conDeductivas + ']', archivoValidador);
        validador.addField('fechadp_'+id_pro+'[' + conDeductivas + ']', tipoArchivoValidador);
        validador.addField('montodp_'+id_pro+'[' + conDeductivas + ']', tipoArchivoValidador);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        $('.fecha_deductiva').datepicker({
            todayHighlight: true,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $(".monto_deductiva").inputmask('$ 999,999,999.99', {
            numericInput: true
        });


    };

    var delArchivoDeductiva = function () {

        jQuery(document).on("click", ".hrefEliminarDeductiva" , function(e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            var id_pro = $(this).attr("data-pro");
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('deductiva[' + idDocumento + ']');
            validador.removeField('id_avance_'+id_pro+'[' + idDocumento + ']');
            validador.removeField('fechadp_'+id_pro+'[' + idDocumento + ']');
            validador.removeField('montodp_'+id_pro+'[' + idDocumento + ']');
            $('#trDocumentoDP'+idDocumento+"_"+id_pro).remove();//elimina el elemento
        });


    };



    return {

        //main function to initiate the module
        init: function() {
            initEvents();
            validacion();
            initSwalEliminar();
            initSwalEliminarAvance();
            initSwalEliminarDeductiva();
        },

    };

}();

jQuery(document).ready(function() {
    Modulo.init();

    $('#fecha_pago').datepicker({
        todayHighlight: true,
        language: "es",
        format: "dd/mm/yyyy",
    });

    $(".tp1").click(function(){
        var proyecto = $(this).attr('data-id');
        var pro_op_abierto= ".abierto_"+proyecto;
        var pro_op_cerrado= ".cerrado_"+proyecto;
        console.log(proyecto);
        $(pro_op_abierto).show();
        $(pro_op_cerrado).hide();
    });

    $(".tp2").click(function(){
        var proyecto = $(this).attr('data-id');
        var pro_op_abierto= ".abierto_"+proyecto;
        var pro_op_cerrado= ".cerrado_"+proyecto;
        console.log(proyecto);
        $(pro_op_cerrado).show();
        $(pro_op_abierto).hide();
    });
});

    const formatoMexico = (number) => {
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    }

function updatepresupuesto(ish){
    var tot = ish.replace(/_/g, "");
    var val_tot = tot.replace(/,/g, "");
    var total =val_tot.replace(/[^0-9\.]+/g,"");
    var  iva = 0.16 * total;
    // alert(iva);
    document.getElementById("iva_up").value = iva;
}



$(".kdatatable_proyectos").DataTable({
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


$("#select_licitacion_edit").click(function(){
    var licitacion = document.getElementById("no_licitacion").value;
    var proyecto = document.getElementById("proyecto_id").value;

    if(licitacion == 0){
        Swal.fire("Para continuar es necesario que selecciones una licitación");
    }else{
        Swal.fire("Espere un momento, la información esta siendo procesada");
        // document.getElementById("submit_fuente_edit").submit();
        window.location.href = "/proyecto/editar-proyecto/"+proyecto+/op/+licitacion;
    }
});


$("#send_pago").click(function(){
    var fecha_pago = document.getElementById("fecha_pago").value;
    var monto_pago = document.getElementById("monto_pago").value;
    if(fecha_pago == "" || monto_pago == ""){
        Swal.fire("Para continuar debes agregar los datos solicitados");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_pago_contrato").submit();
    }
});

$(".eliminar-pago").click(function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
      title: "Estas seguro de eliminar el pago con fecha "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_delete_pago").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("pago_delete_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});

$('#no_licitacion').on('change', function() {
    var datos = {
        'licitacion' : this.value
    }
    var id_licitacion =  this.value;
    $.ajax({
        type:"POST",
        url:$('#obtenerlicitacion').val(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: datos,
        dataType: 'JSON',
        success: function (response) {
            if(response.ok == 1) {
                // Swal.fire(response.dos);
                $('#id_clientes').val(response.cliente);
                $("#id_clientes").select2();

                $('#id_contrato').val(response.contratacion);
                $("#id_contrato").select2();

                document.getElementById("titulo_servicio").value = response.servicio;
                document.getElementById("licitacion_edit").value = id_licitacion;

            } else {
                // Swal.fire("error");
            }
        }
    });
});


  $(".kdatatable_unidades_proyectos").DataTable({
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


