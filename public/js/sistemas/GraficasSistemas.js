$(document).ready(function () {
	let graficasCreadas = false;
	$("#grafica").click(function () {
		$("#div_grafica").stop(true, true).slideToggle(300, function () {
			if ($(this).is(":visible") && !graficasCreadas) {
				graficaInventarioTotal();
                graficaInventarioTotaleee();
				graficasCreadas = true;
			}
		});
	});
	function graficaInventarioTotal() {
		var obtengo_totales = document.getElementById("totales_inventario").value;

		new Chart(document.getElementById('graficaDona'), {
			type: 'radar',
			data: {
				labels: ['Totales', 'Azul', 'mira', 'no', 'aja', 'si', 'no'],
				datasets: [{
					data: [obtengo_totales, 150, 100, 30, 200 ,99, 55],
					backgroundColor: [
						'rgb(255, 99, 132)',
						'rgb(54, 162, 235)',
						// 'rgb(255, 205, 86)',
						// 'rgb(102, 205, 170)'
					],
					hoverOffset: 4
				}]
			},
			options: {
				responsive: true,
				plugins: {
					title: {
						display: true,
						text: 'TOTAL DE INVENTARIO'
					},
					legend: {
						position: 'bottom'
					}
				}
			}
		});
	}
    function graficaInventarioTotaleee() {
		var obtengo_totales = document.getElementById("totales_inventario").value;

		new Chart(document.getElementById('graficaDonas'), {
			type: 'bar',
			data: {
				labels: ['Totales', 'Azul'],
				datasets: [{
					data: [obtengo_totales, 150],
					backgroundColor: [
						'rgb(255, 99, 132)',
						'rgb(54, 162, 235)',
						// 'rgb(255, 205, 86)',
						// 'rgb(102, 205, 170)'
					],
					hoverOffset: 4
				}]
			},
			options: {
				responsive: true,
				plugins: {
					title: {
						display: true,
						text: 'TOTAL DE INVENTARIO'
					},
					legend: {
						position: 'bottom'
					}
				}
			}
		});
	}
});