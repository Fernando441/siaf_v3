$("#kdatatable_inventario").DataTable({
  lengthMenu: [10, 25, 50, 100],
  pageLength: 25,
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

$("#carga_masiva_equ").click(function(){

  var num_carga = document.getElementById("num_carga").value;
    if(num_carga == 0){
      document.getElementById("num_carga").value= 1;
      $("#div_cargamasiva").show();
    }

    if(num_carga == 1){
      var op = 0;
      document.getElementById("num_carga").value=0;
      $("#div_cargamasiva").hide();
    }

});


  $("#send_carga").click(function(){

    var file_carga = document.getElementById("file_carga").value;

     if(file_carga == ""){
         Swal.fire("Para continuar debes agregar un archivo .csv");
     }else{
         Swal.fire({
             position: "top-center",
             icon: "success",
             title: "Espere un momento, la información esta siendo procesada",
             showConfirmButton: false
         });
         document.getElementById("submit_carga").submit();
     }
});

  

$(".desctiva_reg").click(function(){
  var id = $(this).data('id');
  var nombre = $(this).data('nombre');

  document.getElementById("id_equipo").value = id;
  document.getElementById("no_serie").value = nombre;

});

$("#send_desactivar").click(function(){
    var id_motivo_concurso = document.getElementById("id_motivo_concurso").value;
    if(id_motivo_concurso == ""){
        Swal.fire("Para continuar debes agregar el motivo por el cual desactivas el registro");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_desactivar").submit();
    }
});


$(".activar-registro").click(function() {
  var id = $(this).data('id');
  var nombre = $(this).data('nombre');
  Swal.fire({
    title: "Estas seguro de activar el registro "+nombre,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, Activarlo!",
    cancelButtonText: "No, Cancelar!",
    reverseButtons: true,
      confirmButtonColor: "#73ab17",
      cancelButtonColor: "#cc0c73",
  }).then(function(result) {
    if (result.value) {
      document.getElementById("id_cli_act").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
      });
      document.getElementById("cli_act_form").submit();
    } else if (result.dismiss === "cancel") {
      Swal.fire(
         "Cancelada",
        "La acción fue cancelada",
        "error"
      )
    }
  });
});
