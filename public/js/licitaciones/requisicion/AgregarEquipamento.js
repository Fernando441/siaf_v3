"use strict";
var Modulo = function () {

    var listaEquipamentos = '';
    var listaTipoVehiculos = '';
    var listaEntidadFederativa = '';
    var listaTipoPlacas = '';
    var listaCombustible = '';


    var cantidad_partida = 0;
    cantidad_partida = $("#cantidad_partida").val();

    //indices contadores de elementos agregados en los formularios
    var contadorDocumentos = 0;
    var contadorAseguramiento = 0;
    var contadorEmplacamiento = 0;
    var contadorEntrega = 0;

    //validadores de los formularios
    var validador; //validador del formulario Informacion Legal

    var validacion = function () {

        //obtenemos el formulario por su id      
        const form = document.getElementById('formAgregarInformacion');

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
        ).on('core.form.valid', function () {
            toastr.success("Guardando, Por favor Espere...");
        }).on('core.form.invalid', function () {
            toastr.warning("Por favor, Ingrese la información marcada en rojo.");
            KTUtil.scrollTop();
        });



        //validar y enviar formulario
        $("#btnGuardarInformacion").click(function (e) {
            e.preventDefault();
            validador.validate().then(function (status) {
                if (status === 'Valid') {
                    var btnGuardar = document.getElementById('btnGuardarInformacion');
                    KTUtil.btnWait(btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
                    form.submit();
                }
            });
        });

    };

    var inicioControles = function () {

        listaEquipamentos = construyeEquipamento();
        listaTipoVehiculos = construyeAseguramietno();
        listaEntidadFederativa = construyeEntidadFederativa();
        listaTipoPlacas = construyeTipoPlacas();
        listaCombustible = construyeCombustible();


        $(".buttonAgregarRegistro").on("click", function (event) {
            event.preventDefault();
            addArchivo();
        });

        $(".buttonAgregarRegistro2").on("click", function (event) {
            event.preventDefault();
            addArchivo2();
        });

        $(".buttonAgregarRegistro3").on("click", function (event) {
            event.preventDefault();
            addArchivo3();
        });

        $(".buttonAgregarRegistro4").on("click", function (event) {
            event.preventDefault();
            addArchivo4();
        });


        delArchivo();
        delArchivo2();
        delArchivo3();
        delArchivo4();

        var table = $('#tblRegistros').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
                url: $("#datatable_i18n").val(),
            },
        });

        var table2 = $('#tblRegistros2').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
                url: $("#datatable_i18n").val(),
            },
        });

        var table3 = $('#tblRegistros3').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
                url: $("#datatable_i18n").val(),
            },
        });

        var table4 = $('#tblRegistros4').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                lengthMenu: "Display _MENU_",
                url: $("#datatable_i18n").val(),
            },
        });


    };


    var construyeEquipamento = function () {
        var tipoArchivo = $("#cadena_grupo").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";

        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
        });

        return opcion;
    };


    var construyeAseguramietno = function () {
        var tipoArchivo = $("#cadena_tipo_transporte").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";

        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
        });

        return opcion;
    };

    var construyeEntidadFederativa = function () {
        var tipoArchivo = $("#cadena_entidad_federativa").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";
        
        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
        });

        return opcion;
    };

    var construyeTipoPlacas = function () {
        var tipoArchivo = $("#cadena_tipo_placas").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";
        
        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
        });

        return opcion;
    };

    var construyeCombustible = function () {
        var tipoArchivo = $("#cadena_combustible").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion = "";

        $.each(colTipoArchivo, function (i, item) {
            opcion += "<option value='" + i + "' >" + item + "</option>";
        });

        return opcion;
    };



    //Validador de elementos agregados para archivo
    const validarInput = {
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
                        <input type='number' class='form-control' name='cantidad[${contadorDocumentos}]' id='cantidad${contadorDocumentos}' required min='1' max='${cantidad_partida}'>
                    </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='select_grupo[${contadorDocumentos}]' id='select_grupo${contadorDocumentos}' required>
                        <option value=''>Selecciona una opción</option>
                        ${listaEquipamentos}
                    </select>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <div class='custom-file'>
                        <input type='file' class='custom-file-input' id='select_subgrupo${contadorDocumentos}' name='select_subgrupo[${contadorDocumentos}]' required />
                        <label class='custom-file-label' for='archivo"+contadorDocumentos+"'>Selecciona un archivo</label>
                    </div>

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
        $("#tblRegistros tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('select_grupo[' + contadorDocumentos + ']', validarInput);
        validador.addField('select_subgrupo[' + contadorDocumentos + ']', validarInput);
        validador.addField('cantidad[' + contadorDocumentos + ']', validarInput);
        validador.addField('observaciones[' + contadorDocumentos + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };


    var addArchivo2 = function () {
        contadorAseguramiento++;
        var html = '';
        html += (`
            <tr id='trDocumentoAseguramiento${contadorAseguramiento}'>
                <td>
                    <div class='form-group mb-0'>
                        <input type='number' class='form-control' name='cantidad_aseguramiento[${contadorAseguramiento}]' id='cantidad_aseguramiento${contadorAseguramiento}' required min='1' max='${cantidad_partida}'>
                    </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='select_tipo_transporte[${contadorAseguramiento}]' id='select_tipo_transporte${contadorAseguramiento}' required>
                        <option value=''>Selecciona una opción</option>
                        ${listaTipoVehiculos}
                    </select>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <div class='custom-file'>
                        <input type='file' class='custom-file-input' id='select_cobertura${contadorAseguramiento}' name='select_cobertura[${contadorAseguramiento}]' required/>
                        <label class='custom-file-label' for='archivo"+contadorAseguramiento+"'>Selecciona un archivo</label>
                    </div>

                </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <div class="input-group date">
                        <input type="text" class="form-control" readonly  placeholder="Select date" name="vigencia[${contadorAseguramiento}]" id="vigencia${contadorAseguramiento}" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <div class="input-group date">
                        <input type="text" class="form-control" readonly  placeholder="Select date" name="vigenciafin[${contadorAseguramiento}]" id="vigenciafin${contadorAseguramiento}" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                        <input type='text' class='form-control' name='observaciones_aseguramiento[${contadorAseguramiento}]' id='observaciones_aseguramiento${contadorAseguramiento}' required>
                    </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistro2' data-id='${contadorAseguramiento}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblRegistros2 tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('cantidad_aseguramiento[' + contadorAseguramiento + ']', validarInput);
        validador.addField('select_tipo_transporte[' + contadorAseguramiento + ']', validarInput);
        validador.addField('select_cobertura[' + contadorAseguramiento + ']', validarInput);
        validador.addField('vigencia[' + contadorAseguramiento + ']', validarInput);
        validador.addField('vigenciafin[' + contadorAseguramiento + ']', validarInput);
        validador.addField('observaciones_aseguramiento[' + contadorAseguramiento + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        $('#vigencia' + contadorAseguramiento).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

        $('#vigenciafin' + contadorAseguramiento).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

    };

    var addArchivo3 = function () {
        contadorEmplacamiento++;
        var html = '';
        html += (`
            <tr id='trDocumentoEmplacamiento${contadorEmplacamiento}'>
                <td>
                    <div class='form-group mb-0'>
                        <input type='number' class='form-control' name='cantidad_emplacamiento[${contadorEmplacamiento}]' id='cantidad_emplacamiento${contadorEmplacamiento}' required min='1' max='${cantidad_partida}'>
                    </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='select_entidad_federativa[${contadorEmplacamiento}]' id='select_entidad_federativa${contadorEmplacamiento}' required>
                        <option value=''>Selecciona un opción</option>
                        ${listaEntidadFederativa}
                    </select>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='select_tipo_placas[${contadorEmplacamiento}]' id='select_tipo_placas${contadorEmplacamiento}' required>
                        <option value=''>Selecciona una opcion</option>
                        ${listaTipoPlacas}
                    </select>
                </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistro3' data-id='${contadorEmplacamiento}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblRegistros3 tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('cantidad_emplacamiento[' + contadorEmplacamiento + ']', validarInput);
        validador.addField('select_entidad_federativa[' + contadorEmplacamiento + ']', validarInput);
        validador.addField('select_tipo_placas[' + contadorEmplacamiento + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

    };

    var addArchivo4 = function () {
        contadorEntrega++;
        var html = '';
        html += (`
            <tr id='trDocumentoEntrega${contadorEntrega}'>
                <td>
                    <div class='form-group mb-0'>
                        <input type='number' class='form-control' name='cantidad_entrega[${contadorEntrega}]' id='cantidad_entrega${contadorEntrega}' required min='1' max='${cantidad_partida}'>
                    </div>
                </td>
                <td>
                    <div class='form-group mb-0'>
                    <div class="input-group date">
                    <input type="text" class="form-control" readonly  placeholder="Select date" name="fecha_entrega[${contadorEntrega}]" id="fecha_entrega${contadorEntrega}" required/>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                    </div>
                    </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='entrega_entidad_federativa[${contadorEntrega}]' id='entrega_entidad_federativa${contadorEntrega}' required>
                        <option value=''>Selecciona un opción</option>
                        ${listaEntidadFederativa}
                    </select>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <input type='text' class='form-control' name='entrega_municipio[${contadorEntrega}]' id='entrega_municipio${contadorEntrega}' required>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <input type='text' class='form-control' name='entrega_localidad[${contadorEntrega}]' id='entrega_localidad${contadorEntrega}' required>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <select class='form-control' name='select_combustible[${contadorEntrega}]' id='select_combustible${contadorEntrega}' required>
                        <option value=''>Selecciona una opcion</option>
                        ${listaCombustible}
                    </select>
                </div>
                </td>
                <td>
                <div class='form-group mb-0'>
                    <input type='text' class='form-control' name='entrega_observaciones[${contadorEntrega}]' id='entrega_observaciones${contadorEntrega}' required>
                </div>
                </td>
                <td>
                    <a href='#' class='btn btn-clean btn-icon btn-outline-success buttonBorrarRegistro4' data-id='${contadorEntrega}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                        <i class='flaticon-delete'></i>
                    </a>
                </td>
            </tr>
            `);
        $("#tblRegistros4 tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField('cantidad_entrega[' + contadorEntrega + ']', validarInput);
        validador.addField('fecha_entrega[' + contadorEntrega + ']', validarInput);
        validador.addField('entrega_entidad_federativa[' + contadorEntrega + ']', validarInput);
        validador.addField('entrega_municipio[' + contadorEntrega + ']', validarInput);
        validador.addField('entrega_localidad[' + contadorEntrega + ']', validarInput);
        validador.addField('select_combustible[' + contadorEntrega + ']', validarInput);
        validador.addField('entrega_observaciones[' + contadorEntrega + ']', validarInput);
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado

        $('#fecha_entrega' + contadorEntrega).datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

    };


    $(document).on('change', 'select[id^="select_grupo"]', function () {
        var id = $(this).attr('id');
        var idGrupo = $(this).val();
        var idDocumento = id.replace('select_grupo', '');
        var url = $('#url_subgrupos').val();
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
                $('#select_subgrupo' + idDocumento).html(html);

                validador.addField('select_subgrupo[' + idDocumento + ']', validarInput);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).on('change', 'select[id^="select_tipo_transporte"]', function () {
        var id = $(this).attr('id');
        var idGrupo = $(this).val();
        var idDocumento = id.replace('select_tipo_transporte', '');
        var url = $('#url_coberturas').val();
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
                $('#select_cobertura' + idDocumento).html(html);

                validador.addField('select_cobertura[' + idDocumento + ']', validarInput);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    var delArchivo = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('select_grupo[' + idDocumento + ']');
            validador.removeField('select_subgrupo[' + idDocumento + ']');
            validador.removeField('cantidad[' + idDocumento + ']');
            validador.removeField('observaciones[' + idDocumento + ']');
            $('#trDocumento' + idDocumento).remove();//elimina el elemento
        });
    };

    var delArchivo2 = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro2", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('cantidad_aseguramiento[' + idDocumento + ']');
            validador.removeField('select_tipo_transporte[' + idDocumento + ']');
            validador.removeField('select_cobertura[' + idDocumento + ']');
            validador.removeField('vigencia[' + idDocumento + ']');
            validador.removeField('vigenciafin[' + idDocumento + ']');
            validador.removeField('observaciones_aseguramiento[' + idDocumento + ']');
            $('#trDocumentoAseguramiento' + idDocumento).remove();//elimina el elemento
        });
    };

    var delArchivo3 = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro3", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('cantidad_emplacamiento[' + idDocumento + ']');
            validador.removeField('select_entidad_federativa[' + idDocumento + ']');
            validador.removeField('select_tipo_placas[' + idDocumento + ']');
            $('#trDocumentoEmplacamiento' + idDocumento).remove();//elimina el elemento
        });
    };

    var delArchivo4 = function () {
        jQuery(document).on("click", ".buttonBorrarRegistro4", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField('cantidad_entrega[' + idDocumento + ']');
            validador.removeField('fecha_entrega[' + idDocumento + ']');
            validador.removeField('entrega_entidad_federativa[' + idDocumento + ']');
            validador.removeField('entrega_municipio[' + idDocumento + ']');
            validador.removeField('entrega_localidad[' + idDocumento + ']');
            validador.removeField('select_combustible[' + idDocumento + ']');
            validador.removeField('entrega_observaciones[' + idDocumento + ']');
            $('#trDocumentoEntrega' + idDocumento).remove();//elimina el elemento
        });
    };

    var initSwalEliminar = function () {
        $(".hrefEliminarDocumento").click(function (e) {

            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Desea eliminar el registro?",
                text: "El registro se eliminara.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar registro",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#desactivarEquipamiento').val(),
                        data: {
                            id: id,
                            partida_id: $('#partida_id').val(),
                            requisicion_id: $('#requisicion_id').val(),
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function () {
                        }
                    }).done(function (data) {
                        $('#trRegistro' + id).remove();

                        KTApp.hideTooltips();
                        toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success("El registro se elimino correctamente.");
                    });
                }
            });
        });
    };

    var initSwalEliminarAseguramiento = function () {
        $(".hrefEliminarDocumento2").click(function (e) {

            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Desea eliminar el registro?",
                text: "El registro se eliminara.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar registro",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#desactivarAseguramiento').val(),
                        data: {
                            id: id,
                            partida_id: $('#partida_id').val(),
                            requisicion_id: $('#requisicion_id').val(),
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function () {
                        }
                    }).done(function (data) {
                        $('#trRegistroAseguramiento' + id).remove();

                        KTApp.hideTooltips();
                        toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success("El registro se elimino correctamente.");
                    });
                }
            });
        });
    };

    var initSwalEliminarEmplacamiento = function () {
        $(".hrefEliminarDocumento3").click(function (e) {

            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Desea eliminar el registro?",
                text: "El registro se eliminara.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar registro",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#desactivarEmplacamiento').val(),
                        data: {
                            id: id,
                            partida_id: $('#partida_id').val(),
                            requisicion_id: $('#requisicion_id').val(),
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function () {
                        }
                    }).done(function (data) {
                        $('#trRegistroEmplacamiento' + id).remove();

                        KTApp.hideTooltips();
                        toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success("El registro se elimino correctamente.");
                    });
                }
            });
        });
    };
    
    var initSwalEliminarLugarEntrega = function () {
        $(".hrefEliminarDocumento4").click(function (e) {

            e.preventDefault();
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "¿Desea eliminar el registro?",
                text: "El registro se eliminara.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar registro",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: $('#desactivarLugarEntrega').val(),
                        data: {
                            id: id,
                            partida_id: $('#partida_id').val(),
                            requisicion_id: $('#requisicion_id').val(),
                            _token: $("[name='_token']").val()
                        },
                        beforeSend: function () {
                        }
                    }).done(function (data) {
                        $('#trRegistroLugarEntrega' + id).remove();

                        KTApp.hideTooltips();
                        toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success("El registro se elimino correctamente.");
                    });
                }
            });
        });
    };

    return {

        //main function to initiate the module
        init: function () {
            inicioControles();
            validacion();
            initSwalEliminar();
            initSwalEliminarAseguramiento();
            initSwalEliminarEmplacamiento();
            initSwalEliminarLugarEntrega();
        },

    };

}();

jQuery(document).ready(function () {
    Modulo.init();
});

