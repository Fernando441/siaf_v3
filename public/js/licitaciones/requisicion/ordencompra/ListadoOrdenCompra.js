    $(".modal-pdf").on('click', function (e) {
        e.preventDefault();
        var path = $(this).attr('rel-path');
        var modal = $("#exampleModalSizeSm");
        var object_pdf = $("#modal-body");
        var content = `<object id="object_pdf" type="application/pdf" data="`+path+`" width="100%" height="500" style="height: 85vh;">No Support</object>`;
        object_pdf.html(content);
        modal.modal("show");
    });