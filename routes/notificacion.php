<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

    Route::post('/notificacion', [App\Http\Controllers\Notificacion\NotificacionController::class, 'index'])->name('notificacion.index');
    Route::post('/notificacion/total', [App\Http\Controllers\Notificacion\NotificacionController::class, 'totalNuevos'])->name('notificacion.total');
    Route::get('/notificacion/show', [App\Http\Controllers\Notificacion\NotificacionController::class, 'show'])->name('notificacion.show');
