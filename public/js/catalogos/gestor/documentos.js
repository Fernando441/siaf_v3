"use strict";
var gestorDucumentos = (function () {
    var listaDocumentos = "";
    var contadorDocumentos = 0;
    var validador;

    var validacion = function () {
        //obtenemos el formulario por su id
        const form = document.getElementById("form_documentos");

        //validador de formulario
        validador = FormValidation.formValidation(form, {
            locale: "es_ES",
            localization: FormValidation.locales.es_ES,
            fields: {},
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                declarative: new FormValidation.plugins.Declarative({
                    html5Input: true,
                }),
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                }),
            },
        })
            .on("core.form.valid", function () {
                toastr.success("Guardando, Por favor Espere...");
            })
            .on("core.form.invalid", function () {
                toastr.warning("Por favor, Ingrese la información marcada en rojo.");
                KTUtil.scrollTop();
            });

        //validar y enviar formulario
        $("#btnGuardarDocumentos").click(function (e) {
            e.preventDefault();
            validador.validate().then(function (status) {
                if (status === "Valid") {
                    var btnGuardar = document.getElementById("btnGuardarDocumentos");
                    KTUtil.btnWait(
                        btnGuardar,
                        "spinner spinner-right spinner-white pr-15",
                        "Espere...",
                        true
                    );
                    form.submit();
                }
            });
        });
    };

    var inicioControles = function () {

        $(".hrefAgregarOtroDocumento").on("click", function (event) {
            event.preventDefault();
            addArchivo();
        });

        delArchivo();
    };


    $.fn.dataTable.Api.register("column().title()", function () {
        return $(this.header()).text().trim();
    });

    const archivoValidador = {
        validators: {
            notEmpty: {
                message: "Por favor introduce un valor",
            },
            file: {
                extension:
                    "jpeg,jpg,png,pdf,doc,xls,gif,ppt,bmp,docx,xlsx,pptx,zip,rar,7z,txt",
                type: "image/jpeg,image/png,application/pdf,application/msword,application/vnd.ms-excel,image/gif,application/vnd.ms-powerpoint,image/x-ms-bmp,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip,application/x-rar-compressed,application/x-7z-compressed,text/plain,application/x-zip-compressed,application/x-rar-compressed",
                message:
                    "Por favor ingrese un archivo válido, solo se permite imágenes, archivos de office, pdf, zip, rar, 7z y txt",
            },
        },
    };

    //Validador de elementos agregados para archivo
    const tipoArchivoValidador = {
        validators: {
            notEmpty: {
                message: "Por favor introduce un valor",
            },
        },
    };

    //initialize datetimepicker
    var initFechaInput = function () {
        $(".kt_datetimepicker").datetimepicker({
            locale: "es",
        });
    };

    //agrega el elemento archivo y lista desplegable para el formulario Legal
    var addArchivo = function () {
        contadorDocumentos++;
        var html = "";
        html += `<tr id='trDocumento${contadorDocumentos}' class='text-center'>
                    <td>
                        <div class='form-group mb-0'>
                            <div class='custom-file'>
                                <input type='file' class='custom-file-input' id='archivo${contadorDocumentos}' name='archivo[${contadorDocumentos}]' required />
                                <label class='custom-file-label' for='archivo_documento${contadorDocumentos}'>Selecciona un archivo</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class='form-group mb-0'>
                          <input type='text' class='form-control' name='id_tipo_comentario[${contadorDocumentos}]' id='id_tipo_comentario${contadorDocumentos}'  required size='150' /></div>
                    </td>
                    <td>
                        <a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarDocumento' data-id='${contadorDocumentos}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                            <i class='flaticon-delete'></i>
                        </a>
                    </td>
                </tr>`;
        $("#tblFormDocumentos tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField("archivo[" + contadorDocumentos + "]", archivoValidador);

        validador.addField(
            "id_tipo_comentario[" + contadorDocumentos + "]",
            tipoArchivoValidador
        );

        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
        initFechaInput(); //inicia el elemento fecha del elemento creado
    };

    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminarDocumento", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField("archivo[" + idDocumento + "]");
            validador.removeField("id_tipo_comentario[" + idDocumento + "]");
            $("#trDocumento" + idDocumento).remove(); //elimina el elemento
        });
    };

    var initTable1 = function () {
        // begin first table
        const urlarchivo = $("#urlarchivo").val();
        var table = $("#tblDocumentos")
            .DataTable({
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

                processing: true,
                serverSide: true,
                order: [[1, "desc"]],

                ajax: {
                    url: $("#gestordatatable").val(),
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: function (d) {
                        d.id_gestor = $('#id_gestor').val();
                        d.columnsDef = [
                            "id",
                            "documento",
                            "descripcion",
                            "acciones",
                        ];
                    },
                },
                columns: [
                    { data: "id" },
                    { data: "documento", orderable: true },
                    { data: "descripcion", orderable: true },
                    { data: "acciones", responsivePriority: -1 },
                ],

                columnDefs: [
                    {
                        width: "110px",
                        targets: -1,
                        title: "Opciones",
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return `<button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon" onClick="eliminarArchivo('${full.id}','${full.documento}')" data-id="${full.id}" data-documento="${full.documento}" data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo">
                                    <i class="flaticon-delete "></i>`;
                        },
                    },
                    {
                        targets: 1,
                        title: "Documento",
                        orderable: false,
                        render: function (data, type, full, meta) {
                        return `
                        <div class="d-flex align-items-center">
                        
                        <a href='${urlarchivo}/archivo/documento-gestores/${full.id}' target='_blank' data-toggle="tooltip" data-theme="dark" title="Descargar Archivo">${full.documento}</a>
                        </div>
                        `;
                        },
                    },
                ],

                drawCallback: function (settings, json) {
                    KTApp.initTooltips();
                },
            })
            .on("init.dt", function () { });



        var filter = function () {
            var filters = {
                search: $('#search').val(),
                tipoDocumento: $('#busquedaTipoDocumento').val(),
                year: $('#year').val(),
                month: $('#month').val(),
                day: $('#day').val()
            };

            table.search(JSON.stringify(filters)).draw();
        };

        $(".kt-input").on("keyup change", function () {
            setTimeout(function () {
                table.ajax.reload();
            }, 2000);
        });

        $("#busquedaTipoDocumento, #year, #month, #day").on("change", function () {
            table.ajax.reload();
        });

        $('[data-switch=true]').bootstrapSwitch().on('switchChange.bootstrapSwitch', function (event, state) {
            $('#mostrarArchivosSubidosPorMi').val(state);
            table.ajax.reload();
        });

        $("#kt_reset").on("click", function (e) {
            e.preventDefault();
            $("#search").val("");
            $("#busquedaTipoDocumento").val("").trigger("change");
            $("#fechaInicio").val("");
            $("#year").val("").trigger("change");
            $("#month").val("").trigger("change");
            $("#day").val("").trigger("change");
            table.ajax.reload();
        });

    };

    return {
        //main function to initiate the module
        init: function () {
            initTable1();
            inicioControles();
            validacion();
        },
    };
})();

jQuery(document).ready(function () {
    gestorDucumentos.init();

    new ClipboardJS("[data-clipboard=true]").on("success", function (e) {
        e.clearSelection();
        toastr.success("Documento copiado correctamente.");
    });



});

function eliminarArchivo(id, documento) {
    var id = id;
    var documento = documento;
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
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: $("#eliminarArchivo").val(),
                data: {
                    id: id,
                    documento: documento,
                    _token: $("[name='_token']").val(),
                },
                beforeSend: function () { },
            }).done(function (data) {
                $("#tblDocumentos").DataTable().ajax.reload();
                KTApp.hideTooltips();
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                };
                toastr.success("El documento se elimino correctamente.");
            });
        }
    });
}
