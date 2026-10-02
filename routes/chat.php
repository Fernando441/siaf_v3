<?php  
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Http;

    // vista de inicio del chat
    Route::get('/inicio', [App\Http\Controllers\Chat\ChatController::class, 'index'])->name('chat.index');
    Route::get('conversacion/{id}', [App\Http\Controllers\Chat\ChatController::class, 'conversation'])->name('chat.to_user');
    Route::post('crear-chat', [App\Http\Controllers\Chat\ChatController::class, 'createChat'])->name('chat.create');
    Route::post('enviar-mensaje', [App\Http\Controllers\Chat\ChatController::class, 'sendMessage'])->name('chat.send');