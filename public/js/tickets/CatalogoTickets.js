$("#ticket").DataTable({
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

$(".verTicket").click(function () {
  var id = $(this).data('id');
  document.getElementById("idticket").value = id;
  document.getElementById("ticket_form").submit();
});
$(".terminarTicket").click(function () {
  var id = $(this).data('id');
  document.getElementById("idticketerminado").value = id;
  document.getElementById("ticket_terminado").submit();
});
$(".terminarTicketOriginal").click(function () {
  var id = $(this).data('id');
  document.getElementById("idticketerminadoriginal").value = id;
  document.getElementById("ticket_terminado_original").submit();
});

$(".eliminarTicket").click(function() {
  var id = $(this).data('id');
  Swal.fire({
    title: "Estas seguro de eliminar el ticket ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, Eliminar!",
    cancelButtonText: "No, Cancelar!",
    reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
  }).then(function(result) {
    if (result.value) {
      document.getElementById("idticketerminado").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
      });
      document.getElementById("ticket_terminado").submit();
    } else if (result.dismiss === "cancel") {
      Swal.fire(
         "Cancelada",
        "La acción fue cancelada",
        "error"
      )
    }
  });
});