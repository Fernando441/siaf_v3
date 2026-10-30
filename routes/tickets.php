<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/catalogo-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'catalogotickets'])->name('tickets.catalogo-tickets');
Route::get('/crear-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'creartickets'])->name('tickets.crear-tickets');
Route::get('/inactivos-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'inactivostickets'])->name('tickets.catalogo-tickets-inactivos');
Route::post('/guardar-tickets', [App\Http\Controllers\Tablero\TicketController::class, 'guardarTicket'])->name('tickets.guardarTickets');