var Notificacion = function () {

    var mostrar = function () {

        $( "#m_topbar_notification_icon" ).on( "click", function() {

            var notificaciones_contenedor = $('#topbar_notifications_items');
            $.ajax({
                type: 'POST',
                url: $('#notificacion_index').val(),
                data: {
                    id: 1,
                    _token: $("[name='_token']").val()
                },
                beforeSend: function() {
                    $('#topbar_notifications_items').html('');
                    $('#total_notificaciones').html('0 Nuevos');
                }
            }).done(function(data) {
                setView(data);
            });

        });
    };

    var setView = function (data) {
        var html = '';
        var contenedor = $('#topbar_notifications_items');
        var concurso = $('#tabler_vernotconcurso');
        $('#total_notificaciones').html(data.data.length + ' Nuevos');

        if (data.data.length>0){

            data.data.forEach(function(elemento) {

                var options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute:'numeric' };
                var dt = new Date(elemento.created_at);
                let link_inicio = "<span class='navi-item'>";
                let link_cierre = "</span>";
                let link_icon = "<div class='navi-icon mr-2'>"+
                    " <i class='text-success'></i>"+
                    " </div>";

                if (elemento.modulo_id == 2 ){

                    let concurso_route = concurso.val() + '/' + elemento.licitaciones_id;
                    link_inicio = "<a href='"+concurso_route+"' class='navi-item'>";
                    link_cierre = "</a>";
                    link_icon = "<div class='navi-icon mr-2'>"+
                        " <i class='flaticon-eye'></i>"+
                        " </div>";
                }

                html += ([    "",
                    link_inicio,
                    "	<div class='navi-link'>",
                    link_icon,
                    "		<div class='navi-text'>",
                    "			<div class='font-weight-bold'>"+elemento.notificacion+"</div>",
                    "			<div class='text-muted'>"+dt.toLocaleDateString("es-ES", options)+"</div>",
                    "		</div>",
                    "	</div>",
                    link_cierre,
                    ""].join(""));
            });

            contenedor.html('');
            contenedor.append(html);
        }
    };

    var mostrarTotal = function () {
        $.ajax({
            type: 'POST',
            url: $('#notificacion_total').val(),
            data: {
                id: 1,
                _token: $("[name='_token']").val()
            }
        }).done(function(data) {
            if (data.data.total>0){
                mostrarInsignia(data.data.total);
            }
        });

    };

    var mostrarInsignia = function (total) {
        let badge = $('#bell_badge');
        badge.html(total);
        badge.addClass("position-absolute top-0 start-100 translate-middle  badge badge-circle badge-jv w-15px h-15px ms-n4 mt-3");
    };

    return {
        init: function () {
            mostrar();
            mostrarTotal();
        }
    };
}();

$(document).ready(function() {
    Notificacion.init();
});
