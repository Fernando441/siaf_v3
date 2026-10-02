"use strict";
var TablaDocumentosSolicitud = (function () {

  var initTable = function () {
    var table = $("#tablaDocumentos")
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
          url: $("#get_tabla_documentos").val(),
          type: "POST",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          data: {
            id: $("#idSolicitud").val(),
            columnsDef: [
              "id",
              "documento",
              "taller_solicitud_tipo_documento_id",
            ],
          },
        },
        columns: [
          { data: "id" },
          { data: "documento", orderable: true },
          { data: "taller_solicitud_tipo_documento_id", orderable: true },
        ],

        columnDefs: [
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
      initTable();
      $("#informacion").toggle();
    },
  };
})();

jQuery(document).ready(function () {
  TablaDocumentosSolicitud.init();
});
