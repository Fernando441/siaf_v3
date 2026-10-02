<?php
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	// T I P O   D E   D O C U M E N T O
		Route::get('/listado-proyectos', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'listadodocumentos'])->name('documentos.listadodocumentos');
		Route::post('/documento-datatable', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'documentodatatable'])->name('documentos.documentodatatable');
		Route::post('/guardar-documento', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'guardardocumento'])->name('documentos.guardardocumento');
		Route::post('/editar-documento', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'editardocumento'])->name('documentos.editardocumento');
		Route::post('/desactivar-documento', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'eliminardocumento'])->name('documentos.eliminardocumento');
		Route::get('/catalogo-documentos-inactivos', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'catalogodocumentosinactivos'])->name('documentos.docmuentosinactivos');
		Route::post('/activar-documento', [App\Http\Controllers\Licitacion\TipoDocumentoController::class, 'activardocumento'])->name('documentos.activardocumento');

	// P U B L I C A C I O N   D E   L I C I T A C I O N
		Route::get('/listado-publicacion', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'listadopublicacion'])->name('publicacion.listadopublicacion');
		Route::post('/publicacion-datatable', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'publicaciondatatable'])->name('publicacion.publicaciondatatable');
		Route::post('/guardar-publicacion', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'guardarpublicacion'])->name('publicacion.guardarpublicacion');
		Route::post('/editar-publicacion', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'editarpublicacion'])->name('publicacion.editarpublicacion');
		Route::post('/desactivar-publicacion', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'desactivarpublicacion'])->name('publicacion.desactivarpublicacion');
		Route::get('/catalogo-publicaciones-inactivos', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'catalogopublicacionesinactivas'])->name('publicacion.publicacionesinactivas');
		Route::post('/activar-publicacion', [App\Http\Controllers\Licitacion\TipoPublicacionController::class, 'activarpublicacion'])->name('publicacion.activarpublicacion');

	// T I P O S   D E  C O N T R A T A C I O N
		Route::get('/listado-tiposcontratacion', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'listadotipocontratacion'])->name('contratacion.listadotipocontratacion');
		Route::post('/contratacion-datatable', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'contrataciondatatable'])->name('contratacion.contrataciondatatable');
		Route::post('/guardar-contratacion', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'guardarcontratacion'])->name('contratacion.guardarcontratacion');
		Route::post('/editar-contratacion', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'editarcontratacion'])->name('contratacion.editarcontratacion');
		Route::post('/desactivar-contratacion', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'desactivarcontratacion'])->name('contratacion.desactivarcontratacion');
		Route::get('/catalogo-contrataciones-inactivos', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'catalogocontratacionesinactivas'])->name('contratacion.contratacionesinactivas');
		Route::post('/activar-contratacion', [App\Http\Controllers\Licitacion\TipoContratacionController::class, 'activarcontratacion'])->name('contratacion.activarcontratacion');

	// L I C I T A C I O N E S
		Route::get('/listado-licitaciones', [App\Http\Controllers\Licitacion\LicitacionController::class, 'listadolicitaciones'])->name('licitacion.listadolicitaciones');
		Route::post('/licitacion-datatable', [App\Http\Controllers\Licitacion\LicitacionController::class, 'licitaciondatatable'])->name('licitacion.licitaciondatatable');
		Route::get('/agregar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'agregarlicitacion'])->name('licitacion.agregarlicitacion');
		Route::post('/guardar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'guardarlicitacion'])->name('licitacion.guardarlicitacion');
		Route::get('/editar-licitacion/{licitacion}', [App\Http\Controllers\Licitacion\LicitacionController::class, 'editarlicitacion'])->name('licitacion.editarlicitacion');
		Route::post('/editar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'modificarlicitacion'])->name('licitacion.modificarlicitacion');
		Route::post('/guardar-documentacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'guardardocumentacion'])->name('licitacion.guardardocumentacion');
		Route::post('/eliminar-documentacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'eliminardocumentacion'])->name('licitacion.eliminardocumentacion');
		Route::post('/eliminar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'eliminarLicitacion'])->name('licitacion.eliminar');
		Route::get('/ver-licitacion/{id}', [App\Http\Controllers\Licitacion\LicitacionController::class, 'verLicitacion'])->name('licitacion.ver');
		Route::get('/ver-licitacion-pdf/{id}', [App\Http\Controllers\Licitacion\LicitacionController::class, 'verlicitacionPDF'])->name('licitacion.verPDF');

		Route::get('/catalogo-licitaciones-inactivas', [App\Http\Controllers\Licitacion\LicitacionController::class, 'catalogolicitacionesinactivas'])->name('licitacion.catalogolicitacionesinactivas');
		Route::post('/desactivar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'eliminarlicitacion'])->name('licitacion.eliminarlicitacion');
		Route::post('/activar-licitacion', [App\Http\Controllers\Licitacion\LicitacionController::class, 'activarlicitacion'])->name('licitacion.activarlicitacion');

		Route::get('/agregar-proyecto/{contrato}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'agregarproyecto'])->name('licitacion.agregar');
		Route::get('/agregar-proyecto-nuevo/{contrato}/op/{op}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'agregarproyectonuevo'])->name('licitacion.agregarnuevo');

		Route::get('/agregar-informacion-finanzas/{idlicitacion}', [App\Http\Controllers\Licitacion\LicitacionController::class, 'informacionfinanzas'])->name('licitacion.informacionfinanzas');
		Route::post('/editar-informacion-financiera', [App\Http\Controllers\Licitacion\LicitacionController::class, 'modificarinfofinanciera'])->name('licitacion.modificarinfofinanciera');
		Route::post('/eliminar-infofinanciera', [App\Http\Controllers\Licitacion\LicitacionController::class, 'eliminarinfofinanciera'])->name('licitacion.eliminarinfofinanciera');
		Route::post('/eliminar-infosegurosrc', [App\Http\Controllers\Licitacion\LicitacionController::class, 'eliminarinfosegurorc'])->name('licitacion.eliminarinfosegurorc');

	// P R E S U P U E S T O S
		Route::get('/crear-presupuesto/{licitacion}', [App\Http\Controllers\Licitacion\PresupuestoController::class, 'crearpresupuesto'])->name('presupuesto.crearpresupuesto');
		Route::post('/guardar-unidades', [App\Http\Controllers\Licitacion\PresupuestoController::class, 'guardarunidades'])->name('presupuesto.guardarunidades');
		Route::get('/presupuesto/{presupuesto}', [App\Http\Controllers\Licitacion\PresupuestoController::class, 'presupuesto'])->name('presupuesto.presupuesto');
		Route::get('/listado-presupuesto', [App\Http\Controllers\Licitacion\PresupuestoController::class, 'listadopresupuestos'])->name('presupuesto.listadopresupuestos');

	// P R o P O S I C I O N   E C O N O M I C A
		Route::get('/catalogo-propuesta-economica', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'listadoproposicioneconomica'])->name('proposicioneconomica.catalogoproposicioneconomica');
		Route::post('/proposicioneconomica-datatable', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'proposicioneconomicadatatable'])->name('proposicioneconomica.proposicioneconomicadatatable');
		Route::get('/crear-propuesta-economica/{licitacion}/op/{op}/contrato/{contrato}', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'crearpoposicioneconomica'])->name('proposicioneconomica.crearproposicioneconomica');
		Route::post('/guardar-propuesta', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'guardarproposicioneconomica'])->name('proposicioneconomica.guardarproposicioneconomica');
		Route::get('/editar-propuesta-economica/{proposicion}/op/{op}/contrato/{contrato}', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'editarpoposicioneconomica'])->name('proposicioneconomica.editarproposicioneconomica');
		Route::get('/editar-propuesta-economica-cont/{proposicion}/op/{op}/contrato/{contrato}', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'editarpoposicioneconomicacon'])->name('proposicioneconomica.editarproposicioneconomicacon');
		Route::post('/modificar-propuesta', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'modificarproposicioneconomica'])->name('proposicioneconomica.modificarproposicioneconomica');
		Route::post('/eliminar-propuesta', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'eliminarpropuesta'])->name('proposicioneconomica.eliminarpropuesta');
		Route::get('/ver-propuesta-economica/{proposicion}', [App\Http\Controllers\Licitacion\ProposicionEconomicaController::class, 'verpoposicioneconomica'])->name('proposicioneconomica.verproposicioneconomica');

	// P R O P U E S T A   T E C N I C A
		Route::get('/crear-propuesta-tecnica/{licitacion}', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'crearPropuestaTecnica'])->name('propuestatecnica.crearpropuestatecnica');
		Route::post('/guardar-propuesta-tecnica', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'guardarPropuestaTecnica'])->name('propuestatecnica.guardarpropuestatecnica');
		Route::post('/eliminar-propuesta-tecnica', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'eliminarPropuestaTecnica'])->name('propuestatecnica.eliminarpropuestatecnica');
		Route::get('/propuesta-tecnica-documentación/{licitacion}', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'PropuestaTecnicadoc'])->name('propuestatecnica.propuestatecnicadoc');
		Route::post('/cargamasiva', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'cargamasivaexcel'])->name('propuestatecnica.cargamasiva');
		Route::post('/eliminar-documento', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'eliminardocumento'])->name('propuestatecnica.eliminardocumento');
		Route::post('/carga-documentos-propuesta', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'cargadocumentosreal'])->name('propuestatecnica.cargadocumentoreal');
		Route::post('/eliminar-documento-real', [App\Http\Controllers\Licitacion\PropuestaTecnicaController::class, 'eliminardocumentoreal'])->name('propuestatecnica.eliminardocumentoreal');

	// L I C I T A C I O N E S  ( R E Q U I S I C I O N )
		Route::get('/listado-requisiciones-concurso/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'listadoreqconsursos'])->name('reqconcurso.listadoreqconsursos');
		Route::post('/dt-requisiciones-concruso', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'reqenconcursoDataTable'])->name('reqconcurso.reqenconcursoDataTable');
		Route::get('/nueva-requisicion-menu-concurso/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'nvareqmenuconcurso'])->name('reqconcurso.nvareqmenuconcurso');
		Route::post('/menu-guardar-datos-req', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'grdrequisicionmenu'])->name('reqconcurso.grdrequisicionmenu');
		Route::get('/ver-requisicion/{id}/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'verRequisicionmenu'])->name('reqconcurso.verrequisicionmenu');
		Route::get('/info-rerquisicion-partida/{partida}/{requisicion}/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'verPartidalic'])->name('reqconcurso.verpartidalic');
		Route::get('/agregar-información-requisicion/{id}/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'addinfopartidaslic'])->name('reqconcurso.addinfopartidaslic');
		Route::get('/add-info-partida/{partida}/{requisicion}/{licitacion}', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'infopartidalic'])->name('reqconcurso.infopartidalic');
		Route::post('/add-info-partida-post', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'guardarinfopartidalic'])->name('reqconcurso.guardarinfopartidalic');
		Route::post('/delete-equipamiento-lic', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'desactivarEquipamientolic'])->name('reqconcurso.desactivarequipamientolic');
		Route::post('/delete-aseguramiento-lic', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'desactivarAseguramientolic'])->name('reqconcurso.desactivaraseguramientolic');
		Route::post('/delete-emplacamiento-lic', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'desactivarEmplacamientolic'])->name('reqconcurso.desactivaremplacamientolic');
		Route::post('/delete-lugar-entrega-lic', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'desactivarLugarEntregalic'])->name('reqconcurso.desactivarlugarentregalic');
		Route::post('/finanzas-requisicion-lic', [App\Http\Controllers\Licitacion\RequisicionEnConcurso::class, 'finanzasRequisicionlic'])->name('reqconcurso.finanzasrequisicionlic');

	// G E S T O R  D E  D O C U M E N T O S
		Route::get('/gestor-documento', [App\Http\Controllers\Licitacion\GestorDocumentoController::class, 'catalogoDocumento'])->name('gestordocumentos.catalogodocumento');
		Route::post('/guardar-gestor-documento', [App\Http\Controllers\Licitacion\GestorDocumentoController::class, 'guardarDocumento'])->name('gestordocumentos.guardardocumento');
		Route::post('/dt-gestor-documento', [App\Http\Controllers\Licitacion\GestorDocumentoController::class, 'gestorDatatable'])->name('gestordocumentos.gestordocumentodatatable');
		Route::post('/gestor-documento-eliminar', [App\Http\Controllers\Licitacion\GestorDocumentoController::class, 'gestorEliminarDocumento'])->name('gestordocumentos.eliminardocumento');
		Route::get('/explorador-archivos', [App\Http\Controllers\Licitacion\GestorDocumentoController::class, 'exploradorArchivos'])->name('gestordocumentos.exploradorarchivos');

	// R E Q U I S I C I O N E S
		Route::get('/nueva-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'nuevaRequisicion'])->name('requisiciones.nuevarequisicion');
		Route::get('/listado-requisiciones', [App\Http\Controllers\Licitacion\RequisicionController::class, 'catalogoRequisicion'])->name('requisiciones.catalogorequisicion');
		Route::post('/dt-requisiciones', [App\Http\Controllers\Licitacion\RequisicionController::class, 'requisicionDatatable'])->name('requisiciones.requisiciondatatable');
		Route::post('/guardar-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'guardarRequisicion'])->name('requisiciones.guardarrequisicion');
		Route::get('/editar-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionController::class, 'editarRequisicion'])->name('requisiciones.editarrequisicion');
		Route::post('/modificar-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'modificarRequisicion'])->name('requisiciones.modificarrequisicion');
		Route::post('/eliminar-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'eliminarRequisicion'])->name('requisiciones.eliminarrequisicion');
		Route::get('/ver-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionController::class, 'verRequisicion'])->name('requisiciones.verrequisicion');
		Route::post('/nueva-partida', [App\Http\Controllers\Licitacion\RequisicionController::class, 'nuevaPartida'])->name('requisiciones.nuevapartida');
		Route::post('/eliminar-partida', [App\Http\Controllers\Licitacion\RequisicionController::class, 'eliminarPartida'])->name('requisiciones.eliminarpartida');
		Route::post('/editar-partida', [App\Http\Controllers\Licitacion\RequisicionController::class, 'editarPartida'])->name('requisiciones.editarpartida');
		Route::get('/listado-requisiciones-inactivos', [App\Http\Controllers\Licitacion\RequisicionController::class, 'catalogoRequisicioninactivas'])->name('requisiciones.catalogorequisicioninactivas');
		Route::post('/activar-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'activarrequisicion'])->name('requisiciones.activarrequisicion');
		Route::get('/agregar-información/{id}', [App\Http\Controllers\Licitacion\RequisicionController::class, 'addinfopartidas'])->name('requisiciones.addinfopartidas');
		Route::get('/agregar-información-partida/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionController::class, 'infopartida'])->name('requisiciones.infopartida');
		Route::post('/obtener-subgrupos', [App\Http\Controllers\Licitacion\RequisicionController::class, 'obtenersubgrupos'])->name('requisiciones.obtenersubgrupos');
		Route::post('/obtener-coberturas', [App\Http\Controllers\Licitacion\RequisicionController::class, 'obtenercoberturas'])->name('requisiciones.obtenercoberturas');
		Route::post('/guardar-informacion-partida', [App\Http\Controllers\Licitacion\RequisicionController::class, 'guardarinfopartida'])->name('requisiciones.guardarinfopartida');
		Route::post('/desactivar-equipamiento', [App\Http\Controllers\Licitacion\RequisicionController::class, 'desactivarEquipamiento'])->name('requisiciones.desactivarequipamiento');
		Route::post('/desactivar-aseguramiento', [App\Http\Controllers\Licitacion\RequisicionController::class, 'desactivarAseguramiento'])->name('requisiciones.desactivaraseguramiento');
		Route::post('/finanzas-requisicion', [App\Http\Controllers\Licitacion\RequisicionController::class, 'finanzasRequisicion'])->name('requisiciones.finanzasrequisicion');
		Route::post('/desactivar-emplacamiento', [App\Http\Controllers\Licitacion\RequisicionController::class, 'desactivarEmplacamiento'])->name('requisiciones.desactivaremplacamiento');
		Route::post('/desactivar-lugar-entrega', [App\Http\Controllers\Licitacion\RequisicionController::class, 'desactivarLugarEntrega'])->name('requisiciones.desactivarlugarentrega');
		Route::get('/ver-partida/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionController::class, 'verPartida'])->name('requisiciones.verpartida');


	// R E Q U I S I C I O N E S  C O N C U R S O
	Route::prefix('concurso')->group(function () {
		Route::name('concurso.')->group(function() {
			Route::get('/nueva-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'nuevaRequisicion'])->name('requisiciones.nuevarequisicion');
			Route::get('/listado-requisiciones', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'catalogoRequisicion'])->name('requisiciones.catalogorequisicion');
			Route::post('/dt-requisiciones', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'requisicionDatatable'])->name('requisiciones.requisiciondatatable');
			Route::post('/guardar-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'guardarRequisicion'])->name('requisiciones.guardarrequisicion');
			Route::get('/editar-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'editarRequisicion'])->name('requisiciones.editarrequisicion');
			Route::post('/modificar-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'modificarRequisicion'])->name('requisiciones.modificarrequisicion');
			Route::post('/eliminar-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'eliminarRequisicion'])->name('requisiciones.eliminarrequisicion');
			Route::get('/ver-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'verRequisicion'])->name('requisiciones.verrequisicion');
			Route::post('/nueva-partida', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'nuevaPartida'])->name('requisiciones.nuevapartida');
			Route::post('/eliminar-partida', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'eliminarPartida'])->name('requisiciones.eliminarpartida');
			Route::post('/editar-partida', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'editarPartida'])->name('requisiciones.editarpartida');
			Route::get('/listado-requisiciones-inactivos', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'catalogoRequisicioninactivas'])->name('requisiciones.catalogorequisicioninactivas');
			Route::post('/activar-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'activarrequisicion'])->name('requisiciones.activarrequisicion');
			Route::get('/agregar-información/{id}', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'addinfopartidas'])->name('requisiciones.addinfopartidas');
			Route::get('/agregar-información-partida/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'infopartida'])->name('requisiciones.infopartida');
			Route::post('/obtener-subgrupos', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'obtenersubgrupos'])->name('requisiciones.obtenersubgrupos');
			Route::post('/obtener-coberturas', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'obtenercoberturas'])->name('requisiciones.obtenercoberturas');
			Route::post('/guardar-informacion-partida', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'guardarinfopartida'])->name('requisiciones.guardarinfopartida');
			Route::post('/desactivar-equipamiento', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'desactivarEquipamiento'])->name('requisiciones.desactivarequipamiento');
			Route::post('/desactivar-aseguramiento', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'desactivarAseguramiento'])->name('requisiciones.desactivaraseguramiento');
			Route::post('/finanzas-requisicion', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'finanzasRequisicion'])->name('requisiciones.finanzasrequisicion');
			Route::post('/desactivar-emplacamiento', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'desactivarEmplacamiento'])->name('requisiciones.desactivaremplacamiento');
			Route::post('/desactivar-lugar-entrega', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'desactivarLugarEntrega'])->name('requisiciones.desactivarlugarentrega');
			Route::get('/ver-partida/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionContratoController::class, 'verPartida'])->name('requisiciones.verpartida');
		});
	});

	// R E Q U I S I C I O N E S  O P E R A C I O N E S
		Route::get('/listado-requisiciones-operaciones', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'catalogoRequisicionOperaciones'])->name('reqoperaciones.catalogorequisicionoperaciones');
		Route::post('/listado-requisiciones-operaciones-db', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'requisicionoperacionesDatatable'])->name('reqoperaciones.requisiciondatatable');
		Route::get('/ver-requisicion-operaciones/{id}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'verRequisicionoperaciones'])->name('reqoperaciones.verrequisicionoperaciones');
		Route::get('/ver-partida-operaciones/{partida}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'verPartidaoperaciones'])->name('reqoperaciones.verpartidaoperaciones');
		Route::get('/asignacion-uni-requisicion/{id}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'asignacionunidades'])->name('reqoperaciones.asignacionunidades');
		Route::get('/unidades-patio-requisicion/{patio}/{requisicion}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'unidadesenpatioreq'])->name('reqoperaciones.unidadesenpatioreq');
		Route::post('/asignar-unidad-requisicion', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'asignarunidadrequisicion'])->name('reqoperaciones.asignarunidadrequisicion');
		Route::post('/vistobueno-operaciones', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'vistobuenooperaciones'])->name('reqoperaciones.vistobuenooperaciones');
		Route::post('/eliminarunidad-requisicion', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'eliminarunidadrequisicion'])->name('reqoperaciones.eliminarunidadrequisicion');
		Route::get('/asignacion-unidades-logistica/{id}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'logisticaasignacion'])->name('reqoperaciones.logisticaasignacion');
		Route::get('/nueva-asignacion-unidades-logistica/{id}', [App\Http\Controllers\Licitacion\RequisicionOperacionesController::class, 'nuevalogisticaasignacion'])->name('reqoperaciones.nuevalogisticaasignacion');

	// M E T O D O S   D E  P A G O 
		Route::get('/listado-metodospago', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'listadometodospago'])->name('metodopago.listadometodopago');
		Route::post('/metodopago-datatable', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'metodopagodatatable'])->name('metodopago.metodopagodatatable');
		Route::post('/guardar-metodopago', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'guardarmetodopago'])->name('metodopago.guardarmetodopago');
		Route::post('/editar-metodopago', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'editarmetodopago'])->name('metodopago.editarmetodopago');
		Route::post('/desactivar-metodopago', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'desactivarmetodopago'])->name('metodopago.desactivarmetodopago');
		Route::get('/catalogo-metodopago-inactivos', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'catalogometodopagoinactivas'])->name('metodopago.metodopagoinactivas');
		Route::post('/activar-metodopago', [App\Http\Controllers\Licitacion\MetodoPagoController::class, 'activarmetodopago'])->name('metodopago.activarmetodopago');

	// F O R M A  D E  P A G O
		Route::get('/listado-formaspago', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'listadoformaspago'])->name('formapago.listadoformapago');
		Route::post('/formapago-datatable', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'formapagodatatable'])->name('formapago.formapagodatatable');
		Route::post('/guardar-formapago', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'guardarformapago'])->name('formapago.guardarformapago');
		Route::post('/editar-formapago', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'editarformapago'])->name('formapago.editarformapago');
		Route::post('/desactivar-formapago', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'desactivarformapago'])->name('formapago.desactivarformapago');
		Route::get('/catalogo-formapago-inactivos', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'catalogoformapagoinactivas'])->name('formapago.formapagoinactivas');
		Route::post('/activar-formapago', [App\Http\Controllers\Licitacion\FormaPagoController::class, 'activarformapago'])->name('formapago.activarformapago');

	// P R O P U E S T A  T E C N I C A  L E G A L
		Route::get('/listado-proptecleg', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'listadoproptecleg'])->name('proptecleg.listadoproptecleg');
		Route::post('/proptecleg-datatable', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'propteclegdatatable'])->name('proptecleg.propteclegdatatable');
		Route::post('/guardar-proptecleg', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'guardarproptecleg'])->name('proptecleg.guardarproptecleg');
		Route::post('/editar-proptecleg', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'editarproptecleg'])->name('proptecleg.editarproptecleg');
		Route::post('/desactivar-proptecleg', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'desactivarproptecleg'])->name('proptecleg.desactivarproptecleg');
		Route::get('/catalogo-proptecleg-inactivos', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'catalogoproptecleginactivas'])->name('proptecleg.proptecleginactivas');
		Route::post('/activar-proptecleg', [App\Http\Controllers\Licitacion\PropTecLegController::class, 'activarproptecleg'])->name('proptecleg.activarproptecleg');

	// P R O P U E S T A  T E C N I C A  A D M I N I S T R A T I V A
		Route::get('/listado-proptecadm', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'listadoproptecadm'])->name('proptecadm.listadoproptecadm');
		Route::post('/proptecadm-datatable', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'proptecadmdatatable'])->name('proptecadm.proptecadmdatatable');
		Route::post('/guardar-proptecadm', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'guardarproptecadm'])->name('proptecadm.guardarproptecadm');
		Route::post('/editar-proptecadm', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'editarproptecadm'])->name('proptecadm.editarproptecadm');
		Route::post('/desactivar-proptecadm', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'desactivarproptecadm'])->name('proptecadm.desactivarproptecadm');
		Route::get('/catalogo-proptecadm-inactivos', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'catalogoproptecadminactivas'])->name('proptecadm.proptecadminactivas');
		Route::post('/activar-proptecadm', [App\Http\Controllers\Licitacion\PropTecAdmController::class, 'activarproptecadm'])->name('proptecadm.activarproptecadm');
	
	// P R O P U E S T A  T E C N I C A  F I S C A L
		Route::get('/listado-proptecfis', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'listadoproptecfis'])->name('proptecfis.listadoproptecfis');
		Route::post('/proptecfis-datatable', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'proptecfisdatatable'])->name('proptecfis.proptecfisdatatable');
		Route::post('/guardar-proptecfis', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'guardarproptecfis'])->name('proptecfis.guardarproptecfis');
		Route::post('/editar-proptecfis', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'editarproptecfis'])->name('proptecfis.editarproptecfis');
		Route::post('/desactivar-proptecfis', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'desactivarproptecfis'])->name('proptecfis.desactivarproptecfis');
		Route::get('/catalogo-proptecfis-inactivos', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'catalogoproptecfisinactivas'])->name('proptecfis.proptecfisinactivas');
		Route::post('/activar-proptecfis', [App\Http\Controllers\Licitacion\PropTecFisController::class, 'activarproptecfis'])->name('proptecfis.activarproptecfis');

	// P R O P U E S T A  T E C N I C A  F I N A N C I E R A
		Route::get('/listado-proptecfin', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'listadoproptecfin'])->name('proptecfin.listadoproptecfin');
		Route::post('/proptecfin-datatable', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'proptecfindatatable'])->name('proptecfin.proptecfindatatable');
		Route::post('/guardar-proptecfin', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'guardarproptecfin'])->name('proptecfin.guardarproptecfin');
		Route::post('/editar-proptecfin', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'editarproptecfin'])->name('proptecfin.editarproptecfin');
		Route::post('/desactivar-proptecfin', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'desactivarproptecfin'])->name('proptecfin.desactivarproptecfin');
		Route::get('/catalogo-proptecfin-inactivos', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'catalogoproptecfininactivas'])->name('proptecfin.proptecfininactivas');
		Route::post('/activar-proptecfin', [App\Http\Controllers\Licitacion\PropTecFinController::class, 'activarproptecfin'])->name('proptecfin.activarproptecfin');

	// A R E A  P E R S O N A L
		Route::get('/listado-area', [App\Http\Controllers\Licitacion\AreaController::class, 'listadoarea'])->name('area.listadoarea');
		Route::post('/area-datatable', [App\Http\Controllers\Licitacion\AreaController::class, 'areadatatable'])->name('area.areadatatable');
		Route::post('/guardar-area', [App\Http\Controllers\Licitacion\AreaController::class, 'guardararea'])->name('area.guardararea');
		Route::post('/editar-area', [App\Http\Controllers\Licitacion\AreaController::class, 'editararea'])->name('area.editararea');
		Route::post('/desactivar-area', [App\Http\Controllers\Licitacion\AreaController::class, 'desactivararea'])->name('area.desactivararea');
		Route::get('/catalogo-area-inactivos', [App\Http\Controllers\Licitacion\AreaController::class, 'catalogoareainactivas'])->name('area.catalogoareainactivas');
		Route::post('/activar-area', [App\Http\Controllers\Licitacion\AreaController::class, 'activararea'])->name('area.activararea');

	// C A T A L O G O  U S O  D E  C F D I
		Route::get('/listado-catalogocfdi', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'listadocatalogocfdi'])->name('catalogocfdi.listadocatalogocfdi');
		Route::post('/catalogocfdi-datatable', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'catalogocfdidatatable'])->name('catalogocfdi.catalogocfdidatatable');
		Route::post('/guardar-catalogocfdi', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'guardarcatalogocfdi'])->name('catalogocfdi.guardarcatalogocfdi');
		Route::post('/editar-catalogocfdi', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'editarcatalogocfdi'])->name('catalogocfdi.editarcatalogocfdi');
		Route::post('/desactivar-catalogocfdi', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'desactivarcatalogocfdi'])->name('catalogocfdi.desactivarcatalogocfdi');
		Route::get('/catalogo-catalogocfdi-inactivos', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'catalogocatalogocfdiinactivas'])->name('catalogocfdi.catalogocatalogocfdiinactivas');
		Route::post('/activar-catalogocfdi', [App\Http\Controllers\Licitacion\CatalogoCfdiController::class, 'activarcatalogocfdi'])->name('catalogocfdi.activarcatalogocfdi');

	// A F I A N Z A D O R A S
		Route::get('/listado-afianzadora', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'listadoafianzadora'])->name('afianzadora.listadocatalogoafianzadora');
		Route::post('/afianzadora-datatable', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'afianzadoradatatable'])->name('afianzadora.catalogoafianzadoradatatable');
		Route::post('/guardar-afianzadora', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'guardarafianzadora'])->name('afianzadora.guardarafianzadora');
		Route::post('/editar-afianzadora', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'editarafianzadora'])->name('afianzadora.editarafianzadora');
		Route::post('/desactivar-afianzadora', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'desactivarafianzadora'])->name('afianzadora.desactivarafianzadora');
		Route::get('/listado-afianzadoras-inactivas', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'listadoafianzadorainactivas'])->name('afianzadora.listadocatalogoafianzadorainactivas');
		Route::post('/activar-afianzadora', [App\Http\Controllers\Licitacion\AfianzadoraController::class, 'activarafianzadora'])->name('afianzadora.activarafianzadora');

	// C A T A L O G O  T I P O  D E  F I A N Z A S 
		Route::get('/listado-tipofianza', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'listadotipodefianza'])->name('tipofianza.listadocatalogoatipodfianza');
		Route::post('/tipofianza-datatable', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'tipofianzadatatable'])->name('tipofianza.catalogotipofianzadatatable');
		Route::post('/guardar-tipofianza', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'guardartipofianza'])->name('tipofianza.guardartipofianza');
		Route::post('/editar-tipofianza', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'editartipofianza'])->name('tipofianza.editartipofianza');
		Route::post('/desactivar-tipofianza', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'desactivartipofianza'])->name('tipofianza.desactivartipofianza');
		Route::get('/listado-tipofianza-inactivas', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'listadotipofianzainactivas'])->name('tipofianza.listadocatalogotipofianzainactivas');
		Route::post('/activar-tipofianza', [App\Http\Controllers\Licitacion\TipodFianzaController::class, 'activartipofianza'])->name('tipofianza.activartipofianza');


	// R E Q U I S I C I O N   C O M P R A S
		Route::get('/requisicion-compras', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'reqcompras'])->name('reqcompras.reqcompras');
		Route::get('/crear-requisicion-compras', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'creaarreqcompras'])->name('reqcompras.creaarreqcompras');
		Route::post('/guardar-requisicion-compras', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'guardarreqcompras'])->name('reqcompras.guardarreqcompras');
		Route::get('/ver-requisicion-compras/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'verreqcompras'])->name('reqcompras.verreqcompras');
		Route::get('/editar-requisicion-compras/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'editarreqcompras'])->name('reqcompras.editarreqcompras');
		Route::post('/eliminar-dato-requisicion', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'eliminardatorequisicon'])->name('reqcompras.eliminardatorequisicon');
		Route::post('/update-requisicion-compras', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'updatereqcompras'])->name('reqcompras.updatereqcompras');
		Route::post('/revision-requisicion', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'envrequisicionrevision'])->name('reqcompras.envrequisicionrevision');

	 // R E V I S O N   R E Q U I S I C I O N   C O M P R A S
		Route::get('/revision-requisicion-compras', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'reqrevisioncompras'])->name('reqcompras.reqrevisioncompras');
		Route::get('/revision-ver-requisicion-compras/{id}', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'revisioncomprasver'])->name('reqcompras.revisioncomprasver');
		Route::post('/rechazar-revision-requisicion', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'rechazarreqcompras'])->name('reqcompras.rechazarreqcompras');
		Route::post('/validar-revision-requisicion', [App\Http\Controllers\Licitacion\RequisicionComprasController::class, 'validareqcompras'])->name('reqcompras.validareqcompras');

		