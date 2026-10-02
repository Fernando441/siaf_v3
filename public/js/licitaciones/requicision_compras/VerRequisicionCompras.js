$("#btn-rechazar").click(function(){
    $("#rechazar-div").show();
});


$("#btn-autorizar").click(function(){
    $("#rechazar-div").hide();

    Swal.fire({
      title: "Estas seguro de enviar la solicitud",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Enviar!",
      cancelButtonText: "No, Cancelar!",
      reverseButtons: true
    }).then(function(result) {
      if (result.value) {
        // document.getElementById("id_delete_emisor").value = id;
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "Espere un momento, la información esta siendo procesada",
          showConfirmButton: false
        });
        document.getElementById("validar_form").submit();
      } else if (result.dismiss === "cancel") {
        Swal.fire(
          "Cancelada",
          "La acción fue cancelada",
          "error"
        )
      }
    });

});


    $("#btn-rechazar-form").click(function () {
        var motivo = document.getElementById("motivo").value;
        if (motivo == "") {
            Swal.fire("Para continuar debes agregar el motivo por el cual rechazas la solicitud");
        } else {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("rechazar_form").submit();
        }
    });