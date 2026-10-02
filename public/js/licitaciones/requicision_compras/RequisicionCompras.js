$("#kdatatable_reqcompras").DataTable({
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


        $(".enviarrevision").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            
            Swal.fire({
                title: "¿Estas seguro de enviar a revisión?.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Enviar!",
                cancelButtonText: "No, Cancelar!",
                confirmButtonColor: "#73ab17",
                cancelButtonColor: "#cc0c73",
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: $('#finanzasrequisicionurl').val(),
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {     
                                Swal.fire({
                                    title: "Requisición enviada a revisión.",
                                    icon: "success",
                                    confirmButtonText: "Cerrar",
                                }).then(function(result) {
                                    if (result.value) {
                                        $('#kdatatable_reqcompras').DataTable().ajax.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });


        $(".modal-pdf").on('click', function () {
            var path = $(this).attr('rel-path');
            var modal = $("#exampleModalSizeSm");
            var object_pdf = $("#modal-body");
            var content = `<object id="object_pdf" type="application/pdf" data="`+path+`" width="100%" height="500" style="height: 85vh;">No Support</object>`;
            object_pdf.html(content);
            modal.modal("show");
        });