
// A G R E G A R   R O L

	$("#btnGuardar").click(function(){
		var btnGuardar = document.getElementById('btnGuardar');
		KTUtil.btnWait( btnGuardar, 'spinner spinner-right spinner-white pr-15', 'Espere...', true);
		document.getElementById("frmRol").submit();
	});

// E D I T A R   R O L
 	$("#send_rol").click(function(){
	    var name_rol = document.getElementById("name_rol").value;
	    if(name_rol == ""){
	        Swal.fire("Para continuar debes agregar el nombre del rol");
	    }else{
			Swal.fire({
				position: "top-center",
				icon: "success",
				title: "Espere un momento, la información esta siendo procesada",
				showConfirmButton: false
			});
	        document.getElementById("submit_rol_edit").submit();
	    }
	});

// M O D U L O   D E   P E R M I S O S
		$('#all_generales_check').change(function () {
		    ($(this).is(":checked") ? $('.all_generales').prop("checked", true) :    $('.all_generales').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_user').prop("checked", true) :    $('#all_user').prop("checked", false));
		    ($(this).is(":checked") ? $('#CheckAll').prop("checked", true) :    $('#CheckAll').prop("checked", false));
		    ($(this).is(":checked") ? $('#CheckTablero').prop("checked", true) :    $('#CheckTablero').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_areapers').prop("checked", true) :    $('#all_areapers').prop("checked", false));
		});


		$(".user_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_1");
			var op_user = document.getElementById("op_user").value;

			if(op_user == 0){
				element.classList.add("active");
				 document.getElementById("op_user").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_user").value = 0;
			}
		});

		$('#all_user').change(function () {
		    ($(this).is(":checked") ? $('.user_check').prop("checked", true) :    $('.user_check').prop("checked", false))
		});


		$(".rol_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_2");
			var op_rol = document.getElementById("op_rol").value;

			if(op_rol == 0){
				element.classList.add("active");
				 document.getElementById("op_rol").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_rol").value = 0;
			}
		});

		$('#CheckAll').change(function () {
		    ($(this).is(":checked") ? $('.roles_check').prop("checked", true) :    $('.roles_check').prop("checked", false))
		});

		$(".tablero_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tablero");
			var op_tablero = document.getElementById("op_tablero").value;

			if(op_tablero == 0){
				element.classList.add("active");
				 document.getElementById("op_tablero").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tablero").value = 0;
			}
		});



		$("#all_areapers").click(function(){
			($(this).is(":checked") ? $('.areapers_check').prop("checked", true) :    $('.areapers_check').prop("checked", false))
		});

		$(".areapers_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_areapers");
			var op_areapers = document.getElementById("op_areapers").value;

			if(op_areapers == 0){
				element.classList.add("active");
				 document.getElementById("op_areapers").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_areapers").value = 0;
			}
		});


		$('#CheckTablero').change(function () {
		    ($(this).is(":checked") ? $('.tablero_check').prop("checked", true) :    $('.tablero_check').prop("checked", false))
		});

	// PERMISOS GENERALES END
		//        ADMINISTRACION DEL SISTEMA

	// PERMISOS UNIDADES
		$("#all_unidades_check").click(function(){
		    ($(this).is(":checked") ? $('.all_unidades').prop("checked", true) :    $('.all_unidades').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_unidad').prop("checked", true) :    $('#all_unidad').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_marca').prop("checked", true) :    $('#all_marca').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_modelo').prop("checked", true) :    $('#all_modelo').prop("checked", false));
		    // ($(this).is(":checked") ? $('#all_ubicacion').prop("checked", true) :    $('#all_ubicacion').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_estatus').prop("checked", true) :    $('#all_estatus').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_aseguradora').prop("checked", true) :    $('#all_aseguradora').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tipovehiculo').prop("checked", true) :    $('#all_tipovehiculo').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_agencia').prop("checked", true) :    $('#all_agencia').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_documento').prop("checked", true) :    $('#all_documento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asignacion').prop("checked", true) :    $('#all_asignacion').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_mantenimiento').prop("checked", true) :    $('#all_mantenimiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asignacionunid').prop("checked", true) :    $('#all_asignacionunid').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_requnidasig').prop("checked", true) :    $('#all_requnidasig').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_infopropietario').prop("checked", true) :    $('#all_infopropietario').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_traemplacamiento').prop("checked", true) :    $('#all_traemplacamiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tratenencia').prop("checked", true) :    $('#all_tratenencia').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_traverificacion').prop("checked", true) :    $('#all_traverificacion').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_trareemplacamiento').prop("checked", true) :    $('#all_trareemplacamiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tracambpropietario').prop("checked", true) :    $('#all_tracambpropietario').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_traaseguramiento').prop("checked", true) :    $('#all_traaseguramiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_trabvventa').prop("checked", true) :    $('#all_trabvventa').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_trabvrobo').prop("checked", true) :    $('#all_trabvrobo').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_trabvsiniestro').prop("checked", true) :    $('#all_trabvsiniestro').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_mansolicitud').prop("checked", true) :    $('#all_mansolicitud').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_sermantenimiento').prop("checked", true) :    $('#all_sermantenimiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tipdoctaller').prop("checked", true) :    $('#all_tipdoctaller').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_estsiniestro').prop("checked", true) :    $('#all_estsiniestro').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tragps').prop("checked", true) :    $('#all_tragps').prop("checked", false));
		});
		$("#all_unidad").click(function(){
			($(this).is(":checked") ? $('.unidad_check').prop("checked", true) :    $('.unidad_check').prop("checked", false))
		});

		$(".unidad_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_3");
			var op_unidad = document.getElementById("op_unidad").value;

			if(op_unidad == 0){
				element.classList.add("active");
				 document.getElementById("op_unidad").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_unidad").value = 0;
			}
		});

		$("#all_marca").click(function(){
			($(this).is(":checked") ? $('.marca_check').prop("checked", true) :    $('.marca_check').prop("checked", false))
		});

		$(".marca_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_4");
			var op_marca = document.getElementById("op_marca").value;

			if(op_marca == 0){
				element.classList.add("active");
				 document.getElementById("op_marca").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_marca").value = 0;
			}
		});

		$("#all_modelo").click(function(){
			($(this).is(":checked") ? $('.modelo_check').prop("checked", true) :    $('.modelo_check').prop("checked", false))
		});

		$(".modelo_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_5");
			var op_modelo = document.getElementById("op_modelo").value;

			if(op_modelo == 0){
				element.classList.add("active");
				 document.getElementById("op_modelo").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_modelo").value = 0;
			}
		});

		$("#all_ubicacion").click(function(){
			($(this).is(":checked") ? $('.ubicacion_check').prop("checked", true) :    $('.ubicacion_check').prop("checked", false))
		});

		$(".ubicacion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_6");
			var op_ubicacion = document.getElementById("op_ubicacion").value;

			if(op_ubicacion == 0){
				element.classList.add("active");
				 document.getElementById("op_ubicacion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_ubicacion").value = 0;
			}
		});

		$("#all_estatus").click(function(){
			($(this).is(":checked") ? $('.estatus_check').prop("checked", true) :    $('.estatus_check').prop("checked", false))
		});

		$(".estatus_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_7");
			var op_estatus = document.getElementById("op_estatus").value;

			if(op_estatus == 0){
				element.classList.add("active");
				 document.getElementById("op_estatus").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_estatus").value = 0;
			}
		});

		$("#all_aseguradora").click(function(){
			($(this).is(":checked") ? $('.aseguradora_check').prop("checked", true) :    $('.aseguradora_check').prop("checked", false))
		});

		$(".aseguradora_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_8");
			var op_aseguradora = document.getElementById("op_aseguradora").value;

			if(op_aseguradora == 0){
				element.classList.add("active");
				 document.getElementById("op_aseguradora").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_aseguradora").value = 0;
			}
		});

		$("#all_tipovehiculo").click(function(){
			($(this).is(":checked") ? $('.tipovehiculo_check').prop("checked", true) :    $('.tipovehiculo_check').prop("checked", false))
		});

		$(".tipovehiculo_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_12");
			var op_tipovehiculo = document.getElementById("op_tipovehiculo").value;

			if(op_tipovehiculo == 0){
				element.classList.add("active");
				 document.getElementById("op_tipovehiculo").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tipovehiculo").value = 0;
			}
		});

		$("#all_agencia").click(function(){
			($(this).is(":checked") ? $('.agencia_check').prop("checked", true) :    $('.agencia_check').prop("checked", false))
		});

		$(".agencia_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_13");
			var op_agencia = document.getElementById("op_agencia").value;

			if(op_agencia == 0){
				element.classList.add("active");
				 document.getElementById("op_agencia").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_agencia").value = 0;
			}
		});

		$("#all_documento").click(function(){
			($(this).is(":checked") ? $('.documento_check').prop("checked", true) :    $('.documento_check').prop("checked", false))
		});

		$(".documento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_14");
			var op_documento = document.getElementById("op_documento").value;

			if(op_documento == 0){
				element.classList.add("active");
				 document.getElementById("op_documento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_documento").value = 0;
			}
		});

		$("#all_asignacion").click(function(){
			($(this).is(":checked") ? $('.asignacion_check').prop("checked", true) :    $('.asignacion_check').prop("checked", false))
		});

		$(".asignacion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_15");
			var op_asignacion = document.getElementById("op_asignacion").value;

			if(op_asignacion == 0){
				element.classList.add("active");
				 document.getElementById("op_asignacion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asignacion").value = 0;
			}
		});

		$("#all_mantenimiento").click(function(){
			($(this).is(":checked") ? $('.mantenimiento_check').prop("checked", true) :    $('.mantenimiento_check').prop("checked", false))
		});

		$(".mantenimiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_mantenimiento");
			var op_mantenimiento = document.getElementById("op_mantenimiento").value;

			if(op_mantenimiento == 0){
				element.classList.add("active");
				 document.getElementById("op_mantenimiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_mantenimiento").value = 0;
			}
		});


		$("#all_asignacionunid").click(function(){
			($(this).is(":checked") ? $('.asignacionunid_check').prop("checked", true) :    $('.asignacionunid_check').prop("checked", false))
		});

		$(".asignacionunid_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asignacionunid");
			var op_asignacionunid = document.getElementById("op_asignacionunid").value;

			if(op_asignacionunid == 0){
				element.classList.add("active");
				 document.getElementById("op_asignacionunid").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asignacionunid").value = 0;
			}
		});

		$("#all_requnidasig").click(function(){
			($(this).is(":checked") ? $('.requnidasig_check').prop("checked", true) :    $('.requnidasig_check').prop("checked", false))
		});

		$(".requnidasig_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_requnidasig");
			var op_requnidasig = document.getElementById("op_requnidasig").value;

			if(op_requnidasig == 0){
				element.classList.add("active");
				 document.getElementById("op_requnidasig").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_requnidasig").value = 0;
			}
		});

		$("#all_infopropietario").click(function(){
			($(this).is(":checked") ? $('.infopropietario_check').prop("checked", true) :    $('.infopropietario_check').prop("checked", false))
		});

		$(".infopropietario_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_infopropietario");
			var op_infopropietario = document.getElementById("op_infopropietario").value;

			if(op_infopropietario == 0){
				element.classList.add("active");
				 document.getElementById("op_infopropietario").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_infopropietario").value = 0;
			}
		});

		$("#all_traemplacamiento").click(function(){
			($(this).is(":checked") ? $('.traemplacamiento_check').prop("checked", true) :    $('.traemplacamiento_check').prop("checked", false))
		});

		$(".traemplacamiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_traemplacamiento");
			var op_traemplacamiento = document.getElementById("op_traemplacamiento").value;

			if(op_traemplacamiento == 0){
				element.classList.add("active");
				 document.getElementById("op_traemplacamiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_traemplacamiento").value = 0;
			}
		});

		$("#all_tratenencia").click(function(){
			($(this).is(":checked") ? $('.tratenencia_check').prop("checked", true) :    $('.tratenencia_check').prop("checked", false))
		});

		$(".tratenencia_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tratenencia");
			var op_tratenencia = document.getElementById("op_tratenencia").value;

			if(op_tratenencia == 0){
				element.classList.add("active");
				 document.getElementById("op_tratenencia").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tratenencia").value = 0;
			}
		});

		$("#all_traverificacion").click(function(){
			($(this).is(":checked") ? $('.traverificacion_check').prop("checked", true) :    $('.traverificacion_check').prop("checked", false))
		});

		$(".traverificacion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_traverificacion");
			var op_traverificacion = document.getElementById("op_traverificacion").value;

			if(op_traverificacion == 0){
				element.classList.add("active");
				 document.getElementById("op_traverificacion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_traverificacion").value = 0;
			}
		});

		$("#all_trareemplacamiento").click(function(){
			($(this).is(":checked") ? $('.trareemplacamiento_check').prop("checked", true) :    $('.trareemplacamiento_check').prop("checked", false))
		});

		$(".trareemplacamiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_trareemplacamiento");
			var op_trareemplacamiento = document.getElementById("op_trareemplacamiento").value;

			if(op_trareemplacamiento == 0){
				element.classList.add("active");
				 document.getElementById("op_trareemplacamiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_trareemplacamiento").value = 0;
			}
		});

		$("#all_tracambpropietario").click(function(){
			($(this).is(":checked") ? $('.tracambpropietario_check').prop("checked", true) :    $('.tracambpropietario_check').prop("checked", false))
		});

		$(".tracambpropietario_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tracambpropietario");
			var op_tracambpropietario = document.getElementById("op_tracambpropietario").value;

			if(op_tracambpropietario == 0){
				element.classList.add("active");
				 document.getElementById("op_tracambpropietario").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tracambpropietario").value = 0;
			}
		});

		$("#all_traaseguramiento").click(function(){
			($(this).is(":checked") ? $('.traaseguramiento_check').prop("checked", true) :    $('.traaseguramiento_check').prop("checked", false))
		});

		$(".traaseguramiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_traaseguramiento");
			var op_traaseguramiento = document.getElementById("op_traaseguramiento").value;

			if(op_traaseguramiento == 0){
				element.classList.add("active");
				 document.getElementById("op_traaseguramiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_traaseguramiento").value = 0;
			}
		});


		$("#all_trabvventa").click(function(){
			($(this).is(":checked") ? $('.trabvventa_check').prop("checked", true) :    $('.trabvventa_check').prop("checked", false))
		});

		$(".trabvventa_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_trabvventa");
			var op_trabvventa = document.getElementById("op_trabvventa").value;

			if(op_trabvventa == 0){
				element.classList.add("active");
				 document.getElementById("op_trabvventa").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_trabvventa").value = 0;
			}
		});


		$("#all_trabvrobo").click(function(){
			($(this).is(":checked") ? $('.trabvrobo_check').prop("checked", true) :    $('.trabvrobo_check').prop("checked", false))
		});

		$(".trabvrobo_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_trabvrobo");
			var op_trabvrobo = document.getElementById("op_trabvrobo").value;

			if(op_trabvrobo == 0){
				element.classList.add("active");
				 document.getElementById("op_trabvrobo").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_trabvrobo").value = 0;
			}
		});


		$("#all_trabvsiniestro").click(function(){
			($(this).is(":checked") ? $('.trabvsiniestro_check').prop("checked", true) :    $('.trabvsiniestro_check').prop("checked", false))
		});

		$(".trabvsiniestro_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_trabvsiniestro");
			var op_trabvsiniestro = document.getElementById("op_trabvsiniestro").value;

			if(op_trabvsiniestro == 0){
				element.classList.add("active");
				 document.getElementById("op_trabvsiniestro").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_trabvsiniestro").value = 0;
			}
		});

		$("#all_mansolicitud").click(function(){
			($(this).is(":checked") ? $('.mansolicitud_check').prop("checked", true) :    $('.mansolicitud_check').prop("checked", false))
		});

		$(".mansolicitud_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_mansolicitud");
			var op_mansolicitud = document.getElementById("op_mansolicitud").value;

			if(op_mansolicitud == 0){
				element.classList.add("active");
				 document.getElementById("op_mansolicitud").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_mansolicitud").value = 0;
			}
		});


		$("#all_estsiniestro").click(function(){
			($(this).is(":checked") ? $('.estsiniestro_check').prop("checked", true) :    $('.estsiniestro_check').prop("checked", false))
		});

		$(".estsiniestro_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_estsiniestro");
			var op_estsiniestro = document.getElementById("op_estsiniestro").value;

			if(op_estsiniestro == 0){
				element.classList.add("active");
				 document.getElementById("op_estsiniestro").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_estsiniestro").value = 0;
			}
		});

		$("#all_tragps").click(function(){
			($(this).is(":checked") ? $('.tragps_check').prop("checked", true) :    $('.tragps_check').prop("checked", false))
		});

		$(".tragps_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tragps");
			var op_tragps = document.getElementById("op_tragps").value;

			if(op_tragps == 0){
				element.classList.add("active");
				 document.getElementById("op_tragps").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tragps").value = 0;
			}
		});

		$("#all_sermantenimiento").click(function(){
			($(this).is(":checked") ? $('.sermantenimiento_check').prop("checked", true) :    $('.sermantenimiento_check').prop("checked", false))
		});

		$(".sermantenimiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_sermantenimiento");
			var op_sermantenimiento = document.getElementById("op_sermantenimiento").value;

			if(op_sermantenimiento == 0){
				element.classList.add("active");
				 document.getElementById("op_sermantenimiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_sermantenimiento").value = 0;
			}
		});

		$("#all_tipdoctaller").click(function(){
			($(this).is(":checked") ? $('.tipdoctaller_check').prop("checked", true) :    $('.tipdoctaller_check').prop("checked", false))
		});

		$(".tipdoctaller_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tipdoctaller");
			var op_tipdoctaller = document.getElementById("op_tipdoctaller").value;

			if(op_tipdoctaller == 0){
				element.classList.add("active");
				 document.getElementById("op_tipdoctaller").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tipdoctaller").value = 0;
			}
		});


	// PERMISOS UNIDADES END 
	   	//      GERENCIA DE OPERACIONES

	// PERMISOS CLIENTES  GERENCIA COMERCIAL
		$("#all_clientes_check").click(function(){
		    ($(this).is(":checked") ? $('.all_clientes').prop("checked", true) :    $('.all_clientes').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_cliente').prop("checked", true) :    $('#all_cliente').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_estados').prop("checked", true) :    $('#all_estados').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_municipios').prop("checked", true) :    $('#all_municipios').prop("checked", false));	
		    //segmentos
		    ($(this).is(":checked") ? $('#all_asegmento').prop("checked", true) :    $('#all_asegmento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_astipovehiculo').prop("checked", true) :    $('#all_astipovehiculo').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_aspuerta').prop("checked", true) :    $('#all_aspuerta').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_ascarroceria').prop("checked", true) :    $('#all_ascarroceria').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asnumcilindros').prop("checked", true) :    $('#all_asnumcilindros').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_aspasajeros').prop("checked", true) :    $('#all_aspasajeros').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_motor').prop("checked", true) :    $('#all_motor').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asespejoslaterales').prop("checked", true) :    $('#all_asespejoslaterales').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_asaccesorios').prop("checked", true) :    $('#all_asaccesorios').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_asapotencia').prop("checked", true) :    $('#all_asapotencia').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_astransmision').prop("checked", true) :    $('#all_astransmision').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_docconcursos').prop("checked", true) :    $('#all_docconcursos').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_pubconcursos').prop("checked", true) :    $('#all_pubconcursos').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_tipcontratacion').prop("checked", true) :    $('#all_tipcontratacion').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tipdoccontrato').prop("checked", true) :    $('#all_tipdoccontrato').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_doccliente').prop("checked", true) :    $('#all_doccliente').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_admincontrato').prop("checked", true) :    $('#all_admincontrato').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_conveniomod').prop("checked", true) :    $('#all_conveniomod').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_tipofianza').prop("checked", true) :    $('#all_tipofianza').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_lequipamiento').prop("checked", true) :    $('#all_lequipamiento').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_rtransporte').prop("checked", true) :    $('#all_rtransporte').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_rentidadf').prop("checked", true) :    $('#all_rentidadf').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_rplacas').prop("checked", true) :    $('#all_rplacas').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_rcombustible').prop("checked", true) :    $('#all_rcombustible').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_catafianzadora').prop("checked", true) :    $('#all_catafianzadora').prop("checked", false));	
		    ($(this).is(":checked") ? $('#all_asradio').prop("checked", true) :    $('#all_asradio').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asdireccion').prop("checked", true) :    $('#all_asdireccion').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asblindaje').prop("checked", true) :    $('#all_asblindaje').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_ascapacidad').prop("checked", true) :    $('#all_ascapacidad').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asgps').prop("checked", true) :    $('#all_asgps').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_asinventario').prop("checked", true) :    $('#all_asinventario').prop("checked", false));
		    //Concursos
		    ($(this).is(":checked") ? $('#all_concursos').prop("checked", true) :    $('#all_concursos').prop("checked", false));
		    //Requisiciones
		    ($(this).is(":checked") ? $('#all_cliunidades').prop("checked", true) :    $('#all_cliunidades').prop("checked", false));
		    //Requisiciones
		    ($(this).is(":checked") ? $('#all_requisiciones').prop("checked", true) :    $('#all_requisiciones').prop("checked", false));
		    //Gestor de Documentos
		    ($(this).is(":checked") ? $('#all_gestordoc').prop("checked", true) :    $('#all_gestordoc').prop("checked", false));
		    	
		});

		$("#all_cliente").click(function(){
			($(this).is(":checked") ? $('.clientes_check').prop("checked", true) :    $('.clientes_check').prop("checked", false))
		});

		$(".clientes_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_9");
			var op_cliente = document.getElementById("op_cliente").value;

			if(op_cliente == 0){
				element.classList.add("active");
				 document.getElementById("op_cliente").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_cliente").value = 0;
			}
		});

		$("#all_estados").click(function(){
			($(this).is(":checked") ? $('.estados_check').prop("checked", true) :    $('.estados_check').prop("checked", false))
		});

		$(".estados_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_10");
			var op_estado = document.getElementById("op_estado").value;

			if(op_estado == 0){
				element.classList.add("active");
				 document.getElementById("op_estado").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_estado").value = 0;
			}
		});

		$("#all_municipios").click(function(){
			($(this).is(":checked") ? $('.municipios_check').prop("checked", true) :    $('.municipios_check').prop("checked", false))
		});


		$(".municipios_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_11");
			var op_municipios = document.getElementById("op_municipios").value;

			if(op_municipios == 0){
				element.classList.add("active");
				 document.getElementById("op_municipios").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_municipios").value = 0;
			}
		});
	// SEGMENTOS

		$("#all_asegmento").click(function(){
			($(this).is(":checked") ? $('.asegmento_check').prop("checked", true) :    $('.asegmento_check').prop("checked", false))
		});

		$(".asegmento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_16");
			var op_asegmento = document.getElementById("op_asegmento").value;

			if(op_asegmento == 0){
				element.classList.add("active");
				 document.getElementById("op_asegmento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asegmento").value = 0;
			}
		});


		$("#all_astipovehiculo").click(function(){
			($(this).is(":checked") ? $('.astipovehiculo_check').prop("checked", true) :    $('.astipovehiculo_check').prop("checked", false))
		});

		$(".astipovehiculo_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_17");
			var op_astipovehiculo = document.getElementById("op_astipovehiculo").value;

			if(op_astipovehiculo == 0){
				element.classList.add("active");
				 document.getElementById("op_astipovehiculo").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_astipovehiculo").value = 0;
			}
		});

		$("#all_aspuerta").click(function(){
			($(this).is(":checked") ? $('.aspuerta_check').prop("checked", true) :    $('.aspuerta_check').prop("checked", false))
		});

		$(".aspuerta_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_18");
			var op_aspuerta = document.getElementById("op_aspuerta").value;

			if(op_aspuerta == 0){
				element.classList.add("active");
				 document.getElementById("op_aspuerta").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_aspuerta").value = 0;
			}
		});

		$("#all_ascarroceria").click(function(){
			($(this).is(":checked") ? $('.ascarroceria_check').prop("checked", true) :    $('.ascarroceria_check').prop("checked", false))
		});

		$(".ascarroceria_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_19");
			var op_ascarroceria = document.getElementById("op_ascarroceria").value;

			if(op_ascarroceria == 0){
				element.classList.add("active");
				 document.getElementById("op_ascarroceria").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_ascarroceria").value = 0;
			}
		});

		$("#all_asnumcilindros").click(function(){
			($(this).is(":checked") ? $('.asnumcilindros_check').prop("checked", true) :    $('.asnumcilindros_check').prop("checked", false))
		});

		$(".asnumcilindros_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_20");
			var op_asnumcilindros = document.getElementById("op_asnumcilindros").value;

			if(op_asnumcilindros == 0){
				element.classList.add("active");
				 document.getElementById("op_asnumcilindros").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asnumcilindros").value = 0;
			}
		});

		$("#all_aspasajeros").click(function(){
			($(this).is(":checked") ? $('.aspasajeros_check').prop("checked", true) :    $('.aspasajeros_check').prop("checked", false))
		});

		$(".aspasajeros_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_21");
			var op_aspasajeros = document.getElementById("op_aspasajeros").value;

			if(op_aspasajeros == 0){
				element.classList.add("active");
				 document.getElementById("op_aspasajeros").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_aspasajeros").value = 0;
			}
		});

		$("#all_motor").click(function(){
			($(this).is(":checked") ? $('.motor_check').prop("checked", true) :    $('.motor_check').prop("checked", false))
		});

		$(".motor_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_22");
			var op_motor = document.getElementById("op_motor").value;

			if(op_motor == 0){
				element.classList.add("active");
				 document.getElementById("op_motor").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_motor").value = 0;
			}
		});

		$("#all_asllantarefaccion").click(function(){
			($(this).is(":checked") ? $('.asllantarefaccion_check').prop("checked", true) :    $('.asllantarefaccion_check').prop("checked", false))
		});

		$(".asllantarefaccion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_23");
			var op_asllantarefaccion = document.getElementById("op_asllantarefaccion").value;

			if(op_asllantarefaccion == 0){
				element.classList.add("active");
				 document.getElementById("op_asllantarefaccion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asllantarefaccion").value = 0;
			}
		});

		$("#all_asespejoslaterales").click(function(){
			($(this).is(":checked") ? $('.asespejoslaterales_check').prop("checked", true) :    $('.asespejoslaterales_check').prop("checked", false))
		});

		$(".asespejoslaterales_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_24");
			var op_asespejoslaterales = document.getElementById("op_asespejoslaterales").value;

			if(op_asespejoslaterales == 0){
				element.classList.add("active");
				 document.getElementById("op_asespejoslaterales").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asespejoslaterales").value = 0;
			}
		});

		$("#all_asaccesorios").click(function(){
			($(this).is(":checked") ? $('.asaccesorios_check').prop("checked", true) :    $('.asaccesorios_check').prop("checked", false))
		});

		$(".asaccesorios_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_25");
			var op_asaccesorios = document.getElementById("op_asaccesorios").value;

			if(op_asaccesorios == 0){
				element.classList.add("active");
				 document.getElementById("op_asaccesorios").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asaccesorios").value = 0;
			}
		});

		$("#all_asapotencia").click(function(){
			($(this).is(":checked") ? $('.asapotencia_check').prop("checked", true) :    $('.asapotencia_check').prop("checked", false))
		});

		$(".asapotencia_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_26");
			var op_aspotencia = document.getElementById("op_asapotencia").value;

			if(op_aspotencia == 0){
				element.classList.add("active");
				 document.getElementById("op_asapotencia").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asapotencia").value = 0;
			}
		});

		$("#all_astransmision").click(function(){
			($(this).is(":checked") ? $('.astransmision_check').prop("checked", true) :    $('.astransmision_check').prop("checked", false))
		});

		$(".astransmision_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_27");
			var op_astransmision = document.getElementById("op_astransmision").value;

			if(op_astransmision == 0){
				element.classList.add("active");
				 document.getElementById("op_astransmision").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_astransmision").value = 0;
			}
		});

		$("#all_asradio").click(function(){
			($(this).is(":checked") ? $('.asradio_check').prop("checked", true) :    $('.asradio_check').prop("checked", false))
		});

		$(".asradio_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asradio");
			var op_asradio = document.getElementById("op_asradio").value;

			if(op_asradio == 0){
				element.classList.add("active");
				 document.getElementById("op_asradio").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asradio").value = 0;
			}
		});

		$("#all_asdireccion").click(function(){
			($(this).is(":checked") ? $('.asdireccion_check').prop("checked", true) :    $('.asdireccion_check').prop("checked", false))
		});

		$(".asdireccion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asdireccion");
			var op_asdireccion = document.getElementById("op_asdireccion").value;

			if(op_asdireccion == 0){
				element.classList.add("active");
				 document.getElementById("op_asdireccion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asdireccion").value = 0;
			}
		});


		$("#all_asblindaje").click(function(){
			($(this).is(":checked") ? $('.asblindaje_check').prop("checked", true) :    $('.asblindaje_check').prop("checked", false))
		});

		$(".asblindaje_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asblindaje");
			var op_asblindaje = document.getElementById("op_asblindaje").value;

			if(op_asblindaje == 0){
				element.classList.add("active");
				 document.getElementById("op_asblindaje").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asblindaje").value = 0;
			}
		});


		$("#all_ascapacidad").click(function(){
			($(this).is(":checked") ? $('.ascapacidad_check').prop("checked", true) :    $('.ascapacidad_check').prop("checked", false))
		});

		$(".ascapacidad_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_ascapacidad");
			var op_ascapacidad = document.getElementById("op_ascapacidad").value;

			if(op_ascapacidad == 0){
				element.classList.add("active");
				 document.getElementById("op_ascapacidad").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_ascapacidad").value = 0;
			}
		});

		$("#all_asgps").click(function(){
			($(this).is(":checked") ? $('.asgps_check').prop("checked", true) :    $('.asgps_check').prop("checked", false))
		});

		$(".asgps_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asgps");
			var op_asgps = document.getElementById("op_asgps").value;

			if(op_asgps == 0){
				element.classList.add("active");
				 document.getElementById("op_asgps").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asgps").value = 0;
			}
		});

		$("#all_asinventario").click(function(){
			($(this).is(":checked") ? $('.asinventario_check').prop("checked", true) :    $('.asinventario_check').prop("checked", false))
		});

		$(".asinventario_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_asinventario");
			var op_asinventario = document.getElementById("op_asinventario").value;

			if(op_asinventario == 0){
				element.classList.add("active");
				 document.getElementById("op_asinventario").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_asinventario").value = 0;
			}
		});


		$("#all_docconcursos").click(function(){
			($(this).is(":checked") ? $('.docconcursos_check').prop("checked", true) :    $('.docconcursos_check').prop("checked", false))
		});

		$(".docconcursos_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_031");
			var op_docconcursos = document.getElementById("op_docconcursos").value;

			if(op_docconcursos == 0){
				element.classList.add("active");
				 document.getElementById("op_docconcursos").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_docconcursos").value = 0;
			}
		});

		$("#all_pubconcursos").click(function(){
			($(this).is(":checked") ? $('.pubconcursos_check').prop("checked", true) :    $('.pubconcursos_check').prop("checked", false))
		});

		$(".pubconcursos_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_032");
			var op_pubconcursos = document.getElementById("op_pubconcursos").value;

			if(op_pubconcursos == 0){
				element.classList.add("active");
				 document.getElementById("op_pubconcursos").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_pubconcursos").value = 0;
			}
		});

		$("#all_tipcontratacion").click(function(){
			($(this).is(":checked") ? $('.tipcontratacion_check').prop("checked", true) :    $('.tipcontratacion_check').prop("checked", false))
		});

		$(".tipcontratacion_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_033");
			var op_tipcontratacion = document.getElementById("op_tipcontratacion").value;

			if(op_tipcontratacion == 0){
				element.classList.add("active");
				 document.getElementById("op_tipcontratacion").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tipcontratacion").value = 0;
			}
		});

		$("#all_tipdoccontrato").click(function(){
			($(this).is(":checked") ? $('.tipdoccontrato_check').prop("checked", true) :    $('.tipdoccontrato_check').prop("checked", false))
		});

		$(".tipdoccontrato_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tipdoccont");
			var op_tipdoccontrato = document.getElementById("op_tipdoccontrato").value;

			if(op_tipdoccontrato == 0){
				element.classList.add("active");
				 document.getElementById("op_tipdoccontrato").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tipdoccontrato").value = 0;
			}
		});


		$("#all_doccliente").click(function(){
			($(this).is(":checked") ? $('.doccliente_check').prop("checked", true) :    $('.doccliente_check').prop("checked", false))
		});

		$(".doccliente_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_doccliente");
			var op_doccliente = document.getElementById("op_doccliente").value;

			if(op_doccliente == 0){
				element.classList.add("active");
				 document.getElementById("op_doccliente").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_doccliente").value = 0;
			}
		});


		$("#all_admincontrato").click(function(){
			($(this).is(":checked") ? $('.admincontrato_check').prop("checked", true) :    $('.admincontrato_check').prop("checked", false))
		});

		$(".admincontrato_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_admincontrato");
			var op_admincontrato = document.getElementById("op_admincontrato").value;

			if(op_admincontrato == 0){
				element.classList.add("active");
				 document.getElementById("op_admincontrato").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_admincontrato").value = 0;
			}
		});

		$("#all_conveniomod").click(function(){
			($(this).is(":checked") ? $('.conveniomod_check').prop("checked", true) :    $('.conveniomod_check').prop("checked", false))
		});

		$(".conveniomod_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_conveniomod");
			var op_admincontrato = document.getElementById("op_conveniomod").value;

			if(op_conveniomod== 0){
				element.classList.add("active");
				 document.getElementById("op_conveniomod").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_conveniomod").value = 0;
			}
		});

		$("#all_tipofianza").click(function(){
			($(this).is(":checked") ? $('.tipofianza_check').prop("checked", true) :    $('.tipofianza_check').prop("checked", false))
		});

		$(".tipofianza_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_tipofianza");
			var op_tipofianza = document.getElementById("op_tipofianza").value;

			if(op_tipofianza== 0){
				element.classList.add("active");
				 document.getElementById("op_tipofianza").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_tipofianza").value = 0;
			}
		});

		$("#all_lequipamiento").click(function(){
			($(this).is(":checked") ? $('.lequipamiento_check').prop("checked", true) :    $('.lequipamiento_check').prop("checked", false))
		});

		$(".lequipamiento_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_lequipamiento");
			var op_lequipamiento = document.getElementById("op_lequipamiento").value;

			if(op_lequipamiento== 0){
				element.classList.add("active");
				 document.getElementById("op_lequipamiento").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_lequipamiento").value = 0;
			}
		});

		$("#all_rtransporte").click(function(){
			($(this).is(":checked") ? $('.rtransporte_check').prop("checked", true) :    $('.rtransporte_check').prop("checked", false))
		});

		$(".rtransporte_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_rtransporte");
			var op_rtransporte = document.getElementById("op_rtransporte").value;

			if(op_rtransporte== 0){
				element.classList.add("active");
				 document.getElementById("op_rtransporte").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_rtransporte").value = 0;
			}
		});


		$("#all_rentidadf").click(function(){
			($(this).is(":checked") ? $('.rentidadf_check').prop("checked", true) :    $('.rentidadf_check').prop("checked", false))
		});

		$(".rentidadf_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_rentidadf");
			var op_rentidadf = document.getElementById("op_rentidadf").value;

			if(op_rentidadf== 0){
				element.classList.add("active");
				 document.getElementById("op_rentidadf").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_rentidadf").value = 0;
			}
		});

		$("#all_rplacas").click(function(){
			($(this).is(":checked") ? $('.rplacas_check').prop("checked", true) :    $('.rplacas_check').prop("checked", false))
		});

		$(".rplacas_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_rplacas");
			var op_rplacas = document.getElementById("op_rplacas").value;

			if(op_rplacas== 0){
				element.classList.add("active");
				 document.getElementById("op_rplacas").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_rplacas").value = 0;
			}
		});

		$("#all_rcombustible").click(function(){
			($(this).is(":checked") ? $('.rcombustible_check').prop("checked", true) :    $('.rcombustible_check').prop("checked", false))
		});

		$(".rcombustible_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_rcombustible");
			var op_rcombustible = document.getElementById("op_rcombustible").value;

			if(op_rcombustible== 0){
				element.classList.add("active");
				 document.getElementById("op_rcombustible").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_rcombustible").value = 0;
			}
		});


		$("#all_catafianzadora").click(function(){
			($(this).is(":checked") ? $('.catafianzadora_check').prop("checked", true) :    $('.catafianzadora_check').prop("checked", false))
		});

		$(".catafianzadora_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_catafianzadora");
			var op_catafianzadora = document.getElementById("op_catafianzadora").value;

			if(op_catafianzadora== 0){
				element.classList.add("active");
				 document.getElementById("op_catafianzadora").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_catafianzadora").value = 0;
			}
		});


		// CONCURSOS
		$("#all_concursos").click(function(){
			($(this).is(":checked") ? $('.concursos_check').prop("checked", true) :    $('.concursos_check').prop("checked", false))
		});

		$(".concursos_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_concursos");
			var op_concursos = document.getElementById("op_concursos").value;

			if(op_concursos == 0){
				element.classList.add("active");
				 document.getElementById("op_concursos").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_concursos").value = 0;
			}
		});

		// Cliente unidades (solo vista)
		$("#all_cliunidades").click(function(){
			($(this).is(":checked") ? $('.cliunidades_check').prop("checked", true) :    $('.cliunidades_check').prop("checked", false))
		});

		$(".cliunidades_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_cliunidades");
			var op_cliunidades = document.getElementById("op_cliunidades").value;

			if(op_cliunidades == 0){
				element.classList.add("active");
				 document.getElementById("op_cliunidades").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_cliunidades").value = 0;
			}
		});

		// Requisiciones
		$("#all_requisiciones").click(function(){
			($(this).is(":checked") ? $('.requisiciones_check').prop("checked", true) :    $('.requisiciones_check').prop("checked", false))
		});

		$(".requisiciones_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_requisiciones");
			var op_requisiciones = document.getElementById("op_requisiciones").value;

			if(op_requisiciones == 0){
				element.classList.add("active");
				 document.getElementById("op_requisiciones").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_requisiciones").value = 0;
			}
		});

		// Gestor Documentos
		$("#all_gestordoc").click(function(){
			($(this).is(":checked") ? $('.gestordoc_check').prop("checked", true) :    $('.gestordoc_check').prop("checked", false))
		});

		$(".gestordoc_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_gestordoc");
			var op_gestordoc = document.getElementById("op_gestordoc").value;

			if(op_gestordoc == 0){
				element.classList.add("active");
				 document.getElementById("op_gestordoc").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_gestordoc").value = 0;
			}
		});

