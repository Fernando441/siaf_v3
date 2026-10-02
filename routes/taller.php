<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;
    use App\Http\Controllers\Taller\TallerController;

	//MANTENIMIENTO
	Route::get('/solicitar-atencion', [App\Http\Controllers\Taller\TallerController::class, 'solicitarAtencion'])->name('taller.solicitaratencion');
	Route::post('/buscar-unidad', [App\Http\Controllers\Taller\TallerController::class, 'buscarUnidad'])->name('taller.buscarunidad');
	Route::post('/registrar-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'registrarSolicitud'])->name('taller.registrarsolicitud');
	Route::get('/catalogo-talleres', [App\Http\Controllers\Taller\TallerController::class, 'catalogoTalleres'])->name('taller.catalogotalleres');

	// MANTENIMIENTO CLIENTES
	Route::group(['prefix' => 'clientes'], function () {
		Route::get('/ver-mantenimientos', [App\Http\Controllers\Taller\TallerController::class, 'verMantenimientos'])->name('taller.clientes.vermantenimientos');
		Route::get('/solicitar-atencion', [App\Http\Controllers\Taller\TallerController::class, 'solicitarAtencionCliente'])->name('taller.clientes.solicitaratencion');
	});

	// MANTENIMIENTO TALLERES
	Route::group(['prefix' => 'garage'], function () {
		Route::get('/ver-mantenimientos', [App\Http\Controllers\Taller\TallerController::class, 'garageVerMantenimientos'])->name('taller.garage.vermantenimientos');
		Route::post('/dt-solicitudes', [App\Http\Controllers\Taller\TallerController::class, 'solicitudesGarageDatatable'])->name('taller.garage.solicitudesdatatable');
	});

	//SOLICITUDES DE MANTENIMIENTO
	// VER DATA DE SOLICITUDES
	Route::get('/servicios-solicitados', [App\Http\Controllers\Taller\TallerController::class, 'listarSolicitudes'])->name('taller.serviciossolicitados');
	Route::get('/ver-solicitud/{id}', [App\Http\Controllers\Taller\TallerController::class, 'verSolicitud'])->name('taller.versolicitud');
	Route::post('/dt-taller', [App\Http\Controllers\Taller\TallerController::class, 'solicitudesDatatable'])->name('taller.solicitudesdatatable');

	// ASIGNAR CONTRATO A USUARIO (EJECUTIVO)
	Route::get('/asignar-contrato', [App\Http\Controllers\Taller\TallerController::class, 'asignarContrato'])->name('taller.asignarcontrato');

	// ASIGNAR TALLER A USUARIO
	Route::get('/asignar-taller-usuario', [App\Http\Controllers\Taller\TallerController::class, 'asignarTallerUsuario'])->name('.asignartallerusuario');
	Route::post('/asignar-taller-usuario', [App\Http\Controllers\Taller\TallerController::class, 'asignarTallerUsuarioPost'])->name('taller.asignartallerusuariopost');

	//DOCUMENTOS DE SOLICITUDES
	Route::get('/documentos-solicitud/{id}', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'documentosSolicitud'])->name('taller.documentossolicitud');
	Route::post('/guardar-documento', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'guardarDocumento'])->name('taller.guardardocumento');
	Route::post('/dt-documentos', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'documentosDatatable'])->name('taller.documentosdatatable');
	Route::post('/get-tabla-documentos', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'getTablaDocumentos'])->name('taller.gettabladocumentos');
	Route::post('/eliminar-archivo', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'eliminarArchivo'])->name('taller.eliminararchivo');
	Route::post('/guardar-cotizacion', [App\Http\Controllers\Taller\DocumentosSolicitudController::class, 'guardarCotizacion'])->name('taller.guardarCotizacion');

	//PETICIONES
	Route::post('/autorizar_solicitud', [App\Http\Controllers\Taller\TallerController::class, 'autorizarSolicitud'])->name('taller.autorizarsolicitud');
	Route::post('/autorizar_para_evidencia', [App\Http\Controllers\Taller\TallerController::class, 'autorizarParaEvidencia'])->name('taller.autorizarparaevidencia');
	Route::post('/rechazar_solicitud', [App\Http\Controllers\Taller\TallerController::class, 'rechazarSolicitud'])->name('taller.rechazarsolicitud');
	Route::post('/buscar-proveedor', [App\Http\Controllers\Taller\TallerController::class, 'buscarProveedor'])->name('taller.buscarproveedor');
	Route::post('/get-cuenta', [App\Http\Controllers\Taller\TallerController::class, 'getCuenta'])->name('taller.getcuenta');
	Route::post('/get-direccion', [App\Http\Controllers\Taller\TallerController::class, 'getDireccion'])->name('taller.getdireccion');
	Route::post('/preautorizar_con_evidencia', [App\Http\Controllers\Taller\TallerController::class, 'preautorizarConEvidencia'])->name('taller.preautorizarconevidencia');
	Route::post('/confirmar_pago', [App\Http\Controllers\Taller\TallerController::class, 'confirmarPago'])->name('taller.confirmarpago');
	Route::post('/finalizar_solicitud', [App\Http\Controllers\Taller\TallerController::class, 'finalizarSolicitud'])->name('taller.finalizarsolicitud');
	


	// VALIDACION DE MANTENIMIENTO    --------  Supervisor del ejecutivo de mantenimiento
	// VER DATA DE SOLICITUDES
	Route::post('/asignar-taller-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'tallerasignadosolicitud'])->name('taller.tallerasignadosolicitud');
	Route::post('/eliminar-taller-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'eliminartallerasignado'])->name('taller.eliminartallerasignado');
	Route::get('/validacion-mantenimiento', [App\Http\Controllers\Taller\TallerController::class, 'Validacionmantenimientos'])->name('taller.Validacionmantenimientos');
	Route::get('/ver-solicitud-mantenimiento/{id}', [App\Http\Controllers\Taller\TallerController::class, 'verSolicitudvalidacion'])->name('taller.versolicitudvalidacion');
	Route::post('/mantenimiento-finanzas', [App\Http\Controllers\Taller\TallerController::class, 'solicitudafinanzas'])->name('taller.solicitudafinanzas');
	Route::post('/rechazar-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'rechazarsolicitudmantenimiento'])->name('taller.rechazarsolicitudmantenimiento');
	Route::post('/validar-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'validacionsolicitudmantenimiento'])->name('taller.validacionsolicitudmantenimiento');
	Route::post('/validar-solicitud-aleatorio', [App\Http\Controllers\Taller\TallerController::class, 'validacionsolicitudmantenimientoaleatorio'])->name('taller.validacionsolicitudmantenimientoaleatorio');
	Route::post('/evidencias-solicitud-taller', [App\Http\Controllers\Taller\TallerController::class, 'evidenciassolicitudtaller'])->name('taller.evidenciassolicitudtaller');
	Route::post('/evidencias-solicitud-taller-eliminar', [App\Http\Controllers\Taller\TallerController::class, 'eliminarevidenciataller'])->name('taller.eliminarevidenciataller');

	//EVALUACION TALLER
	Route::post('/evaluacion-solicitud-taller', [App\Http\Controllers\Taller\TallerController::class, 'evaluaciontaller'])->name('taller.evaluaciontaller');


	//EDITAR Y ACTUALIZAR SOLICITUD
	Route::get('/editar-solicitud/{id}', [App\Http\Controllers\Taller\TallerController::class, 'editarSolicitud'])->name('taller.editarsolicitud');
	Route::post('/actualizar-solicitud', [App\Http\Controllers\Taller\TallerController::class, 'actualizarSolicitud'])->name('taller.actualizarsolicitud');
	Route::post('/dtvalidacion-taller', [App\Http\Controllers\Taller\TallerController::class, 'solicitudesValidacionDatatable'])->name('taller.solicitudesvalidaciondatatable');

		// VALIDACION DE MANTENIMIENTO    -------- DOS Ejecutivo de mantenimiento
	Route::get('/validacion-solicitud-mantenimiento', [App\Http\Controllers\Taller\TallerController::class, 'Validacionmantenimientosejecutivo'])->name('taller.Validacionmantenimientosejecutivo');
	Route::post('/dtvalidacion-taller-ejecutivo', [App\Http\Controllers\Taller\TallerController::class, 'solicitudesValidacionDatatableejecutivo'])->name('taller.solicitudesvalidaciondatatableejecutivo');
	Route::get('/ver-solicitud-mantenimiento-confirmacion/{id}', [App\Http\Controllers\Taller\TallerController::class, 'verSolicitudvalidacionejecutivo'])->name('taller.versolicitudvalidacionejecutivo');
	Route::post('/validar-solicitud-ejecutivo', [App\Http\Controllers\Taller\TallerController::class, 'validacionsolicitudmantenimientoejecutivo'])->name('taller.validacionsolicitudmantenimientoejecutivo');
	Route::post('/rechazar-solicitud-ejecutivo', [App\Http\Controllers\Taller\TallerController::class, 'rechazarsolicitudmantenimientoejecutivo'])->name('taller.rechazarsolicitudmantenimientoejecutivo');
	Route::post('/evecutivo-no-disponible', [App\Http\Controllers\Taller\TallerController::class, 'ejecutivonodisponible'])->name('taller.ejecutivonodisponible');
	Route::post('/evecutivo-disponible', [App\Http\Controllers\Taller\TallerController::class, 'ejecutivodisponible'])->name('taller.ejecutivodisponible');
	Route::get('/evidencias-taller/{id}', [App\Http\Controllers\Taller\TallerController::class, 'evidenciastaller'])->name('taller.evidenciastaller');
	Route::post('/evaluacion-ejecutivo-taller', [App\Http\Controllers\Taller\TallerController::class, 'evaluaciontallerejecutivo'])->name('taller.evaluaciontallerejecutivo');


	// RESPONSABLE DE MANTENIMIENTO
	Route::get('/responsable-mantenimiento', [App\Http\Controllers\Taller\TallerController::class, 'responsablemantenimiento'])->name('taller.responsablemantenimiento');
	Route::get('/ver-solicitud-responsable-mantenimiento/{id}', [App\Http\Controllers\Taller\TallerController::class, 'versolicitudresponsablemantenimiento'])->name('taller.versolicitudresponsablemantenimiento');


	//ASIGNAR TALLER
	Route::get('/listado-taller-solicitud/{id}', [App\Http\Controllers\Taller\TallerController::class, 'listadotallersol'])->name('taller.listadotallersol');
	Route::get('/complementar-taller-solicitud/{id}/{taller}', [App\Http\Controllers\Taller\TallerController::class, 'complementartallersol'])->name('taller.complementartallersol');

	//CATALOGOS
	Route::get('/tipo-solicitud', [App\Http\Controllers\Taller\TipoSolicitudController::class, 'catalogoTipoSolicitud'])->name('taller.catalogotiposolicitud');
	Route::post('/dt-tipo-solicitud', [App\Http\Controllers\Taller\TipoSolicitudController::class, 'tipoSolicitudDatatable'])->name('taller.tiposolicituddatatable');
	Route::post('/guardar-tipo-solicitud', [App\Http\Controllers\Taller\TipoSolicitudController::class, 'guardarTipoSolicitud'])->name('taller.guardartiposolicitud');
	Route::post('/editar-tiposolicitud', [App\Http\Controllers\Taller\TipoSolicitudController::class, 'editarTipoSolicitud'])->name('taller.editartiposolicitud');


	//TIPO DE SERVICIOS TALLER
	Route::get('/catalogo-servicios-taller', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'serviciostaller'])->name('servtaller.serviciostaller');
	Route::post('/servicios-datatable', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'serviciosdatatable'])->name('servtaller.serviciosdatatable');
	Route::post('/guardar-servicio', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'guardarservicio'])->name('servtaller.guardarservicio');
	Route::post('/editar-servicio', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'editarservicio'])->name('servtaller.editarservicio');
	Route::post('/desactivar-servicio', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'desactivarservicio'])->name('servtaller.desactivarservicio');
	Route::get('/catalogo-servicio-inactivos', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'catalogoserviciosinactivas'])->name('servtaller.catalogoserviciosinactivas');
	Route::post('/activar-servicio', [App\Http\Controllers\Taller\ServiciosTallerController::class, 'activarservicio'])->name('servtaller.activarservicio');

	//TIPO DE DOCUMENTO TALLER
	Route::get('/catalogo-documentos-taller', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'tipodocumentotaller'])->name('tipdoctaller.tipodocumentotaller');
	Route::post('/documentostipotall-datatable', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'tipodocumentotallerdatatable'])->name('tipdoctaller.tipodocumentotallerdatatable');
	Route::post('/guardar-tipodocumento-taller', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'guardartipodocumentotall'])->name('tipdoctaller.guardartipodocumentotall');
	Route::post('/editar-tipodocumento-taller', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'editartipodocumentotaller'])->name('tipdoctaller.editartipodocumentotaller');
	Route::post('/desactivar-tipodocumento-taller', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'desactivartipdoctaler'])->name('tipdoctaller.desactivartipdoctaler');
	Route::get('/catalogo-tipodocumentotaller-inactivos', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'catalogotipdoctallerinactivas'])->name('tipdoctaller.catalogotipdoctallerinactivas');
	Route::post('/activar-tipodocumentotaller', [App\Http\Controllers\Taller\TipoDocumentoTallerController::class, 'activartipodocumentotaller'])->name('tipdoctaller.activartipodocumentotaller');


	//INVENTARIO DE TALLERES
	Route::get('/inventario-talleres', [App\Http\Controllers\Taller\InventarioTallerController::class, 'inventariotaller'])->name('invtaller.inventariotaller');
	Route::post('/talleres-inv-datatable', [App\Http\Controllers\Taller\InventarioTallerController::class, 'invtallerdatatable'])->name('invtaller.invtallerdatatable');
	Route::get('/crear-tallerer', [App\Http\Controllers\Taller\InventarioTallerController::class, 'creartaller'])->name('invtaller.creartaller');
	Route::post('/guardar-taller', [App\Http\Controllers\Taller\InventarioTallerController::class, 'guardartaller'])->name('invtaller.guardartaller');
	Route::get('/editar-taller/{id}', [App\Http\Controllers\Taller\InventarioTallerController::class, 'editartaller'])->name('invtaller.editartaller');
	Route::post('/eliminar-documento-taller', [App\Http\Controllers\Taller\InventarioTallerController::class, 'eliminardocumentotaller'])->name('invtaller.eliminardocumentotaller');
	Route::post('/modificar-taller', [App\Http\Controllers\Taller\InventarioTallerController::class, 'modificartaller'])->name('invtaller.modificartaller');
	Route::post('/desactivar-taller-inv', [App\Http\Controllers\Taller\InventarioTallerController::class, 'desactivarintaller'])->name('invtaller.desactivarintaller');
	Route::get('/inventario-talleres-inactivos', [App\Http\Controllers\Taller\InventarioTallerController::class, 'inventariotallerinactivo'])->name('invtaller.inventariotallerinactivo');
	Route::post('/activar-taller-inv', [App\Http\Controllers\Taller\InventarioTallerController::class, 'activarintaller'])->name('invtaller.activarintaller');
	Route::get('/evaluacion-taller/{id}/{solicitud}', [App\Http\Controllers\Taller\InventarioTallerController::class, 'evaluaciontaller'])->name('invtaller.evaluaciontaller');
	Route::get('/ver-taller/{id}', [App\Http\Controllers\Taller\InventarioTallerController::class, 'vertaller'])->name('invtaller.vertaller');


	// VISTA USUATRIOS TALLERES
	Route::get('/listado-solicitu-mantenimiento-tl', [App\Http\Controllers\Taller\UsuarioTallerController::class, 'listadosolmanttl'])->name('tllmodulo.listadosolmanttl');
	Route::post('/dtvalidacion-taller-tll', [App\Http\Controllers\Taller\UsuarioTallerController::class, 'dtmantenimientotll'])->name('tllmodulo.dtmantenimientotll');
	Route::get('/ver-solicitud-mantenimiento-tll/{id}', [App\Http\Controllers\Taller\UsuarioTallerController::class, 'versolicitudtll'])->name('tllmodulo.versolicitudtll');
	Route::get('/evidencias-solicitud-mantenimiento-tll/{id}', [App\Http\Controllers\Taller\UsuarioTallerController::class, 'evidenciastall'])->name('tllmodulo.evidenciastall');