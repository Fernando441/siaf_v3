$(document).ready(function () {
	let graficasCreadas = false;
	$("#grafica").click(function () {
		$("#div_grafica_licitaciones").stop(true, true).slideToggle(300, function () {
			if ($(this).is(":visible") && !graficasCreadas) {
				graficaPrioridades();
				graficaTipodeContratacion();
				graficasCreadas = true;
			}
		});
	});
	
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
						'rgb(255, 0, 0)',
						'rgb(246, 250, 24)',
						'rgb(36, 255, 7)'
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
		var datos = window.datosTipoContratacion;
		
		new Chart(document.getElementById('graficaTipodeContratacion'), {
			type: 'doughnut',
			data: {
				labels: Object.keys(datos),
				datasets: [{
					data: Object.values(datos),
					backgroundColor: [
						'rgb(84, 247, 9)',
						'rgb(230, 29, 2)',
						'rgb(255, 205, 86)',
						'rgb(102, 205, 170)'
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
	
});