$(document).ready(function () {
	let graficasCreadas = false;
	$("#grafica").click(function () {
		$("#div_grafica").stop(true, true).slideToggle(300, function () {
			if ($(this).is(":visible") && !graficasCreadas) {
				
				graficaEquiposAsignados();
				graficaTiposEquipos();
				graficasCreadas = true;
			}
		});
	});
	
	function graficaEquiposAsignados() {
		var asignados = document.getElementById("equipos_asignados").value;
		var noasignados = document.getElementById("equipos_no_asignados").value;

		new Chart(document.getElementById('graficaEquiposAsignados'), {
			type: 'doughnut',
			data: {
				labels: ['Equipos Asignados', 'Equipos no Asignados'],
				datasets: [{
					data: [asignados, noasignados],
					backgroundColor: [
						'rgb(84, 247, 9)',
						'rgb(230, 29, 2)',
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
	function graficaTiposEquipos() {

		var datos = window.datosTiposEquipos;

		new Chart(document.getElementById('graficaTiposEquipos'), {
			type: 'bar',
			data: {
				labels: Object.keys(datos),
				datasets: [{
					data: Object.values(datos),
					backgroundColor: [
						'rgb(84, 247, 9)',
						'rgb(230, 29, 2)',
						'rgb(255, 205, 86)',
						'rgb(102, 205, 170)',
						'rgb(54, 162, 235)',
						'rgb(153, 102, 255)',
						'rgb(255, 159, 64)'
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