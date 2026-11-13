<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;


    //Listado de Siniestros DINA
    	Route::get('/catalogo-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'catalogodina'])->name('siniestro.catalogodina');
    	Route::post('/cargamasiva-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'cargamasivadina'])->name('siniestro.cargamasivadina');
    	Route::get('/ver-siniestro/{id}', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'versiniestro'])->name('siniestro.versiniestro');
    	Route::get('/editar-siniestro/{id}', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'editasiniestro'])->name('siniestro.editasiniestro');
    	Route::post('/edit-siniestro-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'editsiniestrodina'])->name('siniestro.editsiniestrodina');
    	Route::get('/crear-registro-siniestro', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'crearsiniestro'])->name('siniestro.crearsiniestro');
    	Route::post('/guardar-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'guardardina'])->name('siniestro.guardardina');
    	



    //Listado de Siniestros SICUREZZA
    	Route::get('/catalogo-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'catalogosicurezza'])->name('siniestro.catalogosicurezza');
    	Route::post('/cargamasiva-sicuezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'cargamasivasicuezza'])->name('siniestro.cargamasivasicuezza');
    	Route::get('/ver-siniestro-sicurezza/{id}', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'versiniestrosic'])->name('siniestro.versiniestrosic');
    	Route::get('/editar-siniestro-sicurezza/{id}', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'editarsiniestrosic'])->name('siniestro.editarsiniestrosic');
    	Route::post('/edit-siniestro-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'editsiniestrosic'])->name('siniestro.editsiniestrosic');
    	Route::post('/delete-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'deletesicurezzaevidencia'])->name('siniestro.deletesicurezzaevidencia');
    	Route::get('/crear-siniestro-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'crearsiniestrosic'])->name('siniestro.crearsiniestrosic');
    	Route::post('/add-siniestro-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'addsiniestrosic'])->name('siniestro.addsiniestrosic');