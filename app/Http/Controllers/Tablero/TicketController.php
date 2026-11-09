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

    //MUESTRA TICKETS ORIGINALES
    public function catalogotickets()
    {
        $tickets_activos = Tickets::where('iduserCreated',auth()->user()->id)->get();
        $tickets_pendientes = TicketsUsuario::where('users_id', auth()->user()->id)->where('estatus_finalizado', 0)->get();
        $contador = count($tickets_pendientes);
        //dd($tickets_activos);
        return view('tickets.catalogo-tickets', compact('tickets_activos', 'contador'));
    }

    //CREAR TICKETS ORIGINALES
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

    //GUARDA TICKET ORIGINAL Y TICKETS USUARIOS
    public function guardarticket(Request $request)
    {

        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'created_at' => date('Y-m-d H:i:s'),
            //'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'estatus' => 0,
            'estatus_usuarios' => 0
        ];
        $id_ticket = Tickets::insertGetId($data);

        if ($request->id_persona) {
            foreach ($request->id_persona as $indice => $persona) {

                $data = [
                    'estatus_visto' => 0,
                    'estatus_finalizado' => 0,
                    'users_id' => $persona,
                    'tickets_id' => $id_ticket,
                    'created_at' => date('Y-m-d H:i:s'),
                    'fecha_visto' => date('Y-m-d H:i:s'),
                    'fecha_finalizado' => date('Y-m-d H:i:s'),
                ];
                TicketsUsuario::insert($data);
            }
        } else {
            //$existe="No existe";
        }
        session()->flash('success', 'El ticket se añadió correctamente');
        return redirect()->route('tickets.catalogo-tickets');
    }

    //MUESTRA EL CATALOGO DE TICKETS PENDIENTES
    public function catalogoticketspendientes()
    {
        //$tickets_pendientes = TicketsUsuario::orderBy('id', 'ASC')->get()->groupBy('tickets_id');
        $tickets_pendientes = TicketsUsuario::where('users_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        //dd($tickets_pendientes);
        return view('tickets.catalogo-tickets-pendientes', compact('tickets_pendientes'));
    }

    //MUESTRA LA INFORMACION DEL TICKET PENDIENTE SELECCIONADO
    public function verticketspendeintes($tickets_id)
    {
        $ticket_pendiente = TicketsUsuario::findOrFail($tickets_id);
        return view('tickets.ver-tickets-pendientes', compact('ticket_pendiente'));
    }

    //AL VER EL TICEKT SELECCIONADO ACTUALIZA DATOS DE ESTATUS EN TABLA TICKETS Y TICKETS USUARIOS
    public function updateTicket(Request $request)
    {

        $visto = [
            'estatus_visto' => 1,
            'fecha_visto' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            //'fecha_visto' => now()
        ];
        TicketsUsuario::where('id', $request->id)->update($visto);

        $ticket = TicketsUsuario::where('id', $request->id)->first();
        $vistoticket = [
            'estatus_usuarios' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Tickets::where('id', $ticket->tickets_id)->update($vistoticket);


        return redirect()->route('tickets.ver-tickets-pendientes', $request->id);
    }

    //FINALIZA EL TICKET PENDIENTE
    public function terminadoticket(Request $request)
    {
        $terminado = [
            'estatus_finalizado' => 1,
            'fecha_finalizado' => date('Y-m-d H:i:s')
        ];
        TicketsUsuario::where('id', $request->id)->update($terminado);
        return redirect()->route('tickets.catalogo-tickets-pendientes');
    }

    //MUESTRA LA INOFRMACION DEL TICKET ORIGINAL SELECCIOANDO
    public function vertickets($id_tickets)
    {
        $ticket = Tickets::findOrFail($id_tickets);
        $ticketinfouser = TicketsUsuario::where('tickets_id', $id_tickets)->get();
        //dd($ticketinfouser);
        return view('tickets.ver-tickets', compact('ticket', 'ticketinfouser'));
    }

    public function terminadoticketoriginal(Request $request)
    {
        $terminado = [
            'estatus' => 1,
            'fecha_termino' => date('Y-m-d H:i:s')
        ];
        Tickets::where('id', $request->id)->update($terminado);
        return redirect()->route('tickets.catalogo-tickets');
    }

    public function editartickets($id_tickets_e)
    {
        $usuario = User::where('id_status_delete', 1)->get();

        $editar_ticket = Tickets::findOrFail($id_tickets_e);

        $ticket_usuarios_update = TicketsUsuario::where('tickets_id', $id_tickets_e)->get();

        $cadenaTipoDocumento = [];
        foreach ($usuario as $doc) {
            $cadenaTipoDocumento[$doc->id] = $doc->name;
        }
        $cadenaTipoDocumento = json_encode($cadenaTipoDocumento);

        return view('tickets.editar-tickets', compact('editar_ticket', 'ticket_usuarios_update', 'cadenaTipoDocumento'));
    }
    public function eliminardocumentocliente(Request $request)
    {
        $doc = TicketsUsuario::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('cliente/' . $doc->id_cliente . '/' . $doc->documento);
            TicketsUsuario::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function editarTicket(Request $request)
    {
        //dd($request);
        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Tickets::where('id', $request->id)->update($data);

        if ($request->id_documento) {
            foreach ($request->id_documento as $indice => $persona) {

                $data = [
                    'estatus_visto' => 0,
                    'estatus_finalizado' => 0,
                    'users_id' => $persona,
                    'tickets_id' => $request->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'fecha_visto' => date('Y-m-d H:i:s'),
                    'fecha_finalizado' => date('Y-m-d H:i:s'),
                ];
                TicketsUsuario::insert($data);
            }
        } else {
            //$existe="No existe";
        }

        session()->flash('success', 'El cliente se actualizó correctamente');
        return redirect()->route('tickets.catalogo-tickets');
    }

    public function eliminarTicket(Request $request)
    {
        //dd($request);
        TicketsUsuario::where('tickets_id', $request->id)->delete();
        Tickets::where('id', $request->id)->delete();
        return redirect()->route('tickets.catalogo-tickets');
    }

    public function historialtickets()
    {
        $tickets_historial = Tickets::orderBy('id','DESC')->get();
        return view('tickets.historial-tickets', compact('tickets_historial'));
    }
    public function verhistorialtickets($id_tickets)
    {
        $ticket = Tickets::findOrFail($id_tickets);
        $ticketinfouser = TicketsUsuario::where('tickets_id', $id_tickets)->get();
        //dd($ticketinfouser);
        return view('tickets.ver-historial-tickets', compact('ticket', 'ticketinfouser'));
    }

}