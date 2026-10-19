<?php

namespace App\Http\Controllers\Tablero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Notificaciones\Notificaciones;
use App\Models\Notificaciones\NotificacionesUsuario;

use App\Models\Cliente\Cliente;

use App\Models\Licitacion\LicitacionSegmento;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Licitacion\Licitacion;

use App\Models\Tablero\Pendientes;
use App\Models\Tablero\PendientesEvidencia;

class TableroController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show()
    {
    	$not = Notificaciones::where('users_permiso', auth()->user()->id)->orderBy('id','ASC')->get();
        $pendientes = Pendientes::where('iduserCreated', auth()->user()->id)->orderBy('id','ASC')->get();

        // Direccion comercial
            // grafica prioridad
                $concursos = Licitacion::orderBy('id','ASC')->get(); //No.Concursos
                $concursos_pri_alta = Licitacion::where("id_licitacion_prioridad", 1)->get(); //Prioridad Alta
                $concursos_pri_media = Licitacion::where("id_licitacion_prioridad", 2)->get(); //Prioridad Media
                $concursos_pri_baja = Licitacion::where("id_licitacion_prioridad", 3)->get(); //Prioridad Baja

            //grafica acto fallo
                $concurso_contrato = Licitacion::where("id_licitacion_estatus", 2)->get(); //Concurso con contrato
                $concurso_sin_contrato = Licitacion::where("id_licitacion_estatus", 1)->get(); //Concurso con contrato

            //pendiente
                $pendiente_no_finalizado = Pendientes::where('iduserCreated', auth()->user()->id)->where('op_finalizado', 0)->orderBy('id','ASC')->get(); //No Finalizadas
                $pendiente_finalizado = Pendientes::where('iduserCreated', auth()->user()->id)->where('op_finalizado', 1)->orderBy('id','ASC')->get(); //Finalizadas
                $pendiente_pri_alta = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad', 0)->orderBy('id','ASC')->get(); //Prioridad_Alta
                $pendiente_pri_media = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad',1)->orderBy('id','ASC')->get(); //Prioridad_Media
                $pendiente_pri_baja = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad',2)->orderBy('id','ASC')->get(); //Prioridad_Media

        return view('tablero.show', compact('not', 'concursos', 'concursos_pri_alta', 'concursos_pri_media', 'concursos_pri_baja', 'concurso_contrato', 'concurso_sin_contrato', 'pendientes', 'pendiente_no_finalizado', 'pendiente_pri_alta', 'pendiente_pri_media', 'pendiente_pri_baja', 'pendiente_finalizado'));
    }

    public function vernotconcurso($licitacion)
    {
    	$info = Licitacion::findOrFail($licitacion);
    	$cliente = Cliente::where('id_cliente', $info->cliente)->first();
        $proposicioneconomica = LicitacionSegmento::where("licitacion_id", $licitacion)->get();
        
        $segmento =ProposicionEconomica::select('licitacion_proposicion_economica.id', 'licitacion_proposicion_economica.licitacion_id','licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad', 'licitacion_proposicion_economica.precio_unitario',
            'tv.tipo_vehiculo','sc.carroceria','sm.motor','st.transmision')
            ->leftjoin("segmentos as sg","sg.id","licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv","tv.id","sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc","sc.id","sg.carroceria_id")
            ->leftjoin("segmento_motor as sm","sm.id","sg.motor_id")
            ->leftjoin("segmento_transmision as st","st.id","sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id",$licitacion)
            ->get();

        return view('tablero.notificacion-concursos', compact('licitacion', 'info', 'proposicioneconomica', 'segmento', 'cliente'));

    }

    public function guardarpendiente(Request $request)
    {
        $data = [
            'prioridad' => $request->prioridad,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_hora_inicio' => $request->fecha_hora_inicio,
            'fecha_hora_final' => $request->fecha_hora_final,
            'op_finalizado' => 0,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Pendientes::insert($data);

        session()->flash('success', 'El pendiente se creo correctamente');
        return redirect()->route('tablero.show');
      
    }

    public function verpendiente($id)
    {
        $pendiente = Pendientes::where('id', $id)->first();
        $evidencia = PendientesEvidencia::where('pendientes_id', $id)->get();

        return view('tablero.verpendiente', compact('pendiente', 'evidencia'));
    }

    public function pendientefinalizado(Request $request)
    {
        $data = [
            'op_finalizado' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        Pendientes::where('id', $request->id)->update($data);

        session()->flash('success', 'La razon social se desactivo correctamente');
        return redirect()->route('taller.verpendiente', $request->id);
    }

    public function pendienteevidencia(Request $request)
    {
        
        // $colIdDocumento = $request->id_documento;
        $colIdArchivo = $request->nombre;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('pendiente/'.auth()->user()->id, $archivo, $archivoNombre);
                $data = [
                    'pendientes_id' => $request->id_evidencia,
                    'nombre_evidencia' =>$colIdArchivo[$indice],
                    'nombre_archivo' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                PendientesEvidencia::insert($data);
            }
        }

        session()->flash('success', 'La evidencia se añadió correctamente');
        return redirect()->route('taller.verpendiente', $request->id_evidencia);

    }

}
