<?php

namespace App\Http\Controllers\Tablero;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsuarioController;
use App\Models\User;
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
        $usuario = User::where('id_status_delete', 1)->get();
        //$user = User::where('id', auth()->user()->id)->first();
        //dd($usuario);
                $documentos = User::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->name.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';
        return view('tickets.crear-tickets', compact('usuario', 'cadenaTipoDocumento'));
    }

    public function inactivostickets()
    {
        return view("tickets.catalogo-tickets-inactivos");
    }

    public function guardarticket()
    {
        
    }

}