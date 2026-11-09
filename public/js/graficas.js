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