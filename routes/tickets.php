<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

//CATALOGO TICKETS
Route::get('/catalogo-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'catalogotickets'])->name('tickets.catalogo-tickets');
Route::get('/crear-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'creartickets'])->name('tickets.crear-tickets');
Route::post('/guardar-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'guardarTicket'])->name('tickets.guardarTickets');
Route::get('/ver-tickets/{id_tickets}', [App\Http\Controllers\Tablero\TicketController::class, 'vertickets'])->name('tickets.ver-tickets');
Route::post('/terminado-tickets-original', [App\Http\Controllers\Tablero\TicketController::class, 'terminadoticketoriginal'])->name('tickets.terminadoticketoriginal');

Route::get('/editar-tickets/{id_tickets_e}', [App\Http\Controllers\Tablero\TicketController::class, 'editartickets'])->name('tickets.editar-tickets');

//CATALOGO TICKETS PENDIENTES
Route::get('/catalogo-tickets-pendientes', [App\Http\Controllers\Tablero\TicketController::class, 'catalogoticketspendientes'])->name('tickets.catalogo-tickets-pendientes');
Route::get('/ver-tickets-pendientes/{tickets_id}', [App\Http\Controllers\Tablero\TicketController::class, 'verticketspendeintes'])->name('tickets.ver-tickets-pendientes');
Route::post('/update-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'updateTicket'])->name('tickets.updateTicket');
Route::post('/terminado-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'terminadoticket'])->name('tickets.terminadoticket');