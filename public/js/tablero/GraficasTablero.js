//libreria npm install chartjs-chart-geo / npm install d3
$(document).ready(function () {
    $("#div_grafica_tablero").show();
    graficaRegistrosEstados();
    graficaClientesActivosNoActivos();
    graficaEquipTipoPersonas();
    graficaPrioridades();
    graficaTipodeContratacion();
    graficaPublicacionConcurso();

    function graficaRegistrosEstados() {
        var mapaClientesEstados = null;
        var googleChartsListo = false;
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
            if (!googleChartsListo) {
                return;
            }
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
            var data = google.visualization.arrayToDataTable(datosMapa);
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
            if (mapaClientesEstados === null) {
                mapaClientesEstados = new google.visualization.GeoChart(
                    document.getElementById('regions_div')
                );
            }
            mapaClientesEstados.draw(data, opciones);
        }
    }

    function graficaClientesActivosNoActivos() {
        var c_activos = document.getElementById("activos").value;
        var c_noactivos = document.getElementById("noactivos").value;
        new Chart(document.getElementById('graficaClientesActivosNoActivos'), {
            type: 'bar',
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
    function graficaPrioridades() {
        var alta = document.getElementById("p_alta").value;
        var media = document.getElementById("p_media").value;
        var baja = document.getElementById("p_baja").value;

        new Chart(document.getElementById('graficaPrioridades'), {
            type: 'bar',
            data: {
                labels: ['ALTA', 'MEDIA', 'BAJA'],
                datasets: [{
                    data: [alta, media, baja],
                    backgroundColor: [
                        'rgb(255, 120, 140)', // Rosa coral
                        'rgb(255, 205, 100)', // Amarillo pastel
                        'rgb(120, 210, 160)'  // Verde menta
                        // 'rgb(100, 190, 210)' // Azul turquesa
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'PRIORIDADES'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    function graficaTipodeContratacion() {

        var datos = window.tipo_contrataciones;

        console.log("Datos recibidos:", datos);
        console.log("Etiquetas:", Object.keys(datos));
        console.log("Cantidades:", Object.values(datos));

        new Chart(document.getElementById('graficaTipodeContratacion'), {
            type: 'pie',
            data: {
                labels: Object.keys(datos),
                datasets: [{
                    data: Object.values(datos),
                    backgroundColor: [
                        'rgb(125, 235, 85)',
                        'rgb(255, 105, 95)',
                        'rgb(255, 195, 65)',
                        'rgb(85, 210, 175)',
                        'rgb(125, 235, 85)',
                        'rgb(255, 105, 95)',
                        'rgb(255, 195, 65)',
                        'rgb(85, 210, 175)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'TIPO DE CONTRATACION'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    function graficaPublicacionConcurso() {

        var datos = window.tipo_publicaciones;

        console.log("Datos recibidos:", datos);
        console.log("Etiquetas:", Object.keys(datos));
        console.log("Cantidades:", Object.values(datos));

        new Chart(document.getElementById('graficaPublicacionConcurso'), {
            type: 'pie',
            data: {
                labels: Object.keys(datos),
                datasets: [{
                    data: Object.values(datos),
                    backgroundColor: [
                        'rgb(235, 140, 85)',
                        'rgb(85, 210, 175)',
                        'rgb(255, 195, 65)',
                        'rgb(85, 210, 175)',
                        'rgb(125, 235, 85)',
                        'rgb(255, 105, 95)',
                        'rgb(255, 195, 65)',
                        'rgb(85, 210, 175)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'TIPO DE PUBLICACION DEL CONCURSO'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});