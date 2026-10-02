"use strict";
var Modulo = function() {

    var lista = ''; //lista de elementos
    var pagos_lista = ''; //lista de elementos
    var contadorDocumentos=0; //indice contador de elementos
    var validador; //validador del formulario
    var conDocumentos=0;
    var conDeductivas=0;

    var validacion = function() {
        //validacion de formulario
        const form = document.getElementById('submit_contrato');
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

        $('#fecha_contrato').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });

        $('#fecha_vigencia').datepicker({
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
        

        $('#fecha_final_vigencia').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            language: "es",
            format: "dd/mm/yyyy",
        });


        $("#no_licitacion").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#id_emisor").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#id_clientes").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        // $("#id_contrato").select2({
        //     placeholder: "Seleccione una opción",
        //     allowClear: true
        // });

        $("#id_responsable").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#id_fuenteproyecto").select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });

        $("#presuuesto_minimo").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#importe_general").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#iva").inputmask('$ 999,999,999.99', {
            numericInput: true
        });

        $("#presuuesto_maximo").inputmask('$ 999,999,999.99', {
            numericInput: true
        });


        lista = construyeElementosLista();
        pagos_lista = construyeavancefinancieroLista();

        //botón agregar otro archivo
        $( ".hrefAgregarOtro" ).on( "click", function(event) {
            event.preventDefault();
            addArchivo();
        });

        delArchivo();

        $( ".hrefAgregarOtroAvance" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoAvanceFinanciero();
        });
        delArchivoAvance();

        $( ".hrefAgregarOtroDeductiva" ).on( "click", function(event) {
            event.preventDefault();
            addArchivoDeductivaPago();
        });
        delArchivoDeductiva();


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
            "          <select class='form-control' name='id_documento["+contadorDocumentos+"]' id='id_documento"+contadorDocumentos+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            lista,
            "          </select>",
            "       </div>" +
            "    </td>",
            "	 <td>",
            "		<a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminar' data-id='"+contadorDocumentos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
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

    // AVANCE FINANCIERO
    var addArchivoAvanceFinanciero = function () {
        conDocumentos++;
        var html = '';
        html += (["",
            "<tr id='trDocumentoAv"+conDocumentos+"'>",
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
            "               <input type='text' class='form-control fecha_avance' readonly id='fecha"+conDocumentos+"' name='fecha["+conDocumentos+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control monto_avance' id='monto"+conDocumentos+"' name='monto["+conDocumentos+"]' required />",
            "       </div>" +
            "    </td>",


            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarAvance' data-id='"+conDocumentos+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos_avance tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('pago[' + conDocumentos + ']', archivoValidador);
        validador.addField('fecha[' + conDocumentos + ']', tipoArchivoValidador);
        validador.addField('monto[' + conDocumentos + ']', tipoArchivoValidador);
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
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('pago[' + idDocumento + ']');
            validador.removeField('fecha[' + idDocumento + ']');
            validador.removeField('monto[' + idDocumento + ']');
            $('#trDocumentoAv'+idDocumento).remove();//elimina el elemento
        });
    };

    // DEDUCTIVA DE PAGO
    var addArchivoDeductivaPago = function () {
        conDeductivas++;
        var html = '';
        html += ([    "",
            "<tr id='trDocumentoDP"+conDeductivas+"'>",
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
            "          <select class='form-control' name='id_avance["+conDeductivas+"]' id='id_avance"+conDeductivas+"' required>",
            "              <option value=''>Selecciona un opción</option>",
            pagos_lista,
            "          </select>",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control fecha_deductiva' readonly id='fechadp"+conDeductivas+"' name='fechadp["+conDeductivas+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>" +
            "       <div class='form-group mb-0'>" +
            "               <input type='text' class='form-control monto_deductiva' id='montodp"+conDeductivas+"' name='montodp["+conDeductivas+"]' required />",
            "       </div>" +
            "    </td>",
            "    <td>",
            "       <a href='#' class='btn btn-sm btn-clean btn-hover-icon-success btn-icon hrefEliminarDeductiva' data-id='"+conDeductivas+"' data-toggle='tooltip' data-theme='dark' title='Eliminar'>",
            "           <i class='flaticon-delete'></i>",
            "       </a>",
            "    </td>",
            "</tr>",

            ""].join(""));
        $("#tblDocumentos_deductiva tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('deductiva[' + conDeductivas + ']', archivoValidador);
        validador.addField('id_avance[' + conDeductivas + ']', archivoValidador);
        validador.addField('fechadp[' + conDeductivas + ']', tipoArchivoValidador);
        validador.addField('montodp[' + conDeductivas + ']', tipoArchivoValidador);
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
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('deductiva[' + idDocumento + ']');
            validador.removeField('id_avance[' + idDocumento + ']');
            validador.removeField('fechadp[' + idDocumento + ']');
            validador.removeField('montodp[' + idDocumento + ']');
            $('#trDocumentoDP'+idDocumento).remove();//elimina el elemento
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

    $('#fecha_pago').datepicker({
        todayHighlight: true,
        language: "es",
        format: "dd/mm/yyyy",
    });

    $("#tp1").click(function(){
        $(".abierto").show();
        $(".cerrado").hide();
        $(".ambos").show();
    });

    $("#tp2").click(function(){
        $(".cerrado").show();
        $(".abierto").hide();
        $(".ambos").show();
    });
});


$("#select_licitacion").click(function(){
    var licitacion = document.getElementById("no_licitacion").value;

    if(licitacion == 0){
        Swal.fire("Para continuar es necesario que selecciones una licitación");

    }else{
        Swal.fire("Espere un momento, la información esta siendo procesada");
        // document.getElementById("submit_fuente_edit").submit();
        window.location.href = "/proyecto/agregar-proyecto/op/"+licitacion;
    }
});

    const formatoMexico = (number) => {
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    }

$("#tp1").click(function(){
    $(".abierto").show();
    $(".cerrado").hide();
    document.getElementById("iva_up").value = "";
    document.getElementById("importe_general").value = "";
    document.getElementById("presuuesto_minimo").value = "";
    document.getElementById("presuuesto_maximo").value = "";
});

$("#tp2").click(function(){
    $(".cerrado").show();
    $(".abierto").hide();
    document.getElementById("iva_up").value = "";
    document.getElementById("importe_general").value = "";
    document.getElementById("presuuesto_minimo").value = "";
    document.getElementById("presuuesto_maximo").value = "";
});

function updatepresupuesto(ish){
    var tot = ish.replace(/_/g, "");
    var val_tot = tot.replace(/,/g, "");
    var total =val_tot.replace(/[^0-9\.]+/g,"");
    var  iva = 0.16 * total;
    // alert(iva);
    document.getElementById("iva_up").value = iva;
    // document.getElementById("41").value = formatoMexico(iva.toFixed(2));
}


$("#kdatatable_detallevehiculo").DataTable({
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
