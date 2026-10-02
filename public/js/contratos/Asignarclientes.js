$("#kdatatable_clientes_proyectos").DataTable({
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


$("#kdatatable_clientes_asignados").DataTable({
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



$(".eliminar-cliente").click(function() {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');

    Swal.fire({
        title: "Estas seguro de eliminar la unidad "+nombre,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminarlo del contrato!",
        cancelButtonText: "No, Cancelar!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            document.getElementById("id_delete").value = id;
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Espere un momento, la información esta siendo procesada",
                showConfirmButton: false
            });
            document.getElementById("cliente_act_form").submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelada",
                "La acción fue cancelada",
                "error"
            )
        }
    });
});

$("#kdatatable_infocliente").DataTable({
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