// M O D U L O   D E  D I R E C C I O N   A D M I N I S T R A C I O M  D E  C O N T R A T O S
		$('#all_contratos_check').change(function () {
		    ($(this).is(":checked") ? $('.all_contratos').prop("checked", true) :    $('.all_contratos').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_penalizaciones').prop("checked", true) :    $('.all_penalizaciones').prop("checked", false));
		});


		$("#all_contratos").click(function(){
			($(this).is(":checked") ? $('.contratos_check').prop("checked", true) :    $('.contratos_check').prop("checked", false))
		});

		$(".contratos_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_contratos");
			var op_contratos = document.getElementById("op_contratos").value;

			if(op_contratos == 0){
				element.classList.add("active");
				 document.getElementById("op_contratos").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_contratos").value = 0;
			}
		});


		$("#all_penalizaciones").click(function(){
			($(this).is(":checked") ? $('.penalizaciones_check').prop("checked", true) :    $('.penalizaciones_check').prop("checked", false))
		});

		$(".penalizaciones_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_penalizaciones");
			var op_penalizaciones = document.getElementById("op_penalizaciones").value;

			if(op_penalizaciones == 0){
				element.classList.add("active");
				 document.getElementById("op_penalizaciones").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_penalizaciones").value = 0;
			}
		});


