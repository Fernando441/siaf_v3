//libreria npm install chartjs-chart-geo / npm install d3
$(document).ready(function () {
    $("#div_grafica_tablero").show();
    graficaRegistrosEstados();

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
            if ($("#div_grafica_tablero").is(":visible")) {
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
                        '#66BB6A',
                        '#529656',
                        '#B71C1C'
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
});