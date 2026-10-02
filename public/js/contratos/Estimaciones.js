
$("#kdatatable_estimaciones").DataTable({
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

$("#btnGuardar").click(function(){
    var periodo_inicial = document.getElementById("periodo_inicial").value;
    var periodo_final = document.getElementById("periodo_final").value;
    if(periodo_inicial == "" || periodo_final == ""){
        Swal.fire("Para continuar debes agregar la información solicitada");
    }else{
        Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Espere un momento, la información esta siendo procesada",
            showConfirmButton: false
        });
        document.getElementById("submit_estimacion").submit();
    }
});



$("#kdatatable_seguimiento").DataTable({
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




$("#addseguimiento").click(function(){
    var fecha_envio_cliente = document.getElementById("fecha_envio_cliente").value;
    var estatus_envio =  $('.estatus_envio:checked').val();
    var observaciones = document.getElementById("observaciones").value;
    var id_estimacion_seguimiento = document.getElementById("id_estimacion_seguimiento").value;

    if(fecha_envio_cliente == ""){
        Swal.fire("Para continuar debes agregar la fecha de envío al cliente");
    }else{
        var url = $('#url_seguimiento').val();
        var data = {
            id_estimacion_seguimiento: id_estimacion_seguimiento, fecha_envio_cliente:fecha_envio_cliente, estatus_envio:estatus_envio, observaciones:observaciones,
            _token: $("[name='_token']").val()
        };
        console.log(data);
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                Swal.fire({
                  title: "Seguimiento Agregado!",
                  text: "El seguimiento con el cliente se agrego correctamente!",
                  icon: "success"
                });

                $("#kdatatable_seguimiento").load(" #kdatatable_seguimiento");
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});


$(".deleteregistro").click(function() {

    var id = $(this).data('id');

    Swal.fire({
        title: "¿Desea eliminar el registro?.",
        // text: documento,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar Registro",
        cancelButtonText: "Cerrar",
        reverseButtons: true,
        confirmButtonColor: "#73ab17",
        cancelButtonColor: "#cc0c73",
    }).then(function(result) {
        if (result.value) {
            var url = $('#url_seguimiento_delete').val();
            var data = {
                id: id,
                _token: $("[name='_token']").val()
            };
            console.log(data);
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (response) {
                    Swal.fire({
                        title: "Registro eliminado!",
                        text: "El registro se elimino correctamente!",
                        icon: "success"
                    });

                    $("#kdatatable_seguimiento").load(" #kdatatable_seguimiento");
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });
});



$(".send-finanzas").click(function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
        title: "Estas seguro de enviar a finanzas la estimacion con folio: "+nombre,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Enviar!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true,
        confirmButtonColor: "#73ab17",
        cancelButtonColor: "#cc0c73",
    }).then(function(result) {
        if (result.value) {
            document.getElementById("id_estimacion").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("send_finanzas_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});


$("#tblnotascredito").DataTable({
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


$(".modal-pdf").on('click', function () {
    var path = $(this).attr('rel-path');
    var modal = $("#exampleModalSizeSm");
    var object_pdf = $("#modal-body");
    var content = `<object id="object_pdf" type="application/pdf" data="`+path+`" width="100%" height="500" style="height: 85vh;">No Support</object>`;
    object_pdf.html(content);
    modal.modal("show");
});
