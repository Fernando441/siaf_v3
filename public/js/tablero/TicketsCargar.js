
$(document).ready(function () {

    // Cargar subcategorías al seleccionar una categoría
    $('#categoria').on('change', function () {

        let categoriaId = $(this).val();

        $('#sub_categoria').html(
            '<option value="">Cargando...</option>'
        );

        if (categoriaId) {

            $.get('/subcategorias/' + categoriaId, function (data) {

                let options = '<option value="">Selecciona una opción</option>';

                $.each(data, function (key, sub) {
                    options += '<option value="' + sub.id + '">'
                        + sub.nombre_subcategoria +
                        '</option>';
                });

                $('#sub_categoria').html(options);

            }).fail(function (xhr) {

                $('#sub_categoria').html(
                    '<option value="">Error al cargar subcategorías</option>'
                );

                console.error('Error:', xhr.responseText);

            });

        } else {

            $('#sub_categoria').html(
                '<option value="">Selecciona una opción</option>'
            );

        }

    });

});
    /*
    // Cargar problemas al seleccionar una subcategoría
    $('#subcategoria').on('change', function () {
        let subcategoriaId = $(this).val();

        $('#problema').html('<option value="">Cargando...</option>');

        if (subcategoriaId) {
            $.get('/problemas/' + subcategoriaId, function (data) {
                let options = '<option selected disabled value="">Seleccionar...</option>';

                $.each(data, function (key, prob) {
                    options += '<option value="' + prob.id_problema + '">'
                        + prob.descripcion + '</option>';
                });

                $('#problema').html(options);
            }).fail(function () {
                $('#problema').html('<option value="">Error al cargar problemas</option>');
                console.error('Error al obtener los problemas.');
            });
        }
    });*/

