<?php

namespace App\Http\Controllers\Tablero;

use App\Http\Controllers\Controller;
use App\Models\Requisicion\Requisicion;
use App\Models\Segmento\Segmento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Notificaciones\Notificaciones;
use App\Models\Notificaciones\NotificacionesUsuario;



use App\Models\Cliente\Cliente;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;

use App\Models\Licitacion\LicitacionSegmento;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Licitacion\Licitacion;

use App\Models\Tablero\Pendientes;
use App\Models\Tablero\PendientesEvidencia;

class TableroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $not = Notificaciones::where('users_permiso', auth()->user()->id)->orderBy('id', 'ASC')->get();
        $pendientes = Pendientes::where('iduserCreated', auth()->user()->id)->orderBy('id', 'ASC')->get();

        // Direccion comercial
        // grafica prioridad
        $concursos = Licitacion::orderBy('id', 'ASC')->get(); //No.Concursos
        $concursos_pri_alta = Licitacion::where("id_licitacion_prioridad", 1)->get(); //Prioridad Alta
        $concursos_pri_media = Licitacion::where("id_licitacion_prioridad", 2)->get(); //Prioridad Media
        $concursos_pri_baja = Licitacion::where("id_licitacion_prioridad", 3)->get(); //Prioridad Baja

        //grafica acto fallo
        $concurso_contrato = Licitacion::where("id_licitacion_estatus", 2)->get(); //Concurso con contrato
        $concurso_sin_contrato = Licitacion::where("id_licitacion_estatus", 1)->get(); //Concurso con contrato

        //pendiente
        $pendiente_no_finalizado = Pendientes::where('iduserCreated', auth()->user()->id)->where('op_finalizado', 0)->orderBy('id', 'ASC')->get(); //No Finalizadas
        $pendiente_finalizado = Pendientes::where('iduserCreated', auth()->user()->id)->where('op_finalizado', 1)->orderBy('id', 'ASC')->get(); //Finalizadas
        $pendiente_pri_alta = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad', 0)->orderBy('id', 'ASC')->get(); //Prioridad_Alta
        $pendiente_pri_media = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad', 1)->orderBy('id', 'ASC')->get(); //Prioridad_Media
        $pendiente_pri_baja = Pendientes::where('iduserCreated', auth()->user()->id)->where('prioridad', 2)->orderBy('id', 'ASC')->get(); //Prioridad_Media

        //conteo total clientes
        $total_clientes = Cliente::count();
        //conteo total licitaciones
        $total_licitaciones = Licitacion::count();
        //conteo total requisiciones
        $total_requisiciones = Requisicion::whereNotNull('licitaciones_id')->count();
        //conteo total segmentos
        $total_segmentos = Segmento::count();
        //clientes activos
        $total_clientes_activos = Cliente::where('id_status_delete', '1')->count();
        //clientes no activos
        $total_clientes_no_activos = Cliente::where('id_status_delete', '2')->count();
        //conteo fisicas
        $total_fisicas = Cliente::where('tipo_cliente', '1')->count();
        //conteo morales
        $total_morales = Cliente::where('tipo_cliente', '2')->count();

        // Clientes por estados
        $clavesEstados = [
            'AGUASCALIENTES' => 'MX-AGU',
            'BAJA CALIFORNIA' => 'MX-BCN',
            'BAJA CALIFORNIA SUR' => 'MX-BCS',
            'CAMPECHE' => 'MX-CAM',
            'CHOAHUILA DE ZARAGOZ' => 'MX-COA',
            'COAHUILA' => 'MX-COA',
            'COLIMA' => 'MX-COL',
            'CHIAPAS' => 'MX-CHP',
            'CHIHUAHUA' => 'MX-CHH',
            'CIUDAD DE MEXICO' => 'MX-DIF',
            'DURANGO' => 'MX-DUR',
            'GUANAJUATO' => 'MX-GUA',
            'GUERRERO' => 'MX-GRO',
            'HIDALGO' => 'MX-HID',
            'JALISCO' => 'MX-JAL',
            'MEXICO' => 'MX-MEX',
            'Estado de México' => 'MX-MEX',
            'MICHOACAN DE OCAMPO' => 'MX-MIC',
            'Michoacán' => 'MX-MIC',
            'MORELOS' => 'MX-MOR',
            'NAYARIT' => 'MX-NAY',
            'NUEVO LEON' => 'MX-NLE',
            'OAXACA' => 'MX-OAX',
            'PUEBLA' => 'MX-PUE',
            'QUERETARO' => 'MX-QUE',
            'QUINTANA ROO' => 'MX-ROO',
            'SAN LUIS POTOSI' => 'MX-SLP',
            'SINALOA' => 'MX-SIN',
            'SONORA' => 'MX-SON',
            'TABASCO' => 'MX-TAB',
            'TAMAULIPAS' => 'MX-TAM',
            'TLAXCALA' => 'MX-TLA',
            'VERACRUZ' => 'MX-VER',
            'YUCATAN' => 'MX-YUC',
            'ZACATECAS' => 'MX-ZAC',
        ];
        $total_clientes_estados = DB::table('client as c')
            ->join('estado as e', 'c.id_estado', '=', 'e.id_estado')
            ->select(
                'e.id_estado',
                'e.estado_nombre',
                DB::raw('COUNT(c.id_estado) AS total_registros')
            )
            ->groupBy('e.id_estado', 'e.estado_nombre')
            ->orderByDesc('total_registros')
            ->get()
            ->map(function ($item) use ($clavesEstados) {
                $item->clave = $clavesEstados[$item->estado_nombre] ?? null;
                return $item;
            })
            ->filter(function ($item) {
                return $item->clave !== null;
            })
            ->values();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();

        //conteo baja
        $total_concursos_baja = Licitacion::where('id_licitacion_prioridad', 3)->count();
        //conteo media
        $total_concursos_media = Licitacion::where('id_licitacion_prioridad', 2)->count();
        //conteo alta
        $total_concursos_alta = Licitacion::where('id_licitacion_prioridad', 1)->count();
        //id licitacion tipo de contratacion
        $total_tipo_contratacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.junta_aclaraciones',
            'licitaciones.apertura_proposiciones',
            'licitaciones.acto_fallo',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'pl.publicacion_licitacion as publ',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'tc.tipo_contratacion',
            'licitaciones.contratacion',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
            ->where("licitaciones.id_status_delete", 1)

            ->get();

        //Obtener id de estatus
        $estatus = Requisicion::join(
            'requisicion_estatus',
            'requisicion.requisicion_estatus_id',
            '=',
            'requisicion_estatus.id'
        )
            ->select(
                'requisicion_estatus.estatus',
                'requisicion.requisicion_estatus_id'
            )
            ->selectRaw('COUNT(*) as total')
            ->groupBy(
                'requisicion_estatus.id',
                'requisicion_estatus.estatus',
                'requisicion.requisicion_estatus_id'
            )
            ->get();

        return view('tablero.show', compact('not', 'total_tipo_contratacion', 'estatus','total_concursos_alta', 'total_concursos_media', 'total_concursos_baja', 'total_clientes_activos', 'total_fisicas', 'total_morales', 'total_clientes_no_activos', 'total_segmentos', 'total_clientes_estados', 'estados', 'municipios', 'total_requisiciones', 'total_licitaciones', 'total_clientes', 'concursos', 'concursos_pri_alta', 'concursos_pri_media', 'concursos_pri_baja', 'concurso_contrato', 'concurso_sin_contrato', 'pendientes', 'pendiente_no_finalizado', 'pendiente_pri_alta', 'pendiente_pri_media', 'pendiente_pri_baja', 'pendiente_finalizado'));
    }

    public function vernotconcurso($licitacion)
    {
        $info = Licitacion::findOrFail($licitacion);
        $cliente = Cliente::where('id_cliente', $info->cliente)->first();
        $proposicioneconomica = LicitacionSegmento::where("licitacion_id", $licitacion)->get();

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision'
        )
            ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id", $licitacion)
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
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
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
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Pendientes::where('id', $request->id)->update($data);

        session()->flash('success', 'La razon social se desactivo correctamente');
        return redirect()->route('taller.verpendiente', $request->id);
    }

    public function pendienteevidencia(Request $request)
    {

        // $colIdDocumento = $request->id_documento;
        $colIdArchivo = $request->nombre;
        if ($request->hasfile('archivo')) {
            $archivos = $request->file('archivo');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('pendiente/' . auth()->user()->id, $archivo, $archivoNombre);
                $data = [
                    'pendientes_id' => $request->id_evidencia,
                    'nombre_evidencia' => $colIdArchivo[$indice],
                    'nombre_archivo' => $archivoNombre,
                    'created_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id
                ];
                PendientesEvidencia::insert($data);
            }
        }

        session()->flash('success', 'La evidencia se añadió correctamente');
        return redirect()->route('taller.verpendiente', $request->id_evidencia);

    }


}
