//libreria npm install chartjs-chart-geo / npm install d3
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

        // Variables globales
        var mapaClientesEstados = null;
        var googleChartsListo = false;

        // Cargar Google GeoChart
        google.charts.load('current', {
            packages: ['geochart']
        });

        google.charts.setOnLoadCallback(function () {
            googleChartsListo = true;

            // Si el dashboard ya está visible, dibujar el mapa
            if ($("#div_grafica_licitaciones").is(":visible")) {
                graficaMapaEstados();
            }
        });
        function graficaMapaEstados() {

            // Evitar errores si Google Charts aún no está listo
            if (!googleChartsListo) {
                return;
            }

            // Construir arreglo de datos
            var datosMapa = [];

            datosMapa.push([
                'Estado',
                'Total de clientes'
            ]);

            totalclientesestado.forEach(function (item) {

                datosMapa.push([
                    item.clave,
                    Number(item.total_registros)
                ]);

            });

            // Convertir datos para Google Charts
            var data = google.visualization.arrayToDataTable(datosMapa);

            // Configuración del mapa
            var opciones = {

                region: 'MX',

                displayMode: 'regions',

                resolution: 'provinces',

                colorAxis: {
                    colors: [
                        '#cfffdb',
                        '#43f858',
                        '#00ff1e'
                    ]
                },

                backgroundColor: '#FFFFFF',

                datalessRegionColor: '#EEEEEE',

                defaultColor: '#EEEEEE',

                legend: {
                    textStyle: {
                        color: '#333333',
                        fontSize: 12
                    }
                },

                tooltip: {
                    textStyle: {
                        fontSize: 13
                    }
                },

                keepAspectRatio: true
            };

            // Crear mapa
            if (mapaClientesEstados === null) {

                mapaClientesEstados = new google.visualization.GeoChart(
                    document.getElementById('regions_div')
                );

            }

            // Dibujar mapa
            mapaClientesEstados.draw(data, opciones);
        }
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