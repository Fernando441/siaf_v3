"use strict";
var ListadoRequisiciones = function () {
    var contadorDocumentos = 0;
    var validador
    var tipo_vehiculo = '';


    var initControls = function () {

        $(".hrefAgregarPartida").on("click", function (event) {
            event.preventDefault();
            addArchivo();
        });

        delArchivo();


        var tablaPartidas = $('#partidasRequisicion').DataTable({
            responsive: true,
            language: {
                'lengthMenu': 'Display _MENU_',
                "url": $('#datatable_i18n').val()
            },
            columnDefs: [
                {
                    width: '200px',
                    title: 'Opciones',
                    targets: -1,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return `
                                <a href="javascript:;" class="btn btn-sm
                                    btn-clean btn-icon btn-outline-success btn-icon-sm btnModalEditarPartida" 
                                    data-id="${full[0]}" data-descripcion="${full[1]}" data-cantidad="${full[2]}" data-observaciones="${full[3]}" title="Editar">
                                    <i class="flaticon-edit"></i>   
                                </a>
                                <a href="javascript:;" class="btn btn-sm
                                    btn-clean btn-icon btn-outline-success btn-icon-sm btnEliminarPartidaDT" data-id="${full[0]}"
                                     title="Eliminar" data-toggle="tooltip" data-theme="dark">
                                    <i class="flaticon-delete"></i>
                                </a>
                            `;
                    },
                }
            ],
        });
    };


    var validacion = function () {
        const form = document.getElementById("formPartidas");
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

        // //validar y enviar formulario
        $("#btnGuardarPartidas").click(function (e) {
            e.preventDefault();
            validador.validate().then(function (status) {
                if (status === "Valid") {
                    var btnGuardar = document.getElementById("btnGuardarPartidas");
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

    const tipoArchivoValidador = {
        validators: {
            notEmpty: {
                message: "Por favor introduce un valor",
            },
        },
    };

    var initEvents = function() {
        tipo_vehiculo = construyeElementosLista();
    };

    //construye  elementos de la lista
    var construyeElementosLista = function () {
        var tipoArchivo = $("#tipovehiculo").val();
        var colTipoArchivo = JSON.parse(tipoArchivo);
        var opcion ="";

        $.each(colTipoArchivo, function(i, item) {
            opcion += "<option value='"+i+"' >"+item+"</option>";
        });

        return opcion;
    };

    var addArchivo = function () {
        contadorDocumentos++;
        var html = "";
        html += `<tr id='trPartida${contadorDocumentos}' class='text-center'>
                    <td>
                        <div class='form-group mb-0'>
                            <select class='form-control' name='descripcion[${contadorDocumentos}]' id='descripcion${contadorDocumentos}' required>"
                                <option value=''>Selecciona un opción</option>
                                ${tipo_vehiculo}
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class='form-group mb-0'>
                            <input type='number' class='form-control' name='cantidad[${contadorDocumentos}]' id='cantidad${contadorDocumentos}' placeholder='Cantidad' required/>
                        </div>
                    </td>
                    <td>
                        <div class='form-group mb-0'>
                            <input type='text' class='form-control' name='observaciones[${contadorDocumentos}]' id='observaciones${contadorDocumentos}' placeholder='Observaciones' required/>
                        </div>
                    </td>
                    <td>
                        <a href='#' class='btn btn-clean btn-icon btn-outline-success hrefEliminarPartida' data-id='${contadorDocumentos}' data-toggle='tooltip' data-theme='dark' title='Eliminar'>
                            <i class='flaticon-delete'></i>
                        </a>
                    </td>
                </tr>`;
        $("#tblFormPartidas tbody").append(html); //agrega el html creado
        //agrega validación del elemento creado
        validador.addField(
            "descripcion[" + contadorDocumentos + "]",
            tipoArchivoValidador
        );
        validador.addField(
            "cantidad[" + contadorDocumentos + "]",
            tipoArchivoValidador
        );
        validador.addField(
            "observaciones[" + contadorDocumentos + "]",
            tipoArchivoValidador
        );
        KTApp.initTooltips(); //inicia tooltip del elemento creado
        KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    };

    var delArchivo = function () {
        jQuery(document).on("click", ".hrefEliminarPartida", function (e) {
            e.preventDefault();
            var idDocumento = $(this).attr("data-id"); //indice del elemento
            KTApp.hideTooltips(); //oculta tooltip
            //elimina la validación del elemento
            validador.removeField("descripcion[" + idDocumento + "]");
            validador.removeField("cantidad[" + idDocumento + "]");
            validador.removeField("observaciones[" + idDocumento + "]");
            $("#trPartida" + idDocumento).remove(); //elimina el elemento
        });
    };

    jQuery(document).on("click", ".btnEliminarPartidaDT", function (e) {
        e.preventDefault();
        var urlEliminarPartida = $('#url_eliminar_partida').val();
        var idPartida = $(this).attr("data-id"); //indice del elemento

        Swal.fire({
            title: "¿Estás seguro de eliminar la partida?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí, bórralo!",
            cancelButtonText: "¡No, cancelar!",
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: urlEliminarPartida,
                    data: {
                        idPartida: idPartida,
                        _token: $("[name='_token']").val(),
                    },
                    beforeSend: function () { },
                }).done(function (data) {
                    KTApp.hideTooltips();
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                    };
                    toastr.success("La partida se elimino correctamente.");
                    location.reload();
                });
            }
        });
    });

    jQuery(document).on("click", ".btnModalEditarPartida", function (e) {
        e.preventDefault();
        var modal = $('#modalEditarPartida');
        var idPartida = $(this).attr("data-id"); //indice del elemento
        var descripcion = $(this).attr("data-descripcion");
        var cantidad = $(this).attr("data-cantidad");
        var observaciones = $(this).attr("data-observaciones");
        
        modal.find('#idPartida').val(idPartida);
        modal.find('#modal_descripcion').val(descripcion);
        modal.find('#modal_cantidad').val(cantidad);
        modal.find('#modal_observaciones').val(observaciones);
        
        modal.modal('show');        

    });

    return {

        //main function to initiate the module
        init: function () {
            validacion();
            initControls();
            initEvents();
        },

    };

}();

jQuery(document).ready(function () {
    ListadoRequisiciones.init();
});

