	$("#carga_masiva_equ").click(function(){
	  var num_carga = document.getElementById("num_carga").value;
	    if(num_carga == 0){
	    	document.getElementById("num_carga").value= 1;
	    	$("#div_cargamasiva").show();
	    }

	    if(num_carga == 1){
	    	var op = 0;
	    	document.getElementById("num_carga").value=0;
	    	$("#div_cargamasiva").hide();
	    }
	});

  	$("#send_carga").click(function(){
	    var file_carga = document.getElementById("file_carga").value;
	    if(file_carga == ""){
	        wal.fire("Para continuar debes agregar un archivo .csv");
	    }else{
	        Swal.fire({
	            position: "top-center",
	            icon: "success",
	            title: "Espere un momento, la información esta siendo procesada",
	            showConfirmButton: false
	        });
	        document.getElementById("submit_carga").submit();
	    }
	});

	$("#grafica").click(function(){
		var op_grafica = document.getElementById("op_div_grafica").value;
		if(op_grafica == 0){
			$("#div_grafica").show();
			document.getElementById("op_div_grafica").value = 1;
		}else{
			$("#div_grafica").hide();
			document.getElementById("op_div_grafica").value = 0;
		}
	});
// Funcion Para mostrar Div de graficas

    var siniestro_con_deducible = document.getElementById("siniestro_con_deducible").value;
    var siniestro_recuperacion = document.getElementById("siniestro_recuperacion").value;
    var siniestro_ambas = document.getElementById("siniestro_ambas").value;
	new Chart(document.getElementById('siniestros_deducible'), {
		type: 'doughnut',
		data: {
			labels: ['Con Deducible', 'Con Recuperacion Aplicada', 'Con ambas'],
			datasets: [{
				data: [siniestro_con_deducible, siniestro_recuperacion, siniestro_ambas],
				backgroundColor: [
					'rgb(69, 255, 78)',
					'rgb(255, 248, 82)',
					'rgb(255, 87, 69)',
						
				],
				hoverOffset: 4
			}]
		},
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'TOTAL DE SINIESTROS'
				},
				legend: {
					position: 'bottom'
				}
			}
		}
	});	

	new Chart(document.getElementById('barras'), {
		type: 'bar',
		data: {
			labels: ['Con Deducible', 'Con Recuperacion Aplicada', 'Con ambas'],
			datasets: [{
				data: [89, 16, 32],
				backgroundColor: [
					'rgb(107, 118, 255)',
					'rgb(216, 135, 245)',
					'rgb(182, 255, 148)',
				],
				hoverOffset: 4
			}]
		},
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'TOTAL DE SINIESTROS'
				},
				legend: {
					position: 'bottom'
				}
			}
		}
	});	


