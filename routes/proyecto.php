<?php
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	// Listado de Proyectos
    Route::get('/listado-proyectos', [App\Http\Controllers\Proyecto\ProyectoController::class, 'listadoproyectos'])->name('proyecto.listadoproyectos');
    Route::post('/proyecto-datatable', [App\Http\Controllers\Proyecto\ProyectoController::class, 'proyectodatatable'])->name('proyecto.proyectodatatable');
    Route::post('/agregar-proyecto', [App\Http\Controllers\Proyecto\ProyectoController::class, 'guardarproyecto'])->name('proyecto.guardarproyecto');
    Route::post('/agregar-proyecto-complemento', [App\Http\Controllers\Proyecto\ProyectoController::class, 'guardarproyectocomplemento'])->name('proyecto.guardarproyectocomplemento');
    Route::get('/editar-proyecto/{proyecto}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'editarproyecto'])->name('proyecto.editarproyecto');
    Route::post('/editar-proyecto-uno', [App\Http\Controllers\Proyecto\ProyectoController::class, 'editarproyectouno'])->name('proyecto.editarproyectouno');
    Route::post('/desactivar-proyecto', [App\Http\Controllers\Proyecto\ProyectoController::class, 'desactivarproyecto'])->name('proyecto.desactivarproyecto');
    Route::get('/listado-proyectos-inactivos', [App\Http\Controllers\Proyecto\ProyectoController::class, 'listadoproyectosinactivos'])->name('proyecto.listadoproyectosinactivos');
    Route::post('/activar-proyecto', [App\Http\Controllers\Proyecto\ProyectoController::class, 'activarproyecto'])->name('proyecto.activarproyecto');
    Route::get('/ver-proyecto/{id}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'verProyecto'])->name('proyecto.verproyecto');
    Route::post('/eliminar-documento', [App\Http\Controllers\Proyecto\ProyectoController::class, 'eliminarDocumento'])->name('proyecto.eliminarDocumento');
    Route::post('/eliminar-pago', [App\Http\Controllers\Proyecto\ProyectoController::class, 'eliminarpago'])->name('proyecto.eliminarpago');
    Route::post('/eliminar-deductiva', [App\Http\Controllers\Proyecto\ProyectoController::class, 'eliminardeductiva'])->name('proyecto.eliminardeductiva');
    Route::get('/unid/{id}/pro/{unidad}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'verProyectouni'])->name('proyecto.verproyectouni');
    Route::get('/asignar-proyecto-usd/{proyecto}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'asignarclientes'])->name('proyecto.asignarclientes');
    Route::post('/asignar-cliente-contrato', [App\Http\Controllers\Proyecto\ProyectoController::class, 'asclientecontrato'])->name('proyecto.asclientecontrato');
    Route::post('/eliminar-cliente', [App\Http\Controllers\Proyecto\ProyectoController::class, 'eliminarclientecontrato'])->name('proyecto.eliminarclientecontrato');
    Route::get('/informacion-cliente-proyecto/{proyecto}/{cliente}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'informacioncliente'])->name('proyecto.informacioncliente');
    Route::get('/inventario-entrega-contrato/{unidad}/{licitacion}/{op}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'verinventarioentrega'])->name('proyecto.verinventarioentrega');
    Route::get('/unidades-asignadas-proyecto/{proyecto}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'unidadesasignadasproyecto'])->name('proyecto.unidadesasignadasproyecto');
    Route::get('/retirar-unidades-asignadas-proyecto/{unidad}/{licitacion}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'retunidadesasignadasproyecto'])->name('proyecto.retunidadesasignadasproyecto');
    Route::post('/retirar-unidad-upd', [App\Http\Controllers\Proyecto\ProyectoController::class, 'retirarunidadupd'])->name('proyecto.retirarunidadupd');
    Route::get('/inventario-salida-contrato/{unidad}/{licitacion}/{op}', [App\Http\Controllers\Proyecto\ProyectoController::class, 'verinventariosalida'])->name('proyecto.verinventariosalida');
    Route::post('/descarga-unidades-contrato', [App\Http\Controllers\Proyecto\ProyectoController::class, 'descargaunidadescontrato'])->name('proyecto.descargaunidadescontrato');
    
    // Listado Estimaciones
    Route::get('/estimaciones/{proyecto}', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'estimaciones'])->name('estimaciones.estimaciones');
    Route::post('/estimaciones-datatable', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'estimacionesdatatable'])->name('estimaciones.estimacionesdatatable');
    Route::post('/agregar-estimacion', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'guardarestimacion'])->name('estimaciones.guardarestimacion');
    Route::get('/detalle-estimacion/{proyecto}/{estimacion}', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'detalleestimacion'])->name('estimaciones.detalleestimacion');
    Route::post('/guardar-estimacion-unidades', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'guardarestimacionunidades'])->name('estimaciones.guardarestimacionunidades');
    Route::post('/add-seguimiento-ajax', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'addseguimientoestimacion'])->name('estimaciones.addseguimientoestimacion');
    Route::post('/delete-seguimiento-ajax', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'deleteseguimientoestimacion'])->name('estimaciones.deleteseguimientoestimacion');
    Route::post('/enviar-estimacion-finanzas', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'estimacionafinanzas'])->name('estimaciones.estimacionafinanzas');
    Route::get('/ver-estimacion/{proyecto}/{estimacion}', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'verestimacion'])->name('estimaciones.verestimacion');
    Route::get('/ver-estimacionpro-pdf/{id}', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'verestimacionproPDF'])->name('estimaciones.verPDFpro');
    Route::get('/descargar-estimacion-excel/{proyecto}/{estimacion}', [App\Http\Controllers\Proyecto\EstimacionesController::class, 'descargarEstimacionExcel'])->name('estimaciones.descargarExcel');

	// Listado de Emisores
    Route::get('/listado-emisores', [App\Http\Controllers\Proyecto\EmisorController::class, 'listadoemisores'])->name('emisores.listadoemisores');
    Route::post('/emisor-datatable', [App\Http\Controllers\Proyecto\EmisorController::class, 'emisordatatable'])->name('emisores.emisordatatable');
    Route::post('/guardar-emisor', [App\Http\Controllers\Proyecto\EmisorController::class, 'guardaremisor'])->name('emisores.guardaremisor');
    Route::post('/editar-emisor', [App\Http\Controllers\Proyecto\EmisorController::class, 'editaremisor'])->name('emisores.editaremisor');
    Route::post('/desactivar-emisor', [App\Http\Controllers\Proyecto\EmisorController::class, 'eliminaremisor'])->name('emisores.eliminaremisor');
    Route::get('/catalogo-emisores-inactivos', [App\Http\Controllers\Proyecto\EmisorController::class, 'catalogoemisoresinactivos'])->name('emisores.emisoresinactivos');
    Route::post('/activar-emisor', [App\Http\Controllers\Proyecto\EmisorController::class, 'activaremisor'])->name('emisores.activaremisor');

	// Listado de Tipo de Contrato
    Route::get('/listado-contratos', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'listadotipocontrato'])->name('tipocontrato.listadotipocontrato');
    Route::post('/tipocontrato-datatable', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'tipocontratodatatable'])->name('tipocontrato.tipocontratodatatable');
    Route::post('/guardar-contrato', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'guardarcontrato'])->name('tipocontrato.guardacontrato');
    Route::post('/editar-contrato', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'editarcontrato'])->name('tipocontrato.editarcontrato');
    Route::post('/desactivar-contrato', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'eliminarcontrato'])->name('tipocontrato.eliminarcontrato');
    Route::get('/catalogo-contratos-inactivos', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'catalogocontratosinactivos'])->name('tipocontrato.contratosinactivos');
    Route::post('/activar-contrato', [App\Http\Controllers\Proyecto\TipoContratoController::class, 'activarcontrato'])->name('tipocontrato.activarcontrato');

	// Listado de Fuentes del Proyectos
    Route::get('/listado-fuenteproyecto', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'listadofuenteproyecto'])->name('fuenteproyecto.listadofuenteproyecto');
    Route::post('/fuentecontrato-datatable', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'fuentecontratodatatable'])->name('fuenteproyecto.fuentecontratodatatable');
    Route::post('/guardar-fuente', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'guardarfuente'])->name('fuenteproyecto.guardarfuente');
    Route::post('/editar-fuente', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'editarfuente'])->name('fuenteproyecto.editarfuente');
    Route::post('/desactivar-fuente', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'eliminarfuente'])->name('fuenteproyecto.eliminarfuente');
    Route::get('/catalogo-fuentes-inactivas', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'catalogofuntesinactivos'])->name('fuenteproyecto.fuentesinactivas');
    Route::post('/activar-fuente', [App\Http\Controllers\Proyecto\FuenteProyectoController::class, 'activarfuente'])->name('fuenteproyecto.activarfuente');

    // Listado de penalizaciones y deducciones 
    Route::get('/listado-penalizacionesydeducciones', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'listadopenalizaciones'])->name('penalizaciones.listadopenalizaciones');
    Route::post('/penalizaciondeduccion-datatable', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'penalizaciondeducciondatatable'])->name('penalizaciones.penalizaciondeducciondatatable');
    Route::post('/guardar-penalizacion', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'guardarpenalizacion'])->name('penalizaciones.guardarpenalizacion');
    Route::post('/editar-penalizacion', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'editarpenalizacion'])->name('penalizaciones.editarpenalizacion');
    Route::post('/desactivar-penalizacion', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'eliminarpenalizacion'])->name('penalizaciones.eliminarpenalizacion');
    Route::get('/catalogo-penalizaciones-inactivas', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'catalogopenalizacionesinactivos'])->name('penalizaciones.penalizacionesinactivas');
    Route::post('/activar-penalizacion', [App\Http\Controllers\Proyecto\PenalizacionesDeduccionesoController::class, 'activarpenalizacion'])->name('penalizaciones.activarpenalizacion');

    // Listado de tipos de documento
    Route::get('/listado-tipodedocumento', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'listadotipodocumento'])->name('tipodoc.listadotipodocumento');
    Route::post('/tipodedocumento-datatable', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'tipodedocumentodatatable'])->name('tipodoc.tipodedocumentodatatable');
    Route::post('/guardar-tipodedocumento', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'guardartipodedocumento'])->name('tipodoc.guardartipodedocumento');
    Route::post('/editar-tipodedocumento', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'editartipodedocumento'])->name('tipodoc.editartipodedocumento');
    Route::post('/desactivar-tipodedocumento', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'eliminartipodedocumento'])->name('tipodoc.eliminartipodedocumento');
    Route::get('/catalogo-tipodedocumento-inactivas', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'catalogotipodedocumentoinactivos'])->name('tipodoc.tipodedocumentoinactivas');
    Route::post('/activar-tipodedocumento', [App\Http\Controllers\Proyecto\TipoDocumentoController::class, 'activartipodedocumento'])->name('tipodoc.activartipodedocumento');

    // Listado convenios modificatorios
    Route::get('/listado-conveniomodificatorio', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'listadoconveniomodificatorio'])->name('conveniom.listadoconveniomodificatorio');
     Route::post('/conveniomodificatorio-datatable', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'tipodeconveniomoddatatable'])->name('conveniom.tipodeconveniomoddatatable');
    Route::post('/guardar-conveniomodificatorio', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'guardarconveniomodificatorio'])->name('conveniom.guardarconveniomodificatorio');
    Route::post('/editar-conveniomodificatorio', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'editarconveniomodificatorio'])->name('conveniom.editarconveniomodificatorio');
    Route::post('/desactivar-conveniomodificatorio', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'eliminarconveniom'])->name('conveniom.eliminarconveniom');
    Route::get('/catalogo-conveniom-inactivas', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'catalogoconveniominactivos'])->name('conveniom.conveniominactivas');
    Route::post('/activar-conveniomodificatorio', [App\Http\Controllers\Proyecto\ConvenioModificatorioController::class, 'activarconveniomodificatorio'])->name('conveniom.activarconveniomodificatorio');