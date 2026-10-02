
$("#kdatatable_tramite").DataTable({
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

$(".eliminar_tenencia").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_eliminar_tenencia").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("tenencia_eliminar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});


$(".eliminar_verificacion").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_eliminar_verificacion").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("verificacion_eliminar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});

$(".eliminar_aseguramiento").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_eliminar_aseguramiento").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("aseguramiento_eliminar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});

$(".eliminar_bv_siniestro").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_eliminar_bv_siniestro").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("bv_siniestro_eliminar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});

$(".eliminar_cambiopropietario").click(function(){
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    Swal.fire({
      title: "Estas seguro de eliminar el registro "+nombre,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminarlo!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
    }).then(function(result) {
      if (result.value) {
        document.getElementById("id_eliminar_cambiopropietario").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("cambiopropietario_eliminar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});



$("#send_evidencia_tramite").click(function(){
    var file_carga = document.getElementById("file_carga").value;
    if(file_carga == ""){
        Swal.fire("Para continuar debes agregar el documento");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_evidencia").submit();
    }
});
