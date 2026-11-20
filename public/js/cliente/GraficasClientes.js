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
                        'rgb(190, 85, 55)',
                        'rgb(105, 155, 95)'
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
                        'rgb(255, 159, 64)',
                        'rgb(75, 145, 150)',
                        'rgb(145, 175, 95)',
                        'rgb(190, 85, 85)',
                        'rgb(75, 145, 150)',
                        'rgb(190, 115, 130)',
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
            type: 'pie',
            data: {
                labels: ['ACTIVOS', 'NO ACTIVOS'],
                datasets: [{
                    data: [c_activos, c_noactivos],
                    backgroundColor: [
                        'rgb(5, 150, 170)',
                        'rgb(180, 175, 0)'
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