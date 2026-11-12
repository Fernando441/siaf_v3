<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;


    //Listado de Siniestros DINA
    	Route::get('/catalogo-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'catalogodina'])->name('siniestro.catalogodina');
    	Route::post('/cargamasiva-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'cargamasivadina'])->name('siniestro.cargamasivadina');
    	Route::get('/crear-registro-siniestro', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'crearsiniestro'])->name('siniestro.crearsiniestro');
    	Route::post('/guardar-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'guardardina'])->name('siniestro.guardardina');
    	Route::get('/editar-siniestro/{id}', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'editasiniestro'])->name('siniestro.editasiniestro');
    	Route::get('/ver-siniestro/{id}', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'versiniestro'])->name('siniestro.versiniestro');



    //Listado de Siniestros SICUREZZA
    	Route::get('/catalogo-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'catalogosicurezza'])->name('siniestro.catalogosicurezza');
    	Route::post('/cargamasiva-sicuezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'cargamasivasicuezza'])->name('siniestro.cargamasivasicuezza');
    	