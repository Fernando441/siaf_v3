$(document).ready(function () {
    let graficasCreadas = false;
    $("#grafica").click(function (e) {
        e.preventDefault();
        $("#div_grafica_licitaciones").stop(true, true).slideToggle(300, function () {
            if ($(this).is(":visible") && !graficasCreadas) {
                graficaEquipTipoPersonas();
                graficaRegistrosEstados();
                graficaClientesActivosNoActivos();
                graficasCreadas = true;
            }

        });
    });

    function graficaEquipTipoPersonas() {

        var p_fisicas = document.getElementById("fisicas").value;
        var p_morales = document.getElementById("morales").value;

        new Chart(document.getElementById('graficaEquipTipoPersonas'), {
            type: 'bar',
            data: {
                labels: ['FÍSICAS', 'MORALES'],
                datasets: [{
                    data: [p_fisicas, p_morales],
                    backgroundColor: [
                        'rgb(84, 247, 9)',
                        'rgb(255, 205, 100)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'TIPOS DE PERSONAS'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    function graficaRegistrosEstados() {

        var estados = totalclientesestado.map(item => item.estado_nombre);
        var totales = totalclientesestado.map(item => item.total_registros);

        new Chart(document.getElementById('graficaRegistrosEstados'), {
            type: 'pie',
            data: {
                labels: estados,
                datasets: [{
                    label: 'Total de clientes',
                    data: totales,
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 159, 64)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 99, 132)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 99, 132)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'CLIENTES POR ESTADOS'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    function graficaClientesActivosNoActivos() {

        var c_activos = document.getElementById("activos").value;
        var c_noactivos = document.getElementById("noactivos").value;

        new Chart(document.getElementById('graficaClientesActivosNoActivos'), {
            type: 'doughnut',
            data: {
                labels: ['ACTIVOS', 'NO ACTIVOS'],
                datasets: [{
                    data: [c_activos, c_noactivos],
                    backgroundColor: [
                        'rgb(247, 144, 9)',
                        'rgb(74, 230, 13)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'CLIENTES ACTIVOS Y NO ACTIVOS'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

});