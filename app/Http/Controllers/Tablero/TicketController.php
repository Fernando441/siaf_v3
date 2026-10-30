<?php

namespace App\Http\Controllers\Tablero;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsuarioController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Tickets\Tickets;
use App\Models\Tickets\TicketsUsuario;

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
        $documentos = User::where('id_status_delete', 1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($documentos as $documento) {
            $cadenaTipoDocumento .= '"' . $documento->id . '":"' . $documento->name . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';
        return view('tickets.crear-tickets', compact('usuario', 'cadenaTipoDocumento'));
    }

    public function inactivostickets()
    {
        return view("tickets.catalogo-tickets-inactivos");
    }

    public function guardarticket(Request $request)
    {
        
        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'created_at' =>date('Y-m-d H:i:s'),
            //'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_ticket = Tickets::insertGetId($data);

        if($request->id_persona){
            foreach($request->id_persona as $indice => $persona)
            {
  
                $data = [
                    'estatus_visto' => 0,
                    'estatus_finalizado' => 0,
                    'users_id' => $persona,
                    'tickets_id' => $id_ticket,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'fecha_visto' =>date('Y-m-d H:i:s'),
                    'fecha_finalizado' =>date('Y-m-d H:i:s'),
                ];
                TicketsUsuario::insert($data);
            }
        }
        else{
            //$existe="No existe";
        }
        session()->flash('success', 'El ticket se añadió correctamente');
        return redirect()->route('tickets.catalogo-tickets');
    }

    public function catalogoticketspendientes()
    {
        return view("tickets.catalogo-tickets-pendientes");
    }

}