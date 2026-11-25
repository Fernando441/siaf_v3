$(document).ready(function () {
    let graficasCreadas = false;
    $("#grafica").click(function () {
        $("#div_grafica_requisiciones").stop(true, true).slideToggle(300, function () {
            if ($(this).is(":visible") && !graficasCreadas) {
                graficaEstatusRequisiciones();
                graficasCreadas = true;
            }
        });
    });
    function graficaEstatusRequisiciones() {

        var datos = window.obtener_estatus;

        new Chart(document.getElementById('graficaEstatus'), {
            type: 'pie',
            data: {
                labels: datos.map(item => item.estatus),
                datasets: [{
                    data: datos.map(item => item.total),
                    backgroundColor: [
                        'rgb(125, 235, 85)',
                        'rgb(255, 105, 95)',
                        'rgb(255, 195, 65)',
                        'rgb(85, 210, 175)',
                        'rgb(125, 135, 235)',
                        'rgb(200, 105, 195)',
                        'rgb(100, 160, 220)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'ESTATUS DE REQUISICIONES'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});