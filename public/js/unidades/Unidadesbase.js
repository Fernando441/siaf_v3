

function tipobusqueda(myRadio) {
    value_busqueda = myRadio.value;
    if(value_busqueda == 0)
    {
    	$("#op_economico").show();
    	$("#op_serie").hide();
    	$("#op_placa").hide();	
    }

    if(value_busqueda == 1)
    {
    	$("#op_economico").hide();
    	$("#op_serie").show();
    	$("#op_placa").hide();	
    }
    if(value_busqueda == 2)
    {
    	$("#op_economico").hide();
    	$("#op_serie").hide();
    	$("#op_placa").show();	
    }
}


$("#btnGuardar").click(function(){

	var value = document.querySelector('input[name="busqueda"]:checked').value;
	if( value == 0)
	{
		var no_economico = document.getElementById("no_economico").value;
	    if(no_economico == ""){
	        Swal.fire("Para continuar debes agregar el No. Económico");
	    }else{
	        Swal.fire({
	            position: "top-center",
	            icon: "success",
	            title: "Espere un momento, la información esta siendo procesada",
	            showConfirmButton: false
	        });
	        document.getElementById("submit_busquedasustitutos").submit();
	    }

	}

	if( value == 1)
	{
		var no_serie = document.getElementById("no_serie").value;
	    if(no_serie == ""){
	        Swal.fire("Para continuar debes agregar el No. Serie");
	    }else{
	        Swal.fire({
	            position: "top-center",
	            icon: "success",
	            title: "Espere un momento, la información esta siendo procesada",
	            showConfirmButton: false
	        });
	        document.getElementById("submit_busquedasustitutos").submit();
	    }

	}

	if( value == 2)
	{
		var placa = document.getElementById("placa").value;
	    if(placa == ""){
	        Swal.fire("Para continuar debes agregar la Placa");
	    }else{
	        Swal.fire({
	            position: "top-center",
	            icon: "success",
	            title: "Espere un momento, la información esta siendo procesada",
	            showConfirmButton: false
	        });
	        document.getElementById("submit_busquedasustitutos").submit();
	    }

	}



});

$("#kdatatable_search_unidad").DataTable({
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




$("#btneliminarunidad").click(function(){
    Swal.fire({
      title: "Estas seguro de eliminar la unidad de la solicitud ",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminar!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true
    }).then(function(result) {
      if (result.value) {
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("eliminar_sustituto").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});



$("#btnfinalizarsolicitud").click(function(){
    Swal.fire({
      title: "Estas seguro de finalizar la solicitud",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Finalizar!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true
    }).then(function(result) {
      if (result.value) {
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("finalizar_sustituto").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });
});