// M O D U L O   D E  D I R E C C I O N   A D M I N I S T R A C I O M  Y   F I N A N Z A S
		$('#all_finanzas_check').change(function () {
		    ($(this).is(":checked") ? $('.all_finanzas').prop("checked", true) :    $('.all_finanzas').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_ordencompra').prop("checked", true) :    $('.all_ordencompra').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_doccompra').prop("checked", true) :    $('.all_doccompra').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_provecompra').prop("checked", true) :    $('.all_provecompra').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_mepago').prop("checked", true) :    $('.all_mepago').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_formpago').prop("checked", true) :    $('.all_formpago').prop("checked", false));
		    ($(this).is(":checked") ? $('.all_usocfdi').prop("checked", true) :    $('.all_usocfdi').prop("checked", false));
		    ($(this).is(":checked") ? $('#all_estimacionfin').prop("checked", true) :    $('.all_usocfdi').prop("checked", false));
		    
		});


		$("#all_finanzas").click(function(){
			($(this).is(":checked") ? $('.finanzas_check').prop("checked", true) :    $('.finanzas_check').prop("checked", false))
		});

		$(".finanzas_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_finanzas");
			var op_finanzas = document.getElementById("op_finanzas").value;

			if(op_finanzas == 0){
				element.classList.add("active");
				 document.getElementById("op_finanzas").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_finanzas").value = 0;
			}
		});


		$("#all_ordencompra").click(function(){
			($(this).is(":checked") ? $('.ordencompra_check').prop("checked", true) :    $('.ordencompra_check').prop("checked", false))
		});

		$(".ordencompra_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_ordencompra");
			var op_ordencompra = document.getElementById("op_ordencompra").value;

			if(op_ordencompra == 0){
				element.classList.add("active");
				 document.getElementById("op_ordencompra").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_ordencompra").value = 0;
			}
		});

		$("#all_estimacionfin").click(function(){
			($(this).is(":checked") ? $('.estimacionfin_check').prop("checked", true) :    $('.estimacionfin_check').prop("checked", false))
		});

		$(".estimacionfin_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_estimacionfin");
			var op_estimacionfin = document.getElementById("op_estimacionfin").value;

			if(op_estimacionfin == 0){
				element.classList.add("active");
				 document.getElementById("op_estimacionfin").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_estimacionfin").value = 0;
			}
		});



		$("#all_doccompra").click(function(){
			($(this).is(":checked") ? $('.doccompra_check').prop("checked", true) :    $('.doccompra_check').prop("checked", false))
		});

		$(".doccompra_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_doccompra");
			var op_doccompra = document.getElementById("op_doccompra").value;

			if(op_doccompra == 0){
				element.classList.add("active");
				 document.getElementById("op_doccompra").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_doccompra").value = 0;
			}
		});

		$("#all_provecompra").click(function(){
			($(this).is(":checked") ? $('.provecompra_check').prop("checked", true) :    $('.provecompra_check').prop("checked", false))
		});

		$(".provecompra_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_provecompra");
			var op_provecompra = document.getElementById("op_provecompra").value;

			if(op_provecompra == 0){
				element.classList.add("active");
				 document.getElementById("op_provecompra").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_provecompra").value = 0;
			}
		});

		$("#all_mepago").click(function(){
			($(this).is(":checked") ? $('.mepago_check').prop("checked", true) :    $('.mepago_check').prop("checked", false))
		});

		$(".mepago_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_mepago");
			var op_mepago = document.getElementById("op_mepago").value;

			if(op_mepago == 0){
				element.classList.add("active");
				 document.getElementById("op_mepago").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_mepago").value = 0;
			}
		});

		$("#all_formpago").click(function(){
			($(this).is(":checked") ? $('.formpago_check').prop("checked", true) :    $('.formpago_check').prop("checked", false))
		});

		$(".formpago_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_formpago");
			var op_formpago = document.getElementById("op_formpago").value;

			if(op_formpago == 0){
				element.classList.add("active");
				 document.getElementById("op_formpago").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_formpago").value = 0;
			}
		});

		$("#all_usocfdi").click(function(){
			($(this).is(":checked") ? $('.usocfdi_check').prop("checked", true) :    $('.usocfdi_check').prop("checked", false))
		});

		$(".usocfdi_tab").click(function(){
			var element = document.getElementById("kt_tab_pane_usocfdi");
			var op_usocfdi = document.getElementById("op_usocfdi").value;

			if(op_usocfdi == 0){
				element.classList.add("active");
				 document.getElementById("op_usocfdi").value = 1;
			}else{
				element.classList.remove("active");
				document.getElementById("op_usocfdi").value = 0;
			}
		});