<?php
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	// R E Q U I S I C I O N E S
		Route::get('/listado-requisiciones', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'catalogoRequisicion'])->name('finanzas.catalogorequisicion');
		Route::post('/dt-requisiciones', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'requisicionDatatable'])->name('finanzas.requisiciondatatable');
		Route::get('/ver-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'verRequisicion'])->name('finanzas.verrequisicion');
		Route::post('/finanzas-requisicion-back', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'backfinanzasRequisicion'])->name('finanzas.backfinanzasrequisicion');
		Route::get('/orden-compra/{id}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'ordencompra'])->name('finanzas.ordencompra');
		Route::post('/generar-orden-compra', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'generarOrdencompra'])->name('finanzas.generarordencompra');
		Route::get('/orden-compra-pendiente/{id}/{orden}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'verordenpendiente'])->name('finanzas.verordenpendiente');
		Route::get('/orden-compra-pendiente-pdf/{id}/{orden}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'verordenpendientePDF'])->name('finanzas.verordenpendientePDF');
		Route::post('/eliminar-partida-orden', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'eliminarpartidaorden'])->name('finanzas.eliminarpartidaorden');
		Route::get('/ver-partida/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'verPartida'])->name('finanzas.verpartida');
		Route::get('/orden-compra-detalle/{id}/{orden}/{prov}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'verordendetalle'])->name('finanzas.verordendetalle');
		Route::get('/editar-unidad-detalle/{id}/{orden}/{prov}/{unidad}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'editarunidadfinanzas'])->name('finanzas.editarunidadfinanzas');
		Route::get('/finanzas-equipamiento-unidad-detalle/{id}/{orden}/{prov}/{unidad}', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'equipamientounidadfinanzas'])->name('finanzas.efinanzasunidadfinanzas');
		Route::post('/editar-unidad-finanzas', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'editarunidadfin'])->name('finanzas.editarunidadfin');
		Route::post('/carga-masiva', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'cargamasivaexcel'])->name('finanzas.cargamasivaexcel');
		Route::post('/agregar/evidencias-orden', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'agregarevidenciaorden'])->name('finanzas.agregarevidenciaorden');
		Route::post('/eliminar-evidencia/orden-compra', [App\Http\Controllers\Licitacion\RequisicionFinanzasController::class, 'eliminarevidenciaorden'])->name('finanzas.eliminarevidenciaorden');

	// O R D E N  D E  C O M P R A
		Route::get('/listado-ordencompra', [App\Http\Controllers\Licitacion\OrdenCompraController::class, 'catalogoOrdencompra'])->name('ordencompra.catalogoordencompra');
		Route::post('/dt-ordencompra', [App\Http\Controllers\Licitacion\OrdenCompraController::class, 'ordencompraDatatable'])->name('ordencompra.ordencompradatatable');
		Route::get('/ver-orden-compra/{id}/{orden}', [App\Http\Controllers\Licitacion\OrdenCompraController::class, 'verordenpago'])->name('ordencompra.verordenpago');
		Route::get('/orden-compra-pdf/{id}/{orden}/{id_orden_prov}', [App\Http\Controllers\Licitacion\OrdenCompraController::class, 'verOrdenPagoPDF'])->name('ordencompra.verOrdenPagoPDF');

	// C A T A L O G O  R E Q U I S I C I O N E S  G R U P O
		Route::get('/listado-grupo', [App\Http\Controllers\Licitacion\GrupoController::class, 'listadogrupo'])->name('grupo.listadocatalogogrupo');
		Route::post('/grupo-datatable', [App\Http\Controllers\Licitacion\GrupoController::class, 'grupodatatable'])->name('grupo.catalogogrupodatatable');
		Route::post('/guardar-grupo', [App\Http\Controllers\Licitacion\GrupoController::class, 'guardargrupo'])->name('grupo.guardargrupo');
		Route::post('/editar-grupo', [App\Http\Controllers\Licitacion\GrupoController::class, 'editargrupo'])->name('grupo.editargrupo');
		Route::post('/desactivar-grupo', [App\Http\Controllers\Licitacion\GrupoController::class, 'desactivargrupo'])->name('grupo.desactivargrupo');
		Route::get('/listado-grupo-inactivas', [App\Http\Controllers\Licitacion\GrupoController::class, 'listadogrupoinactivas'])->name('grupo.listadocatalogogrupoinactivas');
		Route::post('/activar-grupo', [App\Http\Controllers\Licitacion\GrupoController::class, 'activargrupo'])->name('grupo.activargrupo');

	// C A T A L O G O  R E Q U I S I C I O N E S  S U B G R U P O
		Route::get('/listado-subgrupo/{id}', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'listadosubgrupo'])->name('subgrupo.listadocatalogosubgrupo');
		Route::post('/subgrupo-datatable', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'subgrupodatatable'])->name('subgrupo.catalogosubgrupodatatable');
		Route::post('/guardar-subgrupo', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'guardarsubgrupo'])->name('subgrupo.guardarsubgrupo');
		Route::post('/editar-subgrupo', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'editarsubgrupo'])->name('subgrupo.editarsubgrupo');
		Route::post('/desactivar-subgrupo', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'desactivarsubgrupo'])->name('subgrupo.desactivarsubgrupo');
		Route::get('/listado-subgrupo-inactivos/{id}', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'listadosubgrupoinactivas'])->name('subgrupo.listadocatalogosubgrupoinactivas');
		Route::post('/activar-subgrupo', [App\Http\Controllers\Licitacion\SubgrupoController::class, 'activarsubgrupo'])->name('subgrupo.activarsubgrupo');

	// C A T A L O G O  T I P O  D E  T R A N S P O R T E
		Route::get('/listado-tipotransporte', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'listadotipotransporte'])->name('tipotransporte.listadocatalogotipotransporte');
		Route::post('/tipotransporte-datatable', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'tipotransportedatatable'])->name('tipotransporte.catalogotipotransportedatatable');
		Route::post('/guardar-tipotransporte', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'guardartipotransporte'])->name('tipotransporte.guardartipotransporte');
		Route::post('/editar-tipotransporte', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'editartipotransporte'])->name('tipotransporte.editartipotransporte');
		Route::post('/desactivar-tipotransporte', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'desactivartipotransporte'])->name('tipotransporte.desactivartipotransporte');
		Route::get('/listado-tipotransporte-inactivas', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'listadotipotransporteinactivas'])->name('tipotransporte.listadocatalogotipotransporteinactivas');
		Route::post('/activar-tipotransporte', [App\Http\Controllers\Licitacion\TipoTransporteController::class, 'activartipotransporte'])->name('tipotransporte.activartipotransporte');

	// C A T A L O G O  C O B E R T U R A
		Route::get('/listado-cobertura/{id}', [App\Http\Controllers\Licitacion\CoberturaController::class, 'listadocobertura'])->name('cobertura.listadocatalogocobertura');
		Route::post('/cobertura-datatable', [App\Http\Controllers\Licitacion\CoberturaController::class, 'coberturadatatable'])->name('cobertura.catalogocoberturadatatable');
		Route::post('/guardar-cobertura', [App\Http\Controllers\Licitacion\CoberturaController::class, 'guardarcobertura'])->name('cobertura.guardarcobertura');
		Route::post('/editar-cobertura', [App\Http\Controllers\Licitacion\CoberturaController::class, 'editarcobertura'])->name('cobertura.editarcobertura');
		Route::post('/desactivar-cobertura', [App\Http\Controllers\Licitacion\CoberturaController::class, 'desactivarcobertura'])->name('cobertura.desactivarcobertura');
		Route::get('/listado-cobertura-inactivas/{id}', [App\Http\Controllers\Licitacion\CoberturaController::class, 'listadocoberturainactivas'])->name('cobertura.listadocatalogocoberturainactivas');
		Route::post('/activar-cobertura', [App\Http\Controllers\Licitacion\CoberturaController::class, 'activarcobertura'])->name('cobertura.activarcobertura');

	//C A T A L O G O  E N T I D A D  F E D E R A T I V A
		Route::get('/listado-entidadfederativa', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'listadoentidadfederativa'])->name('entidadfederativa.listadocatalogoentidadfederativa');
		Route::post('/entidadfederativa-datatable', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'entidadfederativadatatable'])->name('entidadfederativa.catalogoentidadfederativadatatable');
		Route::post('/guardar-entidadfederativa', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'guardarentidadfederativa'])->name('entidadfederativa.guardarentidadfederativa');
		Route::post('/editar-entidadfederativa', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'editarentidadfederativa'])->name('entidadfederativa.editarentidadfederativa');
		Route::post('/desactivar-entidadfederativa', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'desactivarentidadfederativa'])->name('entidadfederativa.desactivarentidadfederativa');
		Route::get('/listado-entidadfederativa-inactivas', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'listadoentidadfederativainactivas'])->name('entidadfederativa.listadocatalogoentidadfederativainactivas');
		Route::post('/activar-entidadfederativa', [App\Http\Controllers\Licitacion\EntidadFederativaController::class, 'activarentidadfederativa'])->name('entidadfederativa.activarentidadfederativa');

	//C A T A L O G O  T I P O  P L A C A S
		Route::get('/listado-tipoplacas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'listadotipoplacas'])->name('tipoplacas.listadocatalogotipoplacas');
		Route::post('/tipoplacas-datatable', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'tipoplacasdatatable'])->name('tipoplacas.catalogotipoplacasdatatable');
		Route::post('/guardar-tipoplacas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'guardartipoplacas'])->name('tipoplacas.guardartipoplacas');
		Route::post('/editar-tipoplacas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'editartipoplacas'])->name('tipoplacas.editartipoplacas');
		Route::post('/desactivar-tipoplacas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'desactivartipoplacas'])->name('tipoplacas.desactivartipoplacas');
		Route::get('/listado-tipoplacas-inactivas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'listadotipoplacasinactivas'])->name('tipoplacas.listadocatalogotipoplacasinactivas');
		Route::post('/activar-tipoplacas', [App\Http\Controllers\Licitacion\TipoPlacasController::class, 'activartipoplacas'])->name('tipoplacas.activartipoplacas');

	//C A T A L O G O  C O M B U S T I B L E
		Route::get('/listado-combustible', [App\Http\Controllers\Licitacion\CombustibleController::class, 'listadocombustible'])->name('combustible.listadocatalogocombustible');
		Route::post('/combustible-datatable', [App\Http\Controllers\Licitacion\CombustibleController::class, 'combustibledatatable'])->name('combustible.catalogocombustibledatatable');
		Route::post('/guardar-combustible', [App\Http\Controllers\Licitacion\CombustibleController::class, 'guardarcombustible'])->name('combustible.guardarcombustible');
		Route::post('/editar-combustible', [App\Http\Controllers\Licitacion\CombustibleController::class, 'editarcombustible'])->name('combustible.editarcombustible');
		Route::post('/desactivar-combustible', [App\Http\Controllers\Licitacion\CombustibleController::class, 'desactivarcombustible'])->name('combustible.desactivarcombustible');
		Route::get('/listado-combustible-inactivas', [App\Http\Controllers\Licitacion\CombustibleController::class, 'listadocombustibleinactivas'])->name('combustible.listadocatalogocombustibleinactivas');
		Route::post('/activar-combustible', [App\Http\Controllers\Licitacion\CombustibleController::class, 'activarcombustible'])->name('combustible.activarcombustible');

	//C A T A L O G O    D O C U M E N T A C I O N    C O M P R A S
		Route::get('/listado-documentoscompras', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'listadodocumentoscompras'])->name('doccompras.listadodocumentoscompras');
		Route::post('/documentos-datatable', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'documentosdatatable'])->name('doccompras.documentosdatatable');
		Route::post('/guardar-documento', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'guardardocumento'])->name('doccompras.guardardocumento');
		Route::post('/editar-documento', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'editardocumento'])->name('doccompras.editardocumento');
		Route::post('/desactivar-documento', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'desactivardocumento'])->name('doccompras.desactivardocumento');
		Route::get('/catalogo-documentos-inactivos', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'catalogodocumentosinactivos'])->name('doccompras.documentosinactivos');
		Route::post('/activar-documento', [App\Http\Controllers\Licitacion\RequisicionDocumentoComprasController::class, 'activardocumento'])->name('doccompras.activardocumento');


	// E S T I M A C I O N E S
		Route::get('/listado-estimaciones-finanzas', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'catalogoestimaciones'])->name('estimacionesfin.catalogoestimaciones');
		Route::get('/ver-estimacion-finanzas/{proyecto}/{estimacion}', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'verestimacionfin'])->name('estimacionesfin.verestimacionfin');
		Route::get('/evidencia-pago-estimaciones/{proyecto}/{estimacion}', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'evidenciapagoest'])->name('estimacionesfin.evidenciapagoest');
		Route::post('/add-evidenciapago', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'addevidenciapagoesti'])->name('estimacionesfin.addevidenciapagoesti');
		Route::post('/eliminar-documento-estimacion', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'eliminardocumentoestimacion'])->name('estimacionesfin.eliminardocumentoestimacion');
		Route::post('/add-notacredito', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'addnotacreditoestimacion'])->name('estimacionesfin.addnotacreditoestimacion');
		Route::post('/eliminar-documento-notacredito', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'eliminardocumentonotacredito'])->name('estimacionesfin.eliminardocumentonotacredito');
		Route::get('/ver-estimacion-pdf/{id}', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'verestimacionPDF'])->name('estimacionesfin.verPDF');
		Route::post('/finalizar-estimacion', [App\Http\Controllers\Proyecto\EstimacionesFinanzasController::class, 'finalizarestimacion'])->name('estimacionesfin.finalizarestimacion');


	// M A N T E N I M I E N T O
		Route::get('/listado-mantenimientos-finanzas', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'listadomantenimientfinanzas'])->name('mantenimientosfin.listadomantenimientfinanzas');
		Route::post('/dtvalidacion-taller-finanzas', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'dtmantenimientofinanzas'])->name('mantenimientosfin.dtmantenimientofinanzas');
		Route::get('/ver-solicitud-mantenimiento-finanzas/{id}', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'versolicitudfinanzas'])->name('mantenimientosfin.versolicitudfinanzas');
		Route::get('/evidencias-mantenimiento/{id}', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'evidenciasmant'])->name('mantenimientosfin.evidenciasmant');
		Route::post('/pago-mantenimiento', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'pagomantenimiento'])->name('mantenimientosfin.pagomantenimiento');
		Route::post('/eliminar-pago-mantenimiento', [App\Http\Controllers\Taller\MantenimientosFinanzasController::class, 'deletepagomantenimiento'])->name('mantenimientosfin.deletepagomantenimiento');

	// R E Q U I S I C I O N   C O M P R A S
		Route::get('/listado-requisiciones-compras-finanzas', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'listadorequisiciones'])->name('finreqcompras.finreqcompras');
		Route::get('/pagar-requisicion-compras/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'solicitudcompras'])->name('finreqcompras.pagocomprareq');
		Route::get('/informacion-pago-requisicion-compras/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'infopago'])->name('finreqcompras.infopago');
		Route::post('/add-pago-requisicion', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'addpago'])->name('finreqcompras.addpago');
		Route::post('/eliminar-documento-pago', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'eliminardocumentorequisicion'])->name('finreqcompras.eliminardocumentorequisicion');
		Route::get('/ver-requisicion-pdf/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasFinanzasController::class, 'verlicitacionPDF'])->name('reqcompras.verPDF');
		
		//COMPRAS CONVERSIONES
		Route::get('/conversiones/{id}', [App\Http\Controllers\Licitacion\ConversionesController::class, 'listado'])->name('conversiones.listado');
		Route::post('/conversiones-guardardocumento', [App\Http\Controllers\Licitacion\ConversionesController::class, 'guardarDocumento'])->name('conversiones.guardarDocumento');
		Route::post('/conversiones-eliminar-documento', [App\Http\Controllers\Licitacion\ConversionesController::class, 'eliminarDocumento'])->name('conversiones.eliminarDocumento');