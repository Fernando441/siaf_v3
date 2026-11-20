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

                graficaMapaEstados();
                graficasCreadas = true;
            }

        });
    });

    function graficaEquipTipoPersonas() {

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
                        '#E3F2FD',
                        '#64B5F6',
                        '#1565C0'
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
    function graficaRegistrosEstados() {

        var estados = totalclientesestado.map(item => item.estado_nombre);
        var totales = totalclientesestado.map(item => item.total_registros);

        // Generar un color aleatorio por cada dato
        var coloresAleatorios = Object.keys(estados).map(() => {
            return `rgb(
                ${Math.floor(Math.random() * 256)},
                ${Math.floor(Math.random() * 256)},
                ${Math.floor(Math.random() * 256)}
            )`;
        });

        new Chart(document.getElementById('graficaRegistrosEstados'), {
            type: 'pie',
            data: {
                labels: estados,
                datasets: [{
                    label: 'Total de clientes',
                    data: totales,

                    backgroundColor: coloresAleatorios,
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