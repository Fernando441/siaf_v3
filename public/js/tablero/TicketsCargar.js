/*
<><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><script>
    $(document).ready(function () {$('#categoria').on('change', function () {
        let categoriaId = $(this).val();
        $('#subcategoria').html('<option value="">Cargando...</option>');
        $('#problema').html('<option value="">Seleccionar...</option>');

        if (categoriaId) {
            $.get('{{ url("subcategorias") }}/' + categoriaId, function (data) {
                let options = '<option selected disabled value="">Seleccionar...</option>';
                $.each(data, function (key, sub) {
                    options += '<option value="' + sub.id_subcategoria + '">' + sub.descripcion + '</option>';
                });
                $('#subcategoria').html(options);
            });
        }
    })};

    $('#subcategoria').on('change', function () {let} subcategoriaId = $(this).val();
    $('#problema').html('<option value="">Cargando...</option>');

    if (subcategoriaId) {$.get('{{ url("problemas") }}/' + subcategoriaId, function (data) {
        let options = '<option selected disabled value="">Seleccionar...</option>';
        $.each(data, function (key, prob) {
            options += '<option value="' + prob.id_problema + '">' + prob.descripcion + '</option>';
        });
        $('#problema').html(options);
    })};
    }
    });

    });
</script></>
*/