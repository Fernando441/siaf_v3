$(document).ready(function () {
	let graficasCreadas = false;
	$("#grafica").click(function () {
		$("#div_grafica_licitaciones").stop(true, true).slideToggle(300, function () {
			if ($(this).is(":visible") && !graficasCreadas) {
				graficaPrioridades();
				graficaTipodeContratacion();
				graficaPublicacionConcurso();
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