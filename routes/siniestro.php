<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;


    //Listado de Siniestros DINA
    	Route::get('/catalogo-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'catalogodina'])->name('siniestro.catalogodina');
    	Route::post('/cargamasiva-dina', [App\Http\Controllers\Siniestros\SiniestrosDinaController::class, 'cargamasivadina'])->name('siniestro.cargamasivadina');



    //Listado de Siniestros SICUREZZA
    	Route::get('/catalogo-sicurezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'catalogosicurezza'])->name('siniestro.catalogosicurezza');
    	    	Route::post('/cargamasiva-sicuezza', [App\Http\Controllers\Siniestros\SiniestrosSicurezzaController::class, 'cargamasivasicuezza'])->name('siniestro.cargamasivasicuezza');
    	