<?php

namespace App\Http\Controllers\Tablero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Tickets\Tickets;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
    public function mostrar()
    {
        $tickets_activos = Tickets::orderBy('id', 'ASC')->get();
        dd($tickets_activos);

        return view('tickets.catalogo-tickets');
    }*/

    public function catalogotickets()
    {
        $tickets_activos = Tickets::orderBy('id', 'ASC')->get();
        //dd($tickets_activos);
        return view('tickets.catalogo-tickets', compact('tickets_activos'));
    }
    public function creartickets()
    {
        return view('tickets.crear-tickets');
    }

    public function inactivostickets()
    {
        return view("tickets.catalogo-tickets-inactivos");
    }

}