<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/catalogo-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'catalogotickets'])->name('tickets.catalogo-tickets');
Route::get('/crear-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'creartickets'])->name('tickets.crear-tickets');
Route::get('/ver-tickets/{tickets_id}', [App\Http\Controllers\Tablero\TicketController::class, 'vertickets'])->name('tickets.ver-tickets');

Route::post('/update-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'updateTicket'])->name('tickets.updateTicket');

//Route::get('/ver-cliente/{id}', [App\Http\Controllers\Cliente\ClienteController::class, 'verCliente'])->name('cliente.vercliente');

Route::post('/guardar-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'guardarTicket'])->name('tickets.guardarTickets');
Route::get('/catalogo-tickets-pendientes', [App\Http\Controllers\Tablero\TicketController::class, 'catalogoticketspendientes'])->name('tickets.catalogo-tickets-pendientes');