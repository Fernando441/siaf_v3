<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	// Listado De unidades
		Route::get('/catalogo-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'catalogounidad'])->name('unidad.catalogounidad')->middleware('permission:unidad-list');
		Route::post('/unidad-datatable', [App\Http\Controllers\Unidad\UnidadController::class, 'unidaddatatable'])->name('unidad.unidaddatatable')->middleware('permission:unidad-list');
		Route::get('/carga-masiva-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'cargamasiva'])->name('unidad.cargamasiva');
		Route::get('/agregar-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'agregarunidad'])->name('unidad.agregarunidad')->middleware('permission:unidad-create');
		Route::post('/guardar-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'guardarunidad'])->name('unidad.guardarunidad')->middleware('permission:unidad-create');
		Route::get('/editar-unidad/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'editarunidad'])->name('unidad.editarunidad')->middleware('permission:unidad-edit');
		Route::post('/agregar-foto-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'guardarfotounidad'])->name('unidad.guardarfotounidad')->middleware('permission:unidad-create');
		Route::get('/estadisticas-unidades', [App\Http\Controllers\Unidad\UnidadController::class, 'estadisticas'])->name('unidad.estadisticas');
		Route::post('/editar-infobasica', [App\Http\Controllers\Unidad\UnidadController::class, 'editarinfobasica'])->name('unidad.editarinfobasica')->middleware('permission:unidad-edit');
		Route::post('/editar-infocomplemento', [App\Http\Controllers\Unidad\UnidadController::class, 'editarinfocomplemento'])->name('unidad.editarinfocomplemento')->middleware('permission:unidad-edit');
		Route::get('/unidad/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'informacionunidad'])->name('unidad.informacionunidad');
		Route::get('/catalogo-unidades-inactivas', [App\Http\Controllers\Unidad\UnidadController::class, 'catalogounidaddesinactivas'])->name('unidad.catalogounidaddesinactivas')->middleware('permission:unidad-edit');
		Route::post('/desactivar-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'eliminarunidad'])->name('unidad.eliminarunidad')->middleware('permission:unidad-delete');
		Route::post('/activar-unidad', [App\Http\Controllers\Unidad\UnidadController::class, 'activarunidad'])->name('unidad.activarunidad')->middleware('permission:unidad-delete');
		Route::get('/ver-unidad/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'verUnidad'])->name('unidad.verunidad');
		Route::post('/eliminar-documento', [App\Http\Controllers\Unidad\UnidadController::class, 'eliminardocumento'])->name('unidad.eliminardocumento')->middleware('permission:unidad-edit');
		Route::post('/eliminar-fotografia', [App\Http\Controllers\Unidad\UnidadController::class, 'eliminarfotografia'])->name('unidad.eliminarfotografia')->middleware('permission:unidad-edit');
		Route::post('/carga-masiva', [App\Http\Controllers\Unidad\UnidadController::class, 'cargamasivaexcel'])->name('unidad.cargamasivaexcel');
		Route::get('/informacion-seguro/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'informacionseguro'])->name('unidad.informacionseguro');
		Route::post('/agregar-info-seguro', [App\Http\Controllers\Unidad\UnidadController::class, 'guardarinfoseguro'])->name('unidad.guardarinfoseguro');
		Route::post('/editar-info-seguro', [App\Http\Controllers\Unidad\UnidadController::class, 'editarinfoseguro'])->name('unidad.editarinfoseguro');
		Route::get('/informacion-gps/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'informaciongps'])->name('unidad.informaciongps');
		Route::post('/agregar-info-gps', [App\Http\Controllers\Unidad\UnidadController::class, 'guardarinfogps'])->name('unidad.guardarinfogps');
		Route::post('/editar-info-gps', [App\Http\Controllers\Unidad\UnidadController::class, 'editarinfogps'])->name('unidad.editarinfogps');
		Route::get('/tramites-vehiculares/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'tramitesvehiculares'])->name('unidad.tramitesvehiculares');
		Route::get('/equipamiento-unidad/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'equipamientounidad'])->name('unidad.equipamientounidad');
        Route::get('/venta/{unidad}', [App\Http\Controllers\Unidad\UnidadController::class, 'venta'])->name('unidad.venta')->middleware('permission:unidad-venta');
        Route::post('/venta-guardar', [App\Http\Controllers\Unidad\UnidadController::class, 'ventaGuardar'])->name('unidad.ventaGuardar')->middleware('permission:unidad-venta');

	// Listado de Marcas
		Route::get('/catalogo-marcas', [App\Http\Controllers\Unidad\MarcaController::class, 'catalogomarcas'])->name('marcas.catalogomarcas')->middleware('permission:marca-list');
		Route::post('/marcas-datatable', [App\Http\Controllers\Unidad\MarcaController::class, 'marcadatatable'])->name('marcas.marcadatatable')->middleware('permission:marca-list');
		Route::post('/guardar-marca', [App\Http\Controllers\Unidad\MarcaController::class, 'guardarmarca'])->name('marcas.guardarmarca')->middleware('permission:marca-create');
		Route::post('/editar-marca', [App\Http\Controllers\Unidad\MarcaController::class, 'editarmarca'])->name('marcas.editarmarca')->middleware('permission:marca-edit');
		Route::post('/desactivar-marca', [App\Http\Controllers\Unidad\MarcaController::class, 'desactivarmarca'])->name('marcas.desactivarmarca')->middleware('permission:marca-delete');
		Route::get('/catalogo-marcas-inactivas', [App\Http\Controllers\Unidad\MarcaController::class, 'catalogomarcasinactivas'])->name('marcas.catalogomarcasinactivas')->middleware('permission:marca-list');
		Route::post('/activar-marca', [App\Http\Controllers\Unidad\MarcaController::class, 'activarmarca'])->name('marcas.activarmarca')->middleware('permission:marca-delete');

	// Listado de Modelos
		Route::get('/catalogo-modelos', [App\Http\Controllers\Unidad\ModeloController::class, 'catalogomodelos'])->name('modelos.catalogomodelos')->middleware('permission:modelo-list');
		Route::post('/modelo-datatable', [App\Http\Controllers\Unidad\ModeloController::class, 'modelodatatable'])->name('modelos.modelodatatable')->middleware('permission:modelo-list');
		Route::post('/guardar-modelo', [App\Http\Controllers\Unidad\ModeloController::class, 'guardarmodelo'])->name('modelos.guardarmodelo')->middleware('permission:modelo-create');
		Route::post('/editar-modelo', [App\Http\Controllers\Unidad\ModeloController::class, 'editarmodelo'])->name('modelos.editarmodelo')->middleware('permission:modelo-edit');
		Route::post('/desactivar-modelo', [App\Http\Controllers\Unidad\ModeloController::class, 'desactivarmodelo'])->name('modelos.desactivarmodelo')->middleware('permission:modelo-delete');
		Route::get('/catalogo-modelos-inactivos', [App\Http\Controllers\Unidad\ModeloController::class, 'catalogomodelosinactivos'])->name('modelos.catalogomodelosinactivos')->middleware('permission:modelo-list');
		Route::post('/activar-modelo', [App\Http\Controllers\Unidad\ModeloController::class, 'activarmodelo'])->name('modelos.activarmodelo')->middleware('permission:modelo-delete');

	// Listado de Ubicaciones                                                                                                                                                         
		Route::get('/catalogo-ubicaciones', [App\Http\Controllers\Unidad\UbicacionController::class, 'catalogoubicaciones'])->name('ubicacion.catalogoubicaciones')->middleware('permission:patio-list');
		Route::post('/ubicacion-datatable', [App\Http\Controllers\Unidad\UbicacionController::class, 'ubicaciondatatable'])->name('ubicacion.ubicaciondatatable')->middleware('permission:patio-list');
		Route::post('/guardar-ubicacion', [App\Http\Controllers\Unidad\UbicacionController::class, 'guardarubicacion'])->name('ubicacion.guardarubicacion')->middleware('permission:patio-create');
		Route::post('/editar-ubicacion', [App\Http\Controllers\Unidad\UbicacionController::class, 'editarubicacion'])->name('ubicacion.editarubicacion')->middleware('permission:patio-edit');
		Route::post('/desactivar-ubicacion', [App\Http\Controllers\Unidad\UbicacionController::class, 'desactivarubicacion'])->name('ubicacion.desactivarubicacion')->middleware('permission:patio-delete');
		Route::get('/catalogo-ubicaciones-inactivas', [App\Http\Controllers\Unidad\UbicacionController::class, 'catalogoubicacionesinactivas'])->name('ubicacion.catalogoubicacionesinactivas')->middleware('permission:patio-list');
		Route::post('/activar-ubicacion', [App\Http\Controllers\Unidad\UbicacionController::class, 'activarubicacion'])->name('ubicacion.activarubicacion')->middleware('permission:patio-delete');
		Route::get('/ver-ubicacion/{ubicacion}', [App\Http\Controllers\Unidad\UbicacionController::class, 'verubicacion'])->name('ubicacion.verubicacion');

	// Listado de Estatus
		Route::get('/catalogo-estatus', [App\Http\Controllers\Unidad\EstatusController::class, 'catalogoestatus'])->name('estatus.catalogoestatus')->middleware('permission:estatus-list');
		Route::post('/estatus-datatable', [App\Http\Controllers\Unidad\EstatusController::class, 'estatusdatatable'])->name('estatus.estatusdatatable')->middleware('permission:estatus-list');
		Route::post('/guardar-estatus', [App\Http\Controllers\Unidad\EstatusController::class, 'guardarestatus'])->name('estatus.guardarestatus')->middleware('permission:estatus-create');
		Route::post('/editar-estatus', [App\Http\Controllers\Unidad\EstatusController::class, 'editarestatus'])->name('estatus.editarestatus')->middleware('permission:estatus-edit');
		Route::post('/desactivar-estatus', [App\Http\Controllers\Unidad\EstatusController::class, 'eliminarestatus'])->name('estatus.eliminarestatus')->middleware('permission:estatus-delete');
		Route::get('/catalogo-estatus-inactivos', [App\Http\Controllers\Unidad\EstatusController::class, 'catalogoestatusinactivos'])->name('estatus.catalogoestatuseliminados')->middleware('permission:estatus-list');
		Route::post('/activar-estatus', [App\Http\Controllers\Unidad\EstatusController::class, 'activarestatus'])->name('estatus.activarestatus')->middleware('permission:estatus-delete');

	// Listado de Aseguradora
		Route::get('/catalogo-aseguradora', [App\Http\Controllers\Unidad\AseguradoraController::class, 'catalogoaseguradoras'])->name('aseguradora.catalogoaseguradora')->middleware('permission:aseguradora-list');
		Route::post('/aseguradora-datatable', [App\Http\Controllers\Unidad\AseguradoraController::class, 'aseguradoradatatable'])->name('aseguradora.aseguradoradatatable')->middleware('permission:aseguradora-list');
		Route::get('/nueva-aseguradora/', [App\Http\Controllers\Unidad\AseguradoraController::class, 'crearaseguradoras'])->name('aseguradora.crearaseguradoras')->middleware('permission:aseguradora-create');
		Route::post('/guardar-aseguradora', [App\Http\Controllers\Unidad\AseguradoraController::class, 'guardaraseguradora'])->name('aseguradora.guardaraseguradora')->middleware('permission:aseguradora-create');
		Route::get('/modificar-aseguradora/{aseguradora}', [App\Http\Controllers\Unidad\AseguradoraController::class, 'modificaraseguradoras'])->name('aseguradora.modificaraseguradoras')->middleware('permission:aseguradora-edit');
		Route::post('/editar-aseguradora', [App\Http\Controllers\Unidad\AseguradoraController::class, 'editaraseguradora'])->name('aseguradora.editaraseguradora')->middleware('permission:aseguradora-edit');
		Route::post('/desactivar-aseguradora', [App\Http\Controllers\Unidad\AseguradoraController::class, 'eliminaraseguradora'])->name('aseguradora.eliminaraseguradora')->middleware('permission:aseguradora-delete');
		Route::get('/catalogo-aseguradoras-inactivas', [App\Http\Controllers\Unidad\AseguradoraController::class, 'catalogoaseguradorasinactivas'])->name('aseguradora.catalogoaseguradoraseliminadas')->middleware('permission:aseguradora-list');
		Route::post('/activar-aseguradora', [App\Http\Controllers\Unidad\AseguradoraController::class, 'activaraseguradora'])->name('aseguradora.activaraseguradora')->middleware('permission:aseguradora-delete');

	// Listado de Agencias 
		Route::get('/catalogo-agencias', [App\Http\Controllers\Unidad\AgenciaController::class, 'catalogoagencias'])->name('agencia.catalogoagencias')->middleware('permission:agencia-list');
		Route::post('/agencias-datatable', [App\Http\Controllers\Unidad\AgenciaController::class, 'agenciadatatable'])->name('agencia.agenciadatatable')->middleware('permission:agencia-list');
		Route::get('/crear-aseguradora', [App\Http\Controllers\Unidad\AgenciaController::class, 'crearagencias'])->name('agencia.crearagencias')->middleware('permission:agencia-create');
		Route::post('/guardar-agencia', [App\Http\Controllers\Unidad\AgenciaController::class, 'guardaragencia'])->name('agencia.guardaragencia')->middleware('permission:agencia-create');
		Route::get('/modificar-agencia/{agencia}', [App\Http\Controllers\Unidad\AgenciaController::class, 'modificaragencia'])->name('agencia.modificaragencia')->middleware('permission:agencia-edit');
		Route::post('/editar-agencia', [App\Http\Controllers\Unidad\AgenciaController::class, 'editaragencia'])->name('agencia.editaragencia')->middleware('permission:agencia-edit');
		Route::post('/desactivar-agencia', [App\Http\Controllers\Unidad\AgenciaController::class, 'eliminaragencia'])->name('agencia.eliminaragencia')->middleware('permission:agencia-delete');
		Route::get('/catalogo-agencias-inactivas', [App\Http\Controllers\Unidad\AgenciaController::class, 'catalogoagenciasinactivas'])->name('agencia.catalogoagenciaseliminadas')->middleware('permission:agencia-list');
		Route::post('/activar-agencia', [App\Http\Controllers\Unidad\AgenciaController::class, 'activaragencia'])->name('agencia.activaragencia')->middleware('permission:agencia-delete');

	// Listado de Proveedores
		Route::get('/catalogo-proveedores', [App\Http\Controllers\Unidad\ProveedoresController::class, 'catalogoproveedores'])->name('proveedor.catalogoproveedores');
		Route::post('/proveedores-datatable', [App\Http\Controllers\Unidad\ProveedoresController::class, 'proveedordatatable'])->name('proveedor.proveedordatatable');
		Route::get('/crear-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'crearproveedor'])->name('proveedor.crearproveedor');
		Route::post('/guardar-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'guardarproveedor'])->name('proveedor.guardarproveedor');
		Route::get('/modificar-proveedor/{proveedor}', [App\Http\Controllers\Unidad\ProveedoresController::class, 'modificarproveedor'])->name('proveedor.modificarproveedor');
		Route::post('/editar-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'editarproveedor'])->name('proveedor.editarproveedor');
		Route::post('/desactivar-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'eliminarproveedor'])->name('proveedor.eliminarproveedor');
		Route::get('/catalogo-proveedores-inactivos', [App\Http\Controllers\Unidad\ProveedoresController::class, 'catalogoproveedoreseliminadas'])->name('proveedor.catalogoproveedoreseliminadas');
		Route::post('/activar-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'activarproveedor'])->name('proveedor.activarproveedor');
		Route::post('/check-proveedor', [App\Http\Controllers\Unidad\ProveedoresController::class, 'checkProveedor'])->name('proveedor.check');

	// Listado de Documentos
		Route::get('/catalogo-tipo-documentos', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'catalogodocumentos'])->name('documento.catalogodocumentos')->middleware('permission:tdocumento-list');
		Route::post('/documentos-datatable', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'documentodatatable'])->name('documento.documentodatatable')->middleware('permission:tdocumento-list');
		Route::post('/guardar-documento', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'guardardocumento'])->name('documento.guardardocumento')->middleware('permission:tdocumento-create');
		Route::post('/editar-documento', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'editardocumento'])->name('documento.editardocumento')->middleware('permission:tdocumento-edit');
		Route::post('/desactivar-documento', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'desactivardocumento'])->name('documento.desactivardocumento')->middleware('permission:tdocumento-delete');
		Route::get('/catalogo-documentos-inactivos', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'catalogodocumentoseliminadas'])->name('documento.catalogodocumentoseliminadas')->middleware('permission:tdocumento-list');
		Route::post('/activar-documento', [App\Http\Controllers\Unidad\TipoDocumentosController::class, 'activardocumento'])->name('documento.activardocumento')->middleware('permission:tdocumento-delete');

	// Listado de Tipo de Asignacion
		Route::get('/catalogo-tipo-asignacion', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'catalogotipoasignacion'])->name('tipoasignacion.catalogotipoasignacion')->middleware('permission:tasignacion-list');
		Route::post('/tipoasignacion-datatable', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'tipoasignaciondatatable'])->name('tipoasignacion.tipoasignaciondatatable')->middleware('permission:tasignacion-list');
		Route::post('/guardar-tipoasignacion', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'guardartipoasignacion'])->name('tipoasignacion.guardartipoasignacion')->middleware('permission:tasignacion-create');
		Route::post('/editar-tipoasignacion', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'editartipoasignacion'])->name('tipoasignacion.editartipoasignacion')->middleware('permission:tasignacion-edit');
		Route::post('/desactivar-tipoasignacion', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'eliminartipoasignacion'])->name('tipoasignacion.eliminartipoasignacion')->middleware('permission:tasignacion-delete');
		Route::get('/catalogo-tipoasignacion-inactivos', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'catalogotipoasignacioneliminadas'])->name('tipoasignacion.catalogotipoasignacioneliminadas')->middleware('permission:tasignacion-list');
		Route::post('/activar-tipoasignacion', [App\Http\Controllers\Unidad\TipoAsignacionController::class, 'activartipoasignacion'])->name('tipoasignacion.activartipoasignacion')->middleware('permission:tasignacion-delete');

	// Listado de Vehiculo tipo
		Route::get('/catalogo-vehiculo-tipo', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'catalogovehiculotipo'])->name('vehiculotipo.catalogovehiculotipo')->middleware('permission:tipovehiculo-list');
		Route::post('/tipovehiculo-datatable', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'tipovehiculodatatable'])->name('vehiculotipo.tipovehiculodatatable')->middleware('permission:tipovehiculo-list');
		Route::post('/guardar-tipovehiculo', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'guardartipovehiculo'])->name('vehiculotipo.guardarvehiculotipo')->middleware('permission:tipovehiculo-create');
		Route::post('/editar-tipovehiculo', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'editartipovehiculo'])->name('vehiculotipo.editartipovehiculo')->middleware('permission:tipovehiculo-edit');
		Route::post('/desactivar-tipovehiculo', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'eliminartipovehiculo'])->name('vehiculotipo.eliminartipovehiculo')->middleware('permission:tipovehiculo-delete');
		Route::get('/catalogo-tipovehiculo-inactivos', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'catalogotipovehiculoeliminadas'])->name('vehiculotipo.catalogotipovehiculoeliminadas')->middleware('permission:tipovehiculo-list');
		Route::post('/activar-tipovehiculo', [App\Http\Controllers\Unidad\VehiculoTipoController::class, 'activartipovehiculo'])->name('vehiculotipo.activartipovehiculo')->middleware('permission:tipovehiculo-delete');

	// Listado de Contratos para asignacion de unidades
		Route::get('/asignacion-unidades', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'asignacioncontratos'])->name('asignarunidad.asignacioncontratos');
		Route::post('/asignacion-datatable', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'asignaciondatatable'])->name('asignarunidad.asignaciondatatable');
		Route::get('/unidades-en-contrato/{licitacion}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'unidadescontrato'])->name('asignarunidad.unidadescontrato');
		Route::get('/unidades-patios/{licitacion}/{patio}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'asignarunidadespatio'])->name('asignarunidad.asignarunidadespatio');
		Route::post('/asignacion-unidades-contrato', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'asignacionunidadescontrato'])->name('asignarunidad.asignacionunidadescontrato');
		Route::get('/inventario-entrega/{licitacion}/{patio}/{unidad}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'inventarioentrega'])->name('asignarunidad.inventarioentrega');
		Route::post('/inventario-unidades-add', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'inventarioaddunidad'])->name('asignarunidad.inventarioaddunidad');


		Route::get('/nueva-asignacion', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'nuevaasignacion'])->name('asignarunidad.nuevaasignacion');
		Route::post('/guardar-asignacion-log', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'addasignacionlog'])->name('asignarunidad.addasignacionlog');
		Route::get('/editar-asignacion/{id}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'editarasignacion'])->name('asignarunidad.editarasignacion');
		Route::post('/editar-asignacion-log', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'editasignacionlog'])->name('asignarunidad.editasignacionlog');
		Route::post('/eliminar-asignacion-log', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'deleteasignacionlog'])->name('asignarunidad.deleteasignacionlog');
		Route::get('/ver-asignacion/{id}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'verasignacion'])->name('asignarunidad.verasignacion');

		Route::get('/asignacion-patios/{id}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'patiosasignacion'])->name('asignarunidad.patiosasignacion');
		Route::get('/unidades-patios-logistica/{id}/{patio}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'unidadespatiolog'])->name('asignarunidad.unidadespatiolog');
		Route::get('/unidades-requisicion-logistica/{id}/{req}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'unidadrequisicionlog'])->name('asignarunidad.unidadrequisicionlog');
		Route::post('/add-total-unidades', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'addtotalunidades'])->name('asignarunidad.addtotalunidades');
		Route::post('/add-total-unidades-req', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'addtotalunidadesreq'])->name('asignarunidad.addtotalunidadesreq');
		Route::post('/delete-unidades-asignacion', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'deleteunidasig'])->name('asignarunidad.deleteunidasig');

		Route::get('/unidades-sin-asignacion', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'unidsinasignacion'])->name('asignarunidad.unidsinasignacion');
		Route::get('/unidades-asignadas', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'unidadesasignadas'])->name('asignarunidad.unidadesasignadas');

		Route::get('/asignacion-busqueda/{id}', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'asignacionbusqueda'])->name('asignarunidad.asignacionbusqueda');
		Route::post('/busqueda-asig', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'busquedaasig'])->name('asignarunidad.busquedaasig');
		Route::post('/add-total-unidades-busqueda', [App\Http\Controllers\Unidad\AsignacionUnidadContratoController::class, 'addtotalunidadesbus'])->name('asignarunidad.addtotalunidadesbus');
	// Listado de Unidades Logistica
		// Route::get('/asignacion-unidades-contrato', [App\Http\Controllers\Logistica\AsignacionUnidadContratoController::class, 'asignacioncontratos'])->name('asignarunidad.asignacioncontratos');


	// Carga masiva equipamiento de unidades
		Route::post('/cargamasiva-equipamiento', [App\Http\Controllers\Unidad\EquipamientoUnidadController::class, 'cagamasivaequipamiento'])->name('equipamientocsv.cagamasivaequipamiento');
		Route::post('/carga-evidencia-equipamiento', [App\Http\Controllers\Unidad\EquipamientoUnidadController::class, 'cargaevidencia'])->name('equipamientocsv.cargaevidencia');
		Route::post('/eliminar-evidencia', [App\Http\Controllers\Unidad\EquipamientoUnidadController::class, 'eliminarevidencia'])->name('equipamientocsv.eliminarevidencia');


// T R A M I T E S  V E H I C U L A R E S
	//...   Información del propietario
		Route::get('/informacion-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'infopropietario'])->name('propietario.infopropietario');
		Route::post('/infopropietario-datatable', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'infopropietariodatatable'])->name('propietario.infopropietariodatatable');
		Route::get('/agregar-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'agregarpropietario'])->name('propietario.agregarpropietario');
		Route::post('/guardar-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'guardarpropietario'])->name('propietario.guardarpropietario');
		Route::get('/editar-propietario/{id_propietario}', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'vistaeditarpropietario'])->name('propietario.vistaeditarpropietario');
		Route::post('/modificar-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'modificarpropietario'])->name('propietario.modificarpropietario');
		Route::post('/desactivar-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'eliminarpropietario'])->name('propietario.eliminarpropietario');
		Route::get('/catalogo-propietarios-inactivos', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'catalogopropietariosinactivos'])->name('propietario.catalogopropietariosinactivos');
		Route::post('/activar-propietario', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'activarpropietario'])->name('propietario.activarpropietario');
		Route::get('/ver-propietario/{id}', [App\Http\Controllers\Unidad\InformacionPropietarioController::class, 'verpropietario'])->name('propietario.verpropietario');

	//...   Emplacamiento
		Route::get('/informacion-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'listadoemplacamiento'])->name('templacamiento.listadoemplacamiento');
		Route::post('/emplacamientoreq-datatable', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'emprequisitodatatable'])->name('templacamiento.emprequisitodatatable');
		Route::post('/guardar-requisito-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'guardarrequisito'])->name('templacamiento.guardarrequisito');
		Route::post('/editar-requisito-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'editarrequisitoemp'])->name('templacamiento.editarrequisitoemp');
		Route::post('/desactivar-requisito', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'eliminarrequisitoemp'])->name('templacamiento.eliminarrequisitoemp');
		Route::get('/catalogo-requisitos-emp-inactivos', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'catalogorequisitoempeliminadas'])->name('templacamiento.catalogorequisitoempeliminadas');
		Route::post('/activar-requisito-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'activarrequisitoemp'])->name('templacamiento.activarrequisitoemp');

		     //Emplacamiento evidencia
		Route::get('/informacion-emplacamientoev', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'listadoevidenciasemp'])->name('templacamiento.listadoevidenciasemp');
		Route::post('/emplacamientoev-datatable', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'empevidenciadatatable'])->name('templacamiento.empevidenciadatatable');
		Route::post('/guardar-evidencia-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'guardarevidencia'])->name('templacamiento.guardarevidencia');
		Route::post('/editar-evidencia-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'editarevidenciaemp'])->name('templacamiento.editarevidenciaemp');
		Route::post('/desactivar-evidencia', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'eliminarevidenciaemp'])->name('templacamiento.eliminarevidenciaemp');
		Route::get('/catalogo-evidencia-emp-inactivos', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'catalogoevidenciaempeliminadas'])->name('templacamiento.catalogoevidenciaempeliminadas');
		Route::post('/activar-evidencia-emplacamiento', [App\Http\Controllers\Unidad\TramiteemplacamientoController::class, 'activarevidenciaemp'])->name('templacamiento.activarevidenciaemp');

	//.... Tenencia y/o pago de derechos
		Route::get('/informacion-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'listadotenencia'])->name('ttenencia.listadotenencia');
		Route::post('/tenenciareq-datatable', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'tenenciareqdatatable'])->name('ttenencia.tenenciareqdatatable');
		Route::post('/guardar-requisito-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'guardarevidenciatn'])->name('ttenencia.guardarrequisito');
		Route::post('/editar-requisito-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'editartenenciareq'])->name('ttenencia.editartenenciareq');
		Route::post('/desactivar-requisitoten', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'eliminarrequisitoten'])->name('ttenencia.eliminarrequisitoten');
		Route::get('/catalogo-requisitos-ten-inactivos', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'catalogorequisitoteneliminadas'])->name('ttenencia.catalogorequisitoteneliminadas');
		Route::post('/activar-requisito-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'activarrequisitoten'])->name('ttenencia.activarrequisitoten');

		     //Tenencia evidencia
		Route::get('/informacion-tenenciaev', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'listadoevidenciasten'])->name('ttenencia.listadoevidenciasten');
		Route::post('/tenenciaev-datatable', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'tenevidenciadatatable'])->name('ttenencia.tenevidenciadatatable');
		Route::post('/guardar-evidencia-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'guardarevidenciaten'])->name('ttenencia.guardarevtenn');
		Route::post('/editar-evidencia-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'editarevten'])->name('ttenencia.editarevten');
		Route::post('/desactivar-evidencia-ten', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'eliminarevidenciaten'])->name('ttenencia.eliminarevidenciaten');
		Route::get('/catalogo-evidencia-ten-inactivos', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'catalogoevidenciateneliminadas'])->name('ttenencia.catalogoevidenciateneliminadas');
		Route::post('/activar-evidencia-tenencia', [App\Http\Controllers\Unidad\TramiteTenenciaController::class, 'activarevidenciaten'])->name('ttenencia.activarevidenciaten');


	//.... Verificacion
		Route::get('/informacion-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'listadoverificacion'])->name('tverificacion.listadoverificacion');
		Route::post('/verificacionreq-datatable', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'verireqdatatable'])->name('tverificacion.verireqdatatable');
		Route::post('/guardar-req-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'guardarreqver'])->name('tverificacion.guardarreqver');
		Route::post('/editar-requisito-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'editarverificacionreq'])->name('tverificacion.editarverificacionreq');
		Route::post('/desactivar-requisitover', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'eliminarrequisitover'])->name('tverificacion.eliminarrequisitover');
		Route::get('/catalogo-requisitos-ver-inactivos', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'catalogorequisitovereliminadas'])->name('tverificacion.catalogorequisitovereliminadas');
		Route::post('/activar-requisito-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'activarrequisitover'])->name('tverificacion.activarrequisitover');

			//Verificacion evidencia
		Route::get('/informacion-verificacionev', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'listadoevidenciastver'])->name('tverificacion.listadoevidenciastver');
		Route::post('/verificacionev-datatable', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'verevidenciadatatable'])->name('tverificacion.verevidenciadatatable');
		Route::post('/guardar-evidencia-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'guardarevidenciver'])->name('tverificacion.guardarevver');
		Route::post('/editar-evidencia-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'editarevver'])->name('tverificacion.editarevver');
		Route::post('/desactivar-evidencia-ver', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'eliminarevidenciatver'])->name('tverificacion.eliminarevidenciatver');
		Route::get('/catalogo-evidencia-ver-inactivos', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'catalogoevidenciavereliminadas'])->name('tverificacion.catalogoevidenciavereliminadas');
		Route::post('/activar-evidencia-verificacion', [App\Http\Controllers\Unidad\TramiteVerificacionController::class, 'activarevidenciaver'])->name('tverificacion.activarevidenciaver');

	//.... Reemplacamniento
		Route::get('/informacion-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'listadoreemplacamiento'])->name('treemplacamiento.listadoreemplacamiento');
		Route::post('/reemplacamientoreq-datatable', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'reemreqdatatable'])->name('treemplacamiento.reemreqdatatable');
		Route::post('/guardar-req-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'guardarreqreemp'])->name('treemplacamiento.guardarreqreemp');
		Route::post('/editar-requisito-reemplcamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'editarreempreq'])->name('treemplacamiento.editarreempreq');
		Route::post('/desactivar-requisitoreemp', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'eliminarrequisitoten'])->name('treemplacamiento.eliminarrequisitoten');
		Route::get('/catalogo-requisitos-reem-inactivos', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'catalogorequisitoreemeliminadas'])->name('treemplacamiento.catalogorequisitoreemeliminadas');
		Route::post('/activar-requisito-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'activarrequisitoreem'])->name('treemplacamiento.activarrequisitoreem');

			//Reemplacamiento evidencia
		Route::get('/informacion-reemplacamientoev', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'listadoevidenciasreemp'])->name('treemplacamiento.listadoevidenciasreemp');
		Route::post('/reemplacamientoev-datatable', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'reemevidenciadatatable'])->name('treemplacamiento.reemevidenciadatatable');
		Route::post('/guardar-evidencia-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'guardarevidencireeem'])->name('treemplacamiento.guardarevreeem');
		Route::post('/editar-evidencia-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'editarevreemp'])->name('treemplacamiento.editarevreemp');
		Route::post('/desactivar-evidencia-reem', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'eliminarevidenciatreem'])->name('treemplacamiento.eliminarevidenciatreem');
		Route::get('/catalogo-evidencia-reem-inactivos', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'catalogoevidenciareempeliminadas'])->name('treemplacamiento.catalogoevidenciareempeliminadas');
		Route::post('/activar-evidencia-reemplacamiento', [App\Http\Controllers\Unidad\TramiteReemplacamientoController::class, 'activarevidenciareemp'])->name('treemplacamiento.activarevidenciareemp');

	//.... Cambio de propietario
		Route::get('/informacion-cambio-propietario', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'listadocambiopro'])->name('tcambiopro.listadocambiopro');
		Route::post('/cambiopropietarioreq-datatable', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'cambioproreqdatatable'])->name('tcambiopro.cambioproreqdatatable');
		Route::post('/guardar-req-cambiopropietario', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'guardarreqcambioproo'])->name('tcambiopro.guardarreqcambioproo');
		Route::post('/editar-requisito-cambiopropietario', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'editarcambioproreq'])->name('tcambiopro.editarcambioproreq');
		Route::post('/desactivar-requisitocambio', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'eliminarrequisitocambio'])->name('tcambiopro.eliminarrequisitocambio');
		Route::get('/catalogo-requisitos-cambio-inactivos', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'catalogorequisitocambioeliminadas'])->name('tcambiopro.catalogorequisitocambioeliminadas');
		Route::post('/activar-requisito-cambiopropietario', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'activarrequisitocambio'])->name('tcambiopro.activarrequisitocambio');

			//Cambio de propietario evidencia
		Route::get('/informacion-cambiopropietarioev', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'listadoevidenciascambio'])->name('tcambiopro.listadoevidenciascambio');
		Route::post('/cambiopropev-datatable', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'cambioevidenciadatatable'])->name('tcambiopro.cambioevidenciadatatable');
		Route::post('/guardar-evidencia-cambiopro', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'guardarevidencvcambio'])->name('tcambiopro.guardarevcambio');
		Route::post('/editar-evidencia-cambiopro', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'editarevcambiopro'])->name('tcambiopro.editarevcambiopro');
		Route::post('/desactivar-evidencia-cambio', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'eliminarevidenciacambiop'])->name('tcambiopro.eliminarevidenciacambiop');
		Route::get('/catalogo-evidencia-cambio-inactivos', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'catalogoevidenciacambiopeliminadas'])->name('tcambiopro.catalogoevidenciacambiopeliminadas');
		Route::post('/activar-evidencia-cambiopro', [App\Http\Controllers\Unidad\TramiteCambioPropietarioController::class, 'activarevidenciacambiopro'])->name('tcambiopro.activarevidenciacambiopro');

	//.... Aseguramiento
		Route::get('/informacion-aseguramientoreq', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'listadoaseguramientot'])->name('tase.listadoaseguramientot');
		Route::post('/aseguramientoreq-datatable', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'aseguramientoreqdatatable'])->name('tase.aseguramientoreqdatatable');
		Route::post('/guardar-req-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'guardarreqaseguramiento'])->name('tase.guardarreqaseguramiento');
		Route::post('/editar-requisito-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'editaraseguramientoreq'])->name('tase.editaraseguramientoreq');
		Route::post('/desactivar-requisitoaseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'eliminarrequisitoaseguramiento'])->name('tase.eliminarrequisitoaseguramiento');
		Route::get('/catalogo-requaseg-inactivos', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'catalogorequisitoaseeliminadas'])->name('tase.catalogorequisitoaseeliminadas');
		Route::post('/activar-requisito-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'activarrequisitoaseguramiento'])->name('tase.activarrequisitoaseguramiento');

			//Aseguramiento evidencia
		Route::get('/informacion-aseguramientoev', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'listadoevidenciasaseguramiento'])->name('tase.listadoevidenciasaseguramiento');
		Route::post('/aseguramientoev-datatable', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'asegevidenciadatatable'])->name('tase.asegevidenciadatatable');
		Route::post('/guardar-evidencia-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'guardarevidencvaseg'])->name('tase.guardarevaseg');
		Route::post('/editar-evidencia-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'editarevaseguramiento'])->name('tase.editarevaseguramiento');
		Route::post('/desactivar-evidencia-aseguramiento', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'eliminarevidenciaaseg'])->name('tase.eliminarevidenciaaseg');
		Route::get('/catalogo-evidencia-aseg-inactivos', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'catalogoevidenciaasegeliminadas'])->name('tase.catalogoevidenciaasegeliminadas');
		Route::post('/activar-evidencia-aseg', [App\Http\Controllers\Unidad\TramiteAseguramientoController::class, 'activarevidenciaaseg'])->name('tase.activarevidenciaaseg');

	//.... Baja de vehículos (Venta)
		Route::get('/informacion-baja-venta', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'listadobajaventa'])->name('bajav.listadobajaventa');
		Route::post('/bajaventa-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'bajaventareqdatatable'])->name('bajav.bajaventareqdatatable');
		Route::post('/guardar-req-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'guardarreqbajaventa'])->name('bajav.guardarreqbajaventa');
		Route::post('/editar-requisito-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'editarbajaventareq'])->name('bajav.editarbajaventareq');
		Route::post('/desactivar-requisitobajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'eliminarrequisitobajaventa'])->name('bajav.eliminarrequisitobajaventa');
		Route::get('/catalogo-bajaventa-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'catalogorequisitobajaveliminadas'])->name('bajav.catalogorequisitobajaveliminadas');
		Route::post('/activar-requisito-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'activarrequisitobajav'])->name('bajav.activarrequisitobajav');

			//Baja de vehículos (Venta) evidencia
		Route::get('/informacion-bajaventaev', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'listadoevidenciabajaventa'])->name('bajav.listadoevidenciabajaventa');
		Route::post('/bajaventaev-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'bajavevidenciadatatable'])->name('bajav.bajavevidenciadatatable');
		Route::post('/guardar-evidencia-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'guardarevidenciabajav'])->name('bajav.guardareiabajav');
		Route::post('/editar-evidencia-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'editarevbajaventa'])->name('bajav.editarevbajaventa');
		Route::post('/desactivar-evidencia-bajaventa', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'eliminarevidenciabajaventa'])->name('bajav.eliminarevidenciabajaventa');
		Route::get('/catalogo-evidencia-bajav-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'catalogoevidenciabveliminadas'])->name('bajav.catalogoevidenciabveliminadas');
		Route::post('/activar-evidencia-bajav', [App\Http\Controllers\Unidad\TramiteBajaVehiculosController::class, 'activarevidenciabajaventa'])->name('bajav.activarevidenciabajaventa');

	//.... Baja de vehículos (Robo)
		Route::get('/informacion-baja-robo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'listadobajarobo'])->name('bajar.listadobajarobo');
		Route::post('/bajarobo-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'bajaroboreqdatatable'])->name('bajar.bajaroboreqdatatable');
		Route::post('/guardar-req-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'guardarreqbajarobo'])->name('bajar.guardarreqbajarobo');
		Route::post('/editar-requisito-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'editarbajaroboreq'])->name('bajar.editarbajaroboreq');
		Route::post('/desactivar-requisitobajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'eliminarrequisitobajarobo'])->name('bajar.eliminarrequisitobajarobo');
		Route::get('/catalogo-bajarobo-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'catalogrequisitobajareliminadas'])->name('bajar.catalogrequisitobajareliminadas');
		Route::post('/activar-requisito-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'activarrequisitobajarobo'])->name('bajar.activarrequisitobajarobo');

			//Baja de vehículos (Robo) evidencia
		Route::get('/informacion-bajaroboev', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'listadoevidenciabajarobo'])->name('bajar.listadoevidenciabajarobo');
		Route::post('/bajaroboev-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'bajaroevidenciadatatable'])->name('bajar.bajaroevidenciadatatable');
		Route::post('/guardar-evidencia-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'guardarevidenciabajarobo'])->name('bajar.guardareiabajarobo');
		Route::post('/editar-evidencia-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'editarevbajarobo'])->name('bajar.editarevbajarobo');
		Route::post('/desactivar-evidencia-bajarobo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'eliminarevidenciabajarobo'])->name('bajar.eliminarevidenciabajarobo');
		Route::get('/catalogo-evidencia-bajar-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'catalogoevidenciabreliminada'])->name('bajar.catalogoevidenciabreliminada');
		Route::post('/activar-evidencia-bajar', [App\Http\Controllers\Unidad\TramiteBajaVehiculosRoboController::class, 'activarevidenciabajarobo'])->name('bajar.activarevidenciabajarobo');

	//.... Baja de vehículos (Siniestro)
		Route::get('/informacion-baja-stro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'listadobajastro'])->name('bajas.listadobajastro');
		Route::post('/bajastro-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'bajastroreqdatatable'])->name('bajas.bajastroreqdatatable');
		Route::post('/guardar-req-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'guardarreqbajastro'])->name('bajas.guardarreqbajastro');
		Route::post('/editar-requisito-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'editarbajastroreq'])->name('bajas.editarbajastroreq');
		Route::post('/desactivar-requisitobajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'eliminarrequisitobajastro'])->name('bajas.eliminarrequisitobajastro');
		Route::get('/catalogo-bajastro-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'catalogrequisitobasineliminadas'])->name('bajas.catalogrequisitobasineliminadas');
		Route::post('/activar-requisito-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'activarrequisitobajastro'])->name('bajas.activarrequisitobajastro');

			//Baja de vehículos (Siniestro) evidencia
		Route::get('/informacion-bajastroev', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'listadoevidenciabajastro'])->name('bajas.listadoevidenciabajastro');
		Route::post('/bajastroev-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'bajasinevidenciadatatable'])->name('bajas.bajasinevidenciadatatable');
		Route::post('/guardar-evidencia-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'guardarevidenciabajasin'])->name('bajas.guardareiabajasin');
		Route::post('/editar-evidencia-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'editarevbajasin'])->name('bajas.editarevbajasin');
		Route::post('/desactivar-evidencia-bajastro', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'eliminarevidenciabajasin'])->name('bajas.eliminarevidenciabajasin');
		Route::get('/catalogo-evidencia-bajasi-inactivos', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'catalogoevidenciabsineliminada'])->name('bajas.catalogoevidenciabsineliminada');
		Route::post('/activar-evidencia-bajasin', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'activarevidenciabajasin'])->name('bajas.activarevidenciabajasin');

			//Baja de vehículos (Siniestro) Estatus
		Route::get('/informacion-bajastroest', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'listadoestatusbajastro'])->name('bajasin.listadoestatusbajastro');
		Route::post('/bajastroest-datatable', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'bajasinestatusdatatable'])->name('bajasin.bajasinestatusdatatable');
		Route::post('/guardar-sintroest', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'guardarsintroest'])->name('bajasin.gsintroest');
		Route::post('/editar-sintroest', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'editasintroest'])->name('bajasin.editasintroest');
		Route::post('/desactivar-sintroest', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'desactivasintroest'])->name('bajasin.desactivasintroest');
		Route::get('/informacion-sintroest-inactivo', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'listadoestatussinestinactivo'])->name('bajasin.listadoestatussinestinactivo');
		Route::post('/activar-sintroest', [App\Http\Controllers\Unidad\TramiteBajaVehiculosSiniestroController::class, 'activasintroest'])->name('bajasin.activasintroest');

	//.... GPS Requisito
		Route::get('/informacion-req-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'listadoreqgps'])->name('trgps.listadoreqgps');
		Route::post('/reqgps-datatable', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'listadoreqgpsdatatable'])->name('trgps.listadoreqgpsdatatable');
		Route::post('/guardar-req-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'guardarreqgps'])->name('trgps.guardarreqgps');
		Route::post('/editar-req-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'editarreqgps'])->name('trgps.editarreqgps');
		Route::post('/desactivar-requisitogps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'eliminarrequisitogps'])->name('trgps.eliminarrequisitogps');
		Route::get('/catalogo-gps-inactivos', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'catalogrequisitogpseliminadas'])->name('trgps.catalogrequisitogpseliminadas');
		Route::post('/activar-requisito-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'activarrequisitogps'])->name('trgps.activarrequisitogps');

		// GPS Evidencias
		Route::get('/informacion-ev-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'listadoevgps'])->name('trgps.listadoevgps');
		Route::post('/evgps-datatable', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'listadoevgpsdatatable'])->name('trgps.listadoevgpsdatatable');
		Route::post('/guardar-ev-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'guardarevgps'])->name('trgps.guardarevgps');
		Route::post('/editar-ev-gps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'editarevgps'])->name('trgps.editarevgps');
		Route::post('/desactivar-evidenciagps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'eliminaevidenciagps'])->name('trgps.eliminaevidenciagps');
		Route::get('/catalogo-gpsev-inactivos', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'catalogevidenciagpseliminadas'])->name('trgps.catalogevidenciagpseliminadas');
		Route::post('/activar-evidenciagps', [App\Http\Controllers\Unidad\TramiteGpsController::class, 'activarevidenciagps'])->name('trgps.activarevidenciagps');

	// 	  T R A M I T E S  V E H I C U L A R E S
			//Tenencia
		Route::get('/tramite-vehicular-tenencia/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevtenencia'])->name('traveh.tvtenencia');
		Route::get('/guardar-info-tenencia/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdtenencia'])->name('traveh.vistagrdtenencia');
		Route::post('/guardar-infoev-tenencia', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevtenencia'])->name('traveh.addinfoevtenencia');
		Route::get('/editar-info-tenencia/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaedittenencia'])->name('traveh.vistaedittenencia');
		Route::post('/eliminar-infoev-tenencia', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevtenencia'])->name('traveh.eliminardocumentoevtenencia');
		Route::post('/edit-infoev-tenencia', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevtenencia'])->name('traveh.editinfoevtenencia');
		Route::get('/ver-info-tenencia/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistavertenencia'])->name('traveh.vistavertenencia');
		Route::post('/eliminar-info-tenencia', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'deleteinfoevtenencia'])->name('traveh.deleteinfoevtenencia');
		Route::post('/carga-masiva-tenencia', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivatenencia'])->name('traveh.cargamasivatenencia');

			// Emplacamiento
		Route::get('/tramite-vehicular-emplacamiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevemplacamiento'])->name('traveh.tvemplacamiento');
		Route::get('/guardar-info-emplacamiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdemplacamiento'])->name('traveh.vistagrdemplacamiento');
		Route::post('/add-infoev-emplacamiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevemplacamiento'])->name('traveh.addinfoevemplacamiento');
		Route::get('/edit-info-emplacamiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditemplacamiento'])->name('traveh.vistaeditemplacamiento');
		Route::post('/eliminar-infoev-emplacamiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevemplaca'])->name('traveh.eliminardocumentoevemplaca');
		Route::post('/edit-infoev-emp', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevemplacamiento'])->name('traveh.editinfoevemplacamiento');
		Route::get('/ver-info-emplacamiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaveremplacamiento'])->name('traveh.vistaveremplacamiento');

			// Verificación
		Route::get('/tramite-vehicular-verificacion/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevverificacion'])->name('traveh.tvverificacion');
		Route::get('/guardar-info-verificacion/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdverificacion'])->name('traveh.vistagrdverificacion');
		Route::post('/add-infoev-verificacion', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevverificacion'])->name('traveh.addinfoevverificacion');
		Route::get('/editar-info-verificacion/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditverificacion'])->name('traveh.vistaeditverificacion');
		Route::post('/eliminar-infoev-verificacion', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevverificac'])->name('traveh.eliminardocumentoevverificac');
		Route::post('/edit-infoev-verificacion', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevverificacion'])->name('traveh.editinfoevverificacion');
		Route::get('/ver-info-verificacion/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaververificacion'])->name('traveh.vistaververificacion');
		Route::post('/eliminar-info-verificacion', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'deleteinfoevverificacion'])->name('traveh.deleteinfoevverificacion');
		Route::post('/carga-masiva-verificacion', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivaverificacion'])->name('traveh.cargamasivaverificacion');

			// Aseguramiento
		Route::get('/tramite-vehicular-aseguramiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevaseguramiento'])->name('traveh.tvaseguramiento');
		Route::get('/guardar-info-aseguramiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdaseguramiento'])->name('traveh.vistagrdaseguramiento');
		Route::post('/add-infoev-aseguramiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevaseguramiento'])->name('traveh.addinfoevaseguramiento');
		Route::get('/editar-info-aseguramiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditaseguramiento'])->name('traveh.vistaeditaseguramiento');
		Route::post('/eliminar-infoev-aseguramiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevaseg'])->name('traveh.eliminardocumentoevaseg');
		Route::post('/edit-infoev-aseguramiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevaseguramiento'])->name('traveh.editinfoevaseguramiento');
		Route::get('/ver-info-aseguramiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaveraseguramiento'])->name('traveh.vistaveraseguramiento');
		Route::post('/eliminar-info-aseguramiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'deleteinfoevaseguramiento'])->name('traveh.deleteinfoevaseguramiento');
		Route::post('/carga-masiva-aseguramiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivaaseguramiento'])->name('traveh.cargamasivaaseguramiento');

			//Reemplacamiento
		Route::get('/tramite-vehicular-reemplacamiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevreemplaca'])->name('traveh.tvreemplaca');
		Route::get('/guardar-info-reemplacamiento/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdreemplacamiento'])->name('traveh.vistagrdreemplacamiento');
		Route::post('/add-infoev-reemplacamiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevreemplacamiento'])->name('traveh.addinfoevreemplacamiento');
		Route::get('/edit-info-reemplacamiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditreemplacamiento'])->name('traveh.vistaeditreemplacamiento');
		Route::post('/eliminar-infoev-reemplacamiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevreemplaca'])->name('traveh.eliminardocumentoevreemplaca');
		Route::post('/edit-infoev-reemp', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevreemplacamiento'])->name('traveh.editinfoevreemplacamiento');
		Route::get('/ver-info-reemplacamiento/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaverreemplacamiento'])->name('traveh.vistaverreemplacamiento');
		Route::post('/carga-masiva-reemplacamiento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivareemplacamiento'])->name('traveh.cargamasivareemplacamiento');

			// Baja vehiculo (Siniestro)
		Route::get('/tramite-vehicular-bv-siniestro/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevbjsiniestro'])->name('traveh.tvbjsiniestro');
		Route::get('/guardar-info-bv-siniestro/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrbvsiniestro'])->name('traveh.vistagrbvsiniestro');
		Route::post('/add-infoev-bv-siniestro', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevbvsiniestro'])->name('traveh.addinfoevbvsiniestro');
		Route::get('/editar-info-bv-siniestro/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditbvsiniestro'])->name('traveh.vistaeditbvsiniestro');
		Route::post('/eliminar-infoev-bv-siniestro', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevbvsini'])->name('traveh.eliminardocumentoevbvsini');
		Route::post('/edit-infoev-bv-siniestro', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevbvsiniestro'])->name('traveh.editinfoevbvsiniestro');
		Route::get('/ver-info-bv-siniestro/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaverbvsiniestro'])->name('traveh.vistaverbvsiniestro');
		Route::post('/eliminar-info-bv-siniestro', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'deleteinfoevbvsiniestro'])->name('traveh.deleteinfoevbvsiniestro');
		Route::post('/carga-masiva-siniestro', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivasiniestros'])->name('traveh.cargamasivasiniestros');

			// Baja vehiculo (Venta)
		Route::get('/tramite-vehicular-bv-venta/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevbjventa'])->name('traveh.tvbjventa');
		Route::get('/guardar-info-bv-venta/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrbvventa'])->name('traveh.vistagrbvventa');
		Route::post('/add-infoev-bv-venta', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevbvventa'])->name('traveh.addinfoevbvventa');
		Route::get('/editar-info-bv-venta/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditbvventa'])->name('traveh.vistaeditbvventa');
		Route::post('/eliminar-infoev-bv-venta', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevbvventa'])->name('traveh.eliminardocumentoevbvventa');
		Route::post('/edit-infoev-bv-venta', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevbvventa'])->name('traveh.editinfoevbvventa');
		Route::get('/ver-info-bv-venta/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaverbvventa'])->name('traveh.vistaverbvventa');
		Route::post('/carga-masiva-venta', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivaventa'])->name('traveh.cargamasivaventa');

			// Baja vehiculo (Robo)
		Route::get('/tramite-vehicular-bv-robo/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevbjrobo'])->name('traveh.tvbjrobo');
		Route::get('/guardar-info-bv-robo/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrbvrobo'])->name('traveh.vistagrbvrobo');
		Route::post('/add-infoev-bv-robo', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevbvrobo'])->name('traveh.addinfoevbvrobo');
		Route::get('/editar-info-bv-robo/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditbvrobo'])->name('traveh.vistaeditbvrobo');
		Route::post('/eliminar-infoev-bv-robo', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevbvrobo'])->name('traveh.eliminardocumentoevbvrobo');
		Route::post('/edit-infoev-bv-robo', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevbvrobo'])->name('traveh.editinfoevbvrobo');
		Route::get('/ver-info-bv-robo/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaverbvrobo'])->name('traveh.vistaverbvrobo');
		Route::post('/carga-masiva-robo', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivarobo'])->name('traveh.cargamasivarobo');

			//Cambio de propietario 
		Route::get('/tramite-vehicular-cambio-propietario/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevcambiopro'])->name('traveh.tvcambiopro');
		Route::get('/guardar-info-cambiopropietario/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdcambiopro'])->name('traveh.vistagrdcambiopro');
		Route::post('/guardar-infoev-cambiopropietario', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevcambiopro'])->name('traveh.addinfoevcambiopro');
		Route::get('/editar-info-cambiopropietario/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistaeditcambiopro'])->name('traveh.vistaeditcambiopro');
		Route::post('/eliminar-infoev-cambiopropietario', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'eliminardocumentoevcambiop'])->name('traveh.eliminardocumentoevcambiop');
		Route::post('/edit-infoev-cambiopropietario', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editinfoevcambiopro'])->name('traveh.editinfoevcambiopro');
		Route::get('/ver-info-cambiopropietario/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistavercambiopro'])->name('traveh.vistavercambiopro');
		Route::post('/eliminar-info-cambiopropietario', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'deleteinfoevcambiopro'])->name('traveh.deleteinfoevcambiopro');
		Route::post('/carga-masiva-cambiopropietario', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivacambiopropietario'])->name('traveh.cargamasivacambiopropietario');

			// GPS (Reposicion)
		Route::get('/tramite-vehicular-gps/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'tramitevgps'])->name('traveh.tvgps');
		Route::get('/guardar-info-gps/{unidad}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistagrdgps'])->name('traveh.vistagrdgps');
		Route::post('/guardar-infoev-gps', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'addinfoevgps'])->name('traveh.addinfoevgps');
		Route::get('/ver-info-gps/{unidad}/{pago}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'vistavercambiogps'])->name('traveh.vistavercambiogps');
		Route::post('/carga-masiva-gps', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'cargamasivagps'])->name('traveh.cargamasivagps');

	    // C A T A L O G O  G E S T O R E S
		Route::get('/listado-catalogo-gestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'listadocatalogogestor'])->name('catalogogestor.listadocatalogogestor');
		Route::post('/guardar-catalogogestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'guardarcatalogogestor'])->name('catalogogestor.guardarcatalogogestor');
		Route::post('/catalogogestor-datatable', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'catalogogestordatatable'])->name('catalogogestor.catalogogestordatatable');
		Route::post('/editar-catalogogestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'editarcatalogogestor'])->name('catalogogestor.editarcatalogogestor');
		Route::post('/desactivar-catalogogestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'desactivarcatalogogestor'])->name('catalogogestor.desactivarcatalogogestor');
		Route::get('/catalogo-catalogogestor-inactivos', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'catalogogestorinactivas'])->name('catalogogestor.catalogogestorinactivas');
		Route::post('/activar-catalogogestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'activarcatalogogestor'])->name('catalogogestor.activarcatalogogestor');
		Route::get('/listado-documentos-gestor/{id}', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'gestorDocumentos'])->name('catalogogestor.listadoDocumentos');
		Route::post('/guardar-documentogestor', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'guardarDocumento'])->name('catalogogestor.guardardocumento');
		Route::post('/dt-gestor-documento', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'gestorDatatable'])->name('catalogogestor.listadoDocumentosdatatable');
		Route::post('/gestorres-documento-eliminar', [App\Http\Controllers\Unidad\TramiteVehicularUnidadController::class, 'gestoresEliminarDocumento'])->name('catalogogestor.eliminardocumento');


	// Listado de Movimientos
		Route::get('/listado-movimientos-logistica', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'listadomovimientos'])->name('movimientoslog.listadomovimientos');
		Route::get('/solicitud-movimiento', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'solicitudmovimiento'])->name('movimientoslog.solicitudmovimiento');
		Route::get('/asignar-unidades-movimiento', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'asignarunidades'])->name('movimientoslog.asignarunidades');
		Route::post('/unidades-translado', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'unidadestranslados'])->name('movimientoslog.unidadestranslados');
		Route::get('/editar-translado/{id}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'editarsolicitud'])->name('movimientoslog.editarsolicitud');
		Route::post('/editar-translado-info', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'edittrasladoinfo'])->name('movimientoslog.edittrasladoinfo');
		Route::get('/ver-translado/{id}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'versolicitud'])->name('movimientoslog.versolicitud');
		Route::get('/ver-unidad-info/{id}/{unidad}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'verinfounidadtraslado'])->name('movimientoslog.verinfounidadtraslado');
		Route::post('/eliminar-unidad', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'eliminarunidad'])->name('movimientoslog.eliminarunidad');
		Route::get('/unidades-translado-info/{id}/{unidad}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'unidadestransladoinfo'])->name('movimientoslog.unidadestranslado');
		Route::post('/editar-unidad-traslado', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'editunidtraslado'])->name('movimientoslog.editunidtraslado');
		Route::post('/enviar-solicitud', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'enviarsolicitud'])->name('movimientoslog.enviarsolicitud');
		Route::post('/actualizar-unidad-transito', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'updateuniddestino'])->name('movimientoslog.updateuniddestino');

	// Listado de Movimientos trasladistas
		Route::get('/listado-movimientos-transladistas', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'listadomovimientostransladistas'])->name('transladistassol.listadomovimientostransladistas');
		Route::get('/ver-solicitud-translado/{id}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'versolicitudtransladista'])->name('transladistassol.versolicitudtransladista');
		Route::get('/inventario-entrega-translado/{id}/{unidad}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'inventarioentrega'])->name('transladistassol.inventarioentrega');
		Route::post('/guardar-documento-unidad', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'guardardocumentounidad'])->name('movimientoslog.guardardocumentounidad');
		Route::post('/eliminar-documento-unidad', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'eliminardocumentotraslado'])->name('movimientoslog.eliminardocumentotraslado');
		Route::post('/enviar-solicitud-operador', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'enviarsolicitudoperador'])->name('movimientoslog.enviarsolicitudoperador');
		Route::post('/editar-inv-entrega', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'editinventrega'])->name('movimientoslog.editinventrega');


	// Listado de Movimientos operador
		Route::get('/listado-movimientos-operador', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'listadotransladooperador'])->name('transladooperador.listadotransladooperador');
		Route::get('/unidades-traslado-operador/{id}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'unidadestrasladooper'])->name('transladooperador.unidadestrasladooper');
		Route::get('/inventario-entrega-traslado/{id}/{unidad}', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'inventarioentregaoperador'])->name('transladooperador.inventarioentregaoperador');
		Route::post('/editar-inv-entrega-cliente', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'editinventregacliente'])->name('transladooperador.editinventregacliente');
		Route::post('/guardar-documento-unidad-cliente', [App\Http\Controllers\Unidad\MovimientosLogisticaController::class, 'guardardocumentounidadcliente'])->name('transladooperador.guardardocumentounidadcliente');

    // Catalogos de Tipos de Proveedor 
		Route::get('/listado-proveedor-categoria', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'listado'])->name('ProvCategoria.listado');
		Route::post('/proveedor-categoria-datatable', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'datatable'])->name('ProvCategoria.datatable');
		Route::post('/guardar-proveedor-categoria', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'guardar'])->name('ProvCategoria.guardar');
		Route::post('/editar-proveedor-categoria', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'editar'])->name('ProvCategoria.editar');
		Route::post('/desactivar-proveedor-categoria', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'desactivar'])->name('ProvCategoria.desactivar');
		Route::get('/catalogo-proveedor-categoria-inactivos', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'inactivas'])->name('ProvCategoria.inactivas');
		Route::post('/activar-proveedor-categoria', [App\Http\Controllers\Unidad\ProveedorCategoriaController::class, 'activar'])->name('ProvCategoria.activar');

	// Ficha tecnica vehiculo
		Route::get('/listado-unidades-siaf', [App\Http\Controllers\Unidad\FichaTecnicaUnidadesController::class, 'listadofichatecnica'])->name('fichatecnica.listadofichatecnica');
		Route::get('/ficha-tecnica-unidad/{id}', [App\Http\Controllers\Unidad\FichaTecnicaUnidadesController::class, 'fichatecnicaunidad'])->name('fichatecnica.fichatecnicaunidad');

		// Reporte de trámites
		Route::get('/reporte-tramites', [App\Http\Controllers\Unidad\TramiteReporteController::class, 'index'])->name('tramiteReporte.tramites');
		Route::post('/reporte-tramites-consulta', [App\Http\Controllers\Unidad\TramiteReporteController::class, 'consulta'])->name('tramiteReporte.consulta');
		Route::post('/reporte-tramites-excel', [App\Http\Controllers\Unidad\TramiteReporteController::class, 'excel'])->name('tramiteReporte.excel');

	//UNIDADES SUSTITUTAS
		Route::get('/unidades-sustitutas', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'listadounidadessustitutas'])->name('unidadessustitutas.listadounidadessustitutas');
		Route::post('/sustitutos-datatable', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'sustitutosdatatable'])->name('unidadessustitutas.sustitutosdatatable');
		Route::get('/crear-solicitud-unidades-sustitutas', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'crearsolicutud'])->name('unidadessustitutas.crearsolicutud');
		Route::post('/busqueda-unidad-base', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'busquedaunidadbase'])->name('unidadessustitutas.busquedaunidadbase');
		Route::get('/unidad-base/{id}', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'unidadbase'])->name('unidadessustitutas.unidadbase');
		Route::post('/guardadr-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'guardarsolicitud'])->name('unidadessustitutas.guardarsolicitud');
		Route::get('/ver-solicitud-sustitutos/{id}', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'versolicitudsustitutos'])->name('unidadessustitutas.versolicitudsustitutos');
		Route::get('/editar-solicitud-sustitutos/{id}', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'editarsolicitudsustitutos'])->name('unidadessustitutas.editarsolicitudsustitutos');
		Route::post('/update-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'updatesolicitud'])->name('unidadessustitutas.updatesolicitud');
		Route::post('/dalete-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'deletesolicitud'])->name('unidadessustitutas.deletesolicitud');
		Route::post('/enviar-logistica', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'enviarlogistica'])->name('unidadessustitutas.enviarlogistica');

	//UNIDADES SUSTITUTAS LOGISTICA
		Route::get('/unidades-sustitutas-logistica', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'listadosustitutologistica'])->name('unidadessustitutas.listadosustitutologistica');
		Route::post('/sustitutos-logistica-datatable', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'sustitutoslogisticadatatable'])->name('unidadessustitutas.sustitutoslogisticadatatable');
		Route::get('/asignar-unidad-sustituta/{id}', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'asignarsustituta'])->name('unidadessustitutas.asignarsustituta');
		Route::post('/agregar-unidad-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'addunidadsolicitud'])->name('unidadessustitutas.addunidadsolicitud');
		Route::post('/eliminar-unidad-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'deleteunidadsolicitud'])->name('unidadessustitutas.deleteunidadsolicitud');
		Route::post('/finalizar-solicitud', [App\Http\Controllers\Unidad\UnidadesSustitutasController::class, 'finalizarsolicitud'])->name('unidadessustitutas.finalizarsolicitud');


	//CONTROL SOLICITUDES
		Route::get('/control-solicitudes', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'controlsolicitudes'])->name('controlsol.controlsolicitudes');
		Route::get('/ver-solicitud-mantenimiento/{id}', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'versolmantenimiento'])->name('controlsol.versolmantenimiento');
		Route::get('/ver-solicitud-unidadessustitutas/{id}', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'versolsustitutos'])->name('controlsol.versolsustitutos');
		Route::get('/ver-solicitud-asignacion/{id}', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'versolasignacion'])->name('controlsol.versolasignacion');
		Route::get('/ver-solicitud-traslado/{id}', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'versoltraslado'])->name('controlsol.versoltraslado');
		Route::get('/ver-solicitud-gps/{id}', [App\Http\Controllers\Unidad\ControlSolicitudesController::class, 'versolgps'])->name('controlsol.versolgps');


