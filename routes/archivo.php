<?php
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

	//Licitacion
    Route::get('/documento-licitacion/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoLicitacion'])->name('archivo.documentoLicitacion');

    //Proyecto
    Route::get('/documento-proyecto/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoProyecto'])->name('archivo.documentoProyecto');

    //Avance Financiero
    Route::get('/avance-financiero/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoAvanceFinanciero'])->name('archivo.documentoAvanceFinanciero');

    //Deductiva Pago
    Route::get('/deductiva-pago/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoDeductivaPago'])->name('archivo.documentoDeductivaPago');

    //UnidadDocumento
    Route::get('/documento-unidad/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoUnidad'])->name('archivo.documentoUnidad');

    //UnidadFotografia
    Route::get('/fotografia-unidad/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'fotografiaUnidad'])->name('archivo.fotografiaUnidad');

    //UnidadCliente
    Route::get('/documento-cliente/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoCliente'])->name('archivo.documentoCliente');

    //Propuesta Tecnica
    Route::get('/documento-propuesta-tecnica/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPropuestaTecnica'])->name('archivo.propuestaTecnica');

    //Gestor Documentos
    Route::get('/documento-gestor/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoGestor'])->name('archivo.gestorDocumentos');

    //Avatar Usuario
    Route::get('/avatar/{documento}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoAvatar'])->name('archivo.documentoAvatar');

    //Solicitud de Mantenimiento
    Route::get('/documentos-mantenimiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoSolicitudMantenimiento'])->name('archivo.documentoSolicitudMantenimiento');

    // Propuesta Economia
    Route::get('/documento-propuesta/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPropuestaeconomia'])->name('archivo.documentoPropuestaeconomica');

    // Equipamiento Unidad
    Route::get('/evidencia-equipamiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'evidenciaequipamiento'])->name('archivo.evidenciaequipamiento');


    // Archivo equipamiento requisicion Concurso
    Route::get('/archivo-requisicion-equipamiento-concurso/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'archivorequisicionequipamiento'])->name('archivo.archivorequisicionequipamiento');

    // Archivo equipamiento requisicion sin Concurso
    Route::get('/archivo-requisicion-equipamiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'archivorequisicionequipamientosinconcurso'])->name('archivo.archivorequisicionequipamientosinconcurso');

    // Archivo aseguramiento requisicion Concurso
    Route::get('/archivo-requisicion-aseguramiento-concurso/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'archivorequisicionaseguramiento'])->name('archivo.archivorequisicionaseguramiento');

    // Archivo aseguramiento requisicion 
    Route::get('/archivo-requisicion-aseguramiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'archivorequisicionaseguramientosinconcurso'])->name('archivo.archivorequisicionaseguramientosinconcurso');

    //LicitacionFinza
    Route::get('/documento-fianza/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentofianza'])->name('archivo.documentofianza');

    //LicitacionSeguroRc
    Route::get('/documento-segurorc/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentosegurorc'])->name('archivo.documentosegurorc');

    //Pago Tenencia
    Route::get('/documento-pago-tenencia/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoTenencia'])->name('archivo.documentoPagoTenencia');

    //Pago Emplacamiento
    Route::get('/documento-pago-emplacamiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoEmplacamiento'])->name('archivo.documentoPagoEmplacamiento');

    //Pago Verificacion
    Route::get('/documento-pago-verificacion/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoVerificacion'])->name('archivo.documentoPagoVerificacion');

    //Pago Aseguramiento
    Route::get('/documento-pago-aseguramiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoAseguramiento'])->name('archivo.documentoPagoAseguramiento');

    //Pago Remplacamiento
    Route::get('/documento-pago-reemplacamiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoReemplacamiento'])->name('archivo.documentoPagoReemplacamiento');

    //Baja vehicular (siniestro)
    Route::get('/documento-pago-bv-siniestro/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoBvSiniestro'])->name('archivo.documentoPagoBvSiniestro');

    //Baja vehicular (venta)
    Route::get('/documento-pago-bv-venta/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoBvVenta'])->name('archivo.documentoPagoBvVenta');

    //Baja vehicular (robo)
    Route::get('/documento-pago-bv-robo/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoBvRobo'])->name('archivo.documentoPagoBvRobo');

    //Pago Cambio de propietario
    Route::get('/documento-pago-cambiopropietario/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoPagoCambioPropietario'])->name('archivo.documentoPagoCambioPropietario');

    //DocumentoTaller
    Route::get('/documento-taller/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoTaller'])->name('archivo.documentoTaller');

    //EvidenciaOrden comopra
    Route::get('/documento-evidencia-orden-compra/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoEvidenciaOrdenCompra'])->name('archivo.documentoEvidenciaOrdenCompra');

    //Estimaciones Pago
    Route::get('/documento-estimaciones-pago/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'estimacionespago'])->name('archivo.estimacionespago');

    //Notas de Credito
    Route::get('/documento-estimaciones-notacredito/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'estimacionnotacredito'])->name('archivo.estimacionnotacredito');

    //EvidenciaMantenimietno
    Route::get('/documento-evidencia-mantenimiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'evidenciamantenimiento'])->name('archivo.evidenciamantenimiento');

    //Cotizacion Mantenimiento
    Route::get('/documento-cotizacion-mantenimiento/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'cotizavionmantenimiento'])->name('archivo.cotizavionmantenimiento');

    //Documentos de los gestores
    Route::get('/documento-gestores/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoGestores'])->name('archivo.gestoresDocumentos');

    //Requisicion compras
    Route::get('/documento-requisicion-compras/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'requisicioncompras'])->name('archivo.requisicioncompras');
    
    //Requisicion conversión
    Route::get('/documento-requisicion-conversion/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'requisicionConversion'])->name('archivo.requisicionConversion');

    //Seminuevos documentos
    Route::get('/documento-seminuevos/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'seminuevosDocumento'])->name('archivo.seminuevosDocumento');

    //AsignaciondocumentoLogistica
    Route::get('/documento-asignacion-logistica/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoasignacionlog'])->name('archivo.documentoasignacionlog');
    
    //FinanzasEvidencias
    Route::get('/documento-mantenimiento-finanzas/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoMantenimientoFin'])->name('archivo.documentoMantenimientoFin');

    //Evidenciasustituto
    Route::get('/documento-sustituto/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentosustituto'])->name('archivo.documentosustituto');

    //DocumentoTraslado
    Route::get('/documento-traslado/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'documentoTraslado'])->name('archivo.documentotraslado');

    //EvidenciaPendiente
    Route::get('/evidencia-pendiente/{id}', [App\Http\Controllers\Archivo\ArchivoController::class, 'evidenciapendiente'])->name('archivo.evidenciapendiente');