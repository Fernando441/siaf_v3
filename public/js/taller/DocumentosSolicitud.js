"use strict";
var SolicitarAtencion = (function () {
  //validadores de los formularios
  var validador;
  var contadorDocumentos = 0;
  var listaDocumentos = "";

  var inicioControles = function () {
    listaDocumentos = construyeTipoDocumentos();

    $(".hrefAgregarOtroDocumento").on("click", function (event) {
      event.preventDefault();
      addArchivo();
    });

    delArchivo();
    eliminarArchivo();
  };



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

  //construye  elementos de la lista tipo de documentos
  var construyeTipoDocumentos = function () {
    var tipoArchivo = $("#tipoDocumentos").val();
    var colTipoArchivo = JSON.parse(tipoArchivo);
    var opcion = "";

    $.each(colTipoArchivo, function (i, item) {
      opcion += "<option value='" + i + "' >" + item + "</option>";
    });

    return opcion;
  };

  //Validador de elementos agregados para archivo
  const tipoArchivoValidador = {
    validators: {
      notEmpty: {
        message: "Por favor introduce un valor",
      },
    },
  };
  //Validador de elementos agregados para archivo
  const archivoValidador = {
    validators: {
      notEmpty: {
        message: "Por favor introduce un valor",
      },
      file: {
        extension: "jpeg,jpg,png,pdf,doc,xls,gif,ppt,bmp,docx,xlsx,pptx",
        type: "image/jpeg,image/png,application/pdf,application/msword,application/vnd.ms-excel,image/gif,application/vnd.ms-powerpoint,image/x-ms-bmp,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation",
        message:
          "Por favor ingrese un archivo válido, solo se permite imágenes, archivos de office y PDF",
      },
    },
  };

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
                            <select class='form-control' name='id_tipo_documento[${contadorDocumentos}]' id='id_tipo_documento${contadorDocumentos}' required>
                                <option value=''>Selecciona un opción</option>
                                ${listaDocumentos}
                            </select>
                        </div>
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
      "id_tipo_documento[" + contadorDocumentos + "]",
      tipoArchivoValidador
    );
    KTApp.initTooltips(); //inicia tooltip del elemento creado
    KTApp.initFileInput(); //inicia el elemento archivo del elemento creado
    KTApp.hideTooltips();
  };

  var delArchivo = function () {
    jQuery(document).on("click", ".hrefEliminarDocumento", function (e) {
        var id = $(this).data("id");
        $("#trDocumento" + id).remove();        
        validador.removeField("archivo[" + id + "]", archivoValidador);
        validador.removeField("id_tipo_documento[" + id + "]", tipoArchivoValidador);
        KTApp.initTooltips();
        KTApp.hideTooltips();
    });
  };

  var eliminarArchivo = function () {
    jQuery(document).on("click", ".eliminarArchivo", function (e) {
        var id = $(this).data("id");
        // swal que pregunta si desea eliminar el archivo 
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí, bórralo!",
            cancelButtonText: "¡No, cancelar!",
            reverseButtons: true,
        }).then(function (result) {
            if (result.value) {
              var urlEliminarArchivo = $("#urlEliminarArchivo").val();
                $.ajax({
                    url: urlEliminarArchivo,
                    type: "POST",
                    data: {
                        id: id,
                        _token: $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire("¡Eliminado!", data.message, "success");
                            $("#tblDocumentos").DataTable().ajax.reload();
                        } else {
                            Swal.fire("¡Error!", data.message, "error");
                        }
                    },
                    error: function (data) {
                        toastr.error(data.message);
                    },
                });
            }
        });
    });
  };

  var toggleInformacion = function () {
    var toggleInformacionButton = document.getElementById("toggleInformacion");
    var informacion = document.getElementById("informacion");
    //toggle informacion div when toggleInformacionButton is clicked
    toggleInformacionButton.addEventListener("click", function () {
      $("#informacion").toggle();
      if (informacion.style.display === "none") {
        KTApp.hideTooltips();
        toggleInformacionButton.innerHTML = '<i class="fas fa-angle-down"></i>';
        toggleInformacionButton.setAttribute(
          "data-original-title",
          "Mostrar información"
        );
      } else {
        KTApp.hideTooltips();
        toggleInformacionButton.innerHTML = '<i class="fas fa-angle-up"></i>';
        toggleInformacionButton.setAttribute(
          "data-original-title",
          "Ocultar información"
        );
      }
    });
  };

  var initTable = function () {

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

        ajax: {
          url: $("#documentosdatatable").val(),
          type: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          data: {
            id: $("#taller_solicitud_id").val(),
            columnsDef: [
              "id",
              "documento",
              "taller_solicitud_tipo_documento_id",
              "acciones",
            ],
          },
        },
        columns: [
          { data: "id" },
          { data: "documento", orderable: true },
          { data: "taller_solicitud_tipo_documento_id", orderable: true },
          { data: "acciones", responsivePriority: -1 },
        ],

        columnDefs: [
          {
            width: "110px",
            targets: -1,
            title: "Opciones",
            orderable: false,
            render: function (data, type, full, meta) {
              return `<button class="btn btn-sm btn-clean btn-hover-icon-success btn-icon eliminarArchivo" data-id="${full.id}" data-documento="${full.documento}" data-toggle="tooltip" data-theme="dark" title="Eliminar Archivo">
                                    <i class="flaticon-delete "></i>`;
            },
          },
          {
            width: "110px",
            targets: 1,
            title: "Documento",
            orderable: false,
            render: function (data, type, full, meta) {
              var get_archivo = $("#get_archivo").val();
              var url = get_archivo.substring(0, get_archivo.lastIndexOf("/"));
              return `<a href='${url}/${full.id}' target='_blank' title='Ver documento' data-toggle='tooltip' data-theme='dark' data-placement='top'>${full.documento}</a>`;
            },
          },
        ],

        drawCallback: function (settings, json) {
          KTApp.initTooltips();
        },
      })
      .on("init.dt", function () {});

    var filter = function () {
      var val = $.fn.dataTable.util.escapeRegex($(this).val());
      table
        .column($(this).data("col-index"))
        .search(val ? val : "", false, false)
        .draw();
    };

    $(".kt-input").on("keyup change", function () {
      var that = this;
      if (that.timer) {
        clearTimeout(that.timer);
      }
      that.timer = setTimeout(function () {
        filter.call(that);
      }, 200);
    });

    $("#kt_reset").on("click", function (e) {
      e.preventDefault();
      $(".datatable-input").each(function () {
        $(this).val("");
        table.column($(this).data("col-index")).search("", false, false);
      });
      table.table().draw();
    });
  };

  return {
    //main function to initiate the module
    init: function () {
      validacion();
      initTable();
      inicioControles();
      $("#informacion").toggle();
      toggleInformacion();
    },
  };
})();

jQuery(document).ready(function () {
  SolicitarAtencion.init();
});




