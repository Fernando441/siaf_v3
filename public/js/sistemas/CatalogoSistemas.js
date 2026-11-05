$("#kdatatable_inventario").DataTable({
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