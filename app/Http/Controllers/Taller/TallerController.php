<?php

namespace App\Http\Controllers\Taller;

use App\Http\Controllers\Controller;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\Proveedor;
use App\Models\Unidad\ProveedorDireccion;
use App\Models\Unidad\ProveedorCuentas;
use App\Models\Unidad\ProveedorContacto;
use App\Models\Unidad\ProveedorTipo;
use App\Models\Proyecto\Proyecto;
use App\Models\Licitacion\Licitacion;
use App\Models\Cliente\Cliente;
use App\Models\Taller\TallerSolicitud;
use App\Models\Taller\TallerTipoSolicitud;
use App\Models\Taller\TallerSolicitudEstado;
use App\Models\Taller\TallerSolicitudTipoDocumento;
use App\Models\Taller\TallerSolicitudDocumento;
use App\Models\Taller\Taller;
use App\Models\Taller\TallerServicioAsignado;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Taller\TallerAsignadoSolicitud;
use App\Models\Taller\EvidenciaTaller;
use App\Models\Taller\EvaluacionTaller;
use App\Models\Taller\EvaluacionTallerEjecutivo;
use App\Models\Taller\CotizacionTaller;
use App\Models\Taller\TallerPagoFinanzas;

class TallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function solicitarAtencion()
    {
        return view('taller.buscar-unidad');
    }

    public function solicitarAtencionCliente(){
        return view('taller.buscar-unidad-cliente');
    }

    public function catalogoTalleres()
    {
        $talleres = Taller::all();
        return view('taller.catalogo-talleres', compact('talleres'));
    }

    public function asignarContrato()
    {
        $usuarios = User::all();
        $proyectos = Proyecto::all();
        return view('taller.asignar-contrato', compact('usuarios', 'proyectos'));
    }
    
    public function asignarTallerUsuario()
    {
        $usuarios = User::all();
        $talleres = Taller::all();
        return view('taller.asignar-taller-usuario', compact('usuarios', 'talleres'));
    }

    public function asignarTallerUsuarioPost()
    {
        $taller = Taller::where('id', request()->id_taller)->first();
        $taller->users_id = request()->id_usuario;

        if($taller->save()){
            return redirect()->route('taller.asignartallerusuario')->with('success', 'Taller asignado correctamente');
        }
        return redirect()->route('taller.asignartallerusuario')->with('error', 'Ocurrió un error al asignar el taller');
    }

    public function verMantenimientos()
    {
        $solicitudes = TallerSolicitud::where('iduserCreated', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('taller.ver-mantenimientos', compact('solicitudes'));
    }

    public function garageVerMantenimientos()
    {
        $taller = Taller::whereHas('users', function ($query) {
            $query->where('id', Auth::user()->id);
        })->get();
        
        if ($taller->count() > 0) {
            $solicitudes = collect();
        
            foreach ($taller as $t) {
                $solicitudes = $solicitudes->merge($t->tallerSolicitudes()->orderBy('id', 'desc')->get());
            }
        
            $tipoSolicitudes = TallerTipoSolicitud::all();
            $estados = TallerSolicitudEstado::all();
            return view('taller.garage-ver-mantenimientos', compact('solicitudes', 'tipoSolicitudes', 'estados'));
        } else {
            return view('taller.garage-sin-taller-asignado');
        }
    }

    public function buscarUnidad(Request $request)
    {

        if(isset($request->servicio) && $request->servicio != null)
        {
            Session::flash('servicio', $request->servicio);
        }

        // Use a switch case to determinate search_criteria value
        // if it is no_serie, placas, no_economico
        // if it is no_serie can we search by the full no_serie or the last 8 digits

        $search_criteria = $request->search_criteria;

        if ($search_criteria == 'no_serie') {
            $no_serie = $request->search_criteria_input;
            $unidad = Unidad::where('no_serie', $no_serie)
                            ->orWhere(DB::raw('substr(no_serie, -8)'), substr($no_serie, -8))
                            ->first();
        } else if ($search_criteria == 'placas') {
            $placa = $request->search_criteria_input;
            $unidad = Unidad::where('placa', $placa)->first();
        } else if ($search_criteria == 'no_economico') {
            $numero_economico = $request->search_criteria_input;
            $unidad = Unidad::where('numero_economico', $numero_economico)->first();
        }

        $estado = 0;

        /* Checking if the unidad exists and if it does, it is checking if the ultimaSolicitud exists.
        If it does, it is setting the estado to the ultimaSolicitud's estado and returning the view with the unidad and estado. */
        if ($unidad) {
            $ultimaSolicitud = TallerSolicitud::where('unidad_id', $unidad->id)->orderBy('id', 'desc')->first();
            if ($ultimaSolicitud) {
                $estado = $ultimaSolicitud->taller_solicitud_estado_id;
            }

            $tipoSolicitudes = TallerTipoSolicitud::all();

            $ultimos_mantenimientos = TallerSolicitud::where('unidad_id', $unidad->id)->orderBy('id', 'desc')->take(10)->get();

            $talleres = Taller::all();

            $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

            if ($active == null) {
                $ver = 0;
            } else {
                $ver = $active->id;
            }
            // dd($ver);

            return view('taller.solicitar-atencion', compact('unidad', 'estado', 'tipoSolicitudes', 'ultimos_mantenimientos', 'talleres', 'fotografias', 'active', 'ver'));
        }

        if(isset($request->servicio) && $request->servicio != null) {
            return redirect()->route('taller.clientes.solicitaratencion')->with('error', 'No se encontró la unidad')->withInput();
        }

        return redirect()->route('taller.solicitaratencion')->with('error', 'No se encontró la unidad')->withInput();
    }

    public function registrarSolicitud(Request $request)
    {
        // dd($request);
        $unidad = Unidad::where('no_serie', $request->no_serie)->first();
        $falla = $request->falla ? $request->falla : null;
        if ($unidad) {
            $data = [
                'taller_tipo_solicitud_id' => 1, // 1 = default value
                'tipo_solicitud' => $request->tipo_solicitud,
                'unidad_id' => $unidad->id,
                'taller_solicitud_estado_id' => 1,
                // 'taller_id' => $request->taller,
                'fecha_solicitud' => Carbon::now(),
                'kilometraje' => $request->kilometraje,
                'concepto' => $request->concepto,
                'descripcion_falla' => $falla,
                'traslado' => $request->traslado,
                'observaciones' => $request->observaciones,
                'domicilio' => $request->domicilio,
                'codigo_postal' => $request->codigopostal,
                'sustituto' => $request->sustituto,
                'id_proceso' => 0,
                'op_taller' => 0,
                'op_validacion' => 0,
                'prioridad' => $request->prioridad,
                'iduserCreated' => Auth::user()->id,
                'iduserUpdated' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            TallerSolicitud::insert($data);

            // Si el usuario es un cliente
            if($request->redirect){
                return redirect()->route('taller.clientes.vermantenimientos')->with('success', 'Solicitud registrada correctamente');
            } else {
                return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud registrada correctamente con el No. de serie ' . $request->no_serie);
            }
        }
    }

    public function listarSolicitudes()
    {
        $solicitudes = TallerSolicitud::with('unidad')->get();
        $tipoSolicitudes = TallerTipoSolicitud::all();
        $estados = TallerSolicitudEstado::all();
                // dd($solicitudes );

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->get();
        // dd($records);


        return view('taller.servicios-solicitados', compact('solicitudes', 'tipoSolicitudes', 'estados'));
    }

    public function solicitudesDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TallerSolicitud::all()->count();
        $totalRecordswithFilter = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            ->count();
        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            // ->where('taller_solicitud.id_proceso', 0)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.id', 'like', '%' . $valor . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'no_serie') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('unidad.no_serie', 'like', '%' . $valor . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('tipo_solicitud', 'like', '%' . $searchValue . '%')
                        ->where('tipo_solicitud', 'like', '%' . $valor . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'concepto') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.concepto', 'like', '%' . $valor . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'estado') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud_estado.estado', 'like', '%' . $valor . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'fecha_solicitud') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $fecha = date('Y-m-d', strtotime($valor));
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.fecha_solicitud', 'like', '%' . $fecha . '%')
                        // ->where('taller_solicitud.id_proceso', 0)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        $data_arr = array();
        foreach ($records as $solicitud) {

            $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
            // $proyecto = Proyecto::where('id', $unidad->proyectos_id)->first();
            // $licitacion = Licitacion::where('id', $proyecto->licitacion_id)->first();
            // $cliente = Cliente::where('id_cliente', $licitacion->cliente)->first();

            $proveedor = Proveedor::where('id', $solicitud->proveedores_id)->first();
            $proveedor = $proveedor ? $proveedor->nombre : 'No asignado';


            $data_arr[] = array(
                "id" => $solicitud->id,
                "fecha_solicitud" => $solicitud->fecha_solicitud,
                "no_serie" => $solicitud->unidad->no_serie,
                'prioridad' => $solicitud->prioridad,
                "tipo" => $solicitud->tipo_solicitud,
                "concepto" => $solicitud->concepto,
                "client" => null,
                "estado" => $solicitud->tallerSolicitudEstado->estado,
                "id_proceso" => $solicitud->id_proceso,
                "op_taller" => $solicitud->op_taller,
                "op_validacion" => $solicitud->op_validacion,
                'acciones' => null,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function solicitudesGarageDatatable(Request $request)
{
    $user_id = Auth::user()->id;

    $solicitudes = TallerSolicitud::whereHas('taller.users', function ($query) use ($user_id) {
        $query->where('id', $user_id);
    })->get();

    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $search_arr = $request->get('search');
    $searchValue = $search_arr['value']; // Search value

    // Total records
    $totalRecords = $solicitudes->count();

    // Query
    $query = TallerSolicitud::query();
    $query->whereHas('taller.users', function ($query) use ($user_id) {
        $query->where('id', $user_id);
    });
    $query->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id');
    $query->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id');
    $query->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id');
    $query->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id');
    $query->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente');
    $query->select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado', 'unidad.no_serie', 'client.alias as client');

    // Handle search value
    if ($searchValue != '') {
        $query->where(function ($q) use ($searchValue) {
            $q->where('taller_tipo_solicitud.tipo', 'like', '%' .$searchValue . '%')
            ->orWhere('taller_solicitud_estado.estado', 'like', '%' .$searchValue . '%')
            ->orWhere('unidad.no_serie', 'like', '%' .$searchValue . '%')
            ->orWhere('client.alias', 'like', '%' .$searchValue . '%');
        });
    }

    // Fetch records
    $records = $query->skip($start)
        ->take($rowperpage)
        ->get();

    $data_arr = array();

    // Iterating through fetched records and preparing data to be returned
    foreach ($records as $record) {

        $proveedor = Proveedor::where('id', $record->proveedores_id)->first();
        $proveedor = $proveedor ? $proveedor->nombre : 'No asignado';
        $unidad = Unidad::where('id', $record->unidad_id)->first();
        $proyecto = Proyecto::where('id', $unidad->proyectos_id)->first();
        $licitacion = Licitacion::where('id', $proyecto->licitacion_id)->first();
        $cliente = Cliente::where('id_cliente', $licitacion->cliente)->first();

        $id = $record->id;
        $fecha_solicitud = $record->fecha_solicitud;
        $tipo = $record->tipo;
        $estado = $record->estado;
        $no_serie = $record->no_serie;
        $concepto = $record->concepto;

        $data_arr[] = array(
            "id" => $id,
            "fecha_solicitud" => $fecha_solicitud,
            "proveedor" => $proveedor,
            "tipo" => $tipo,
            "concepto" => $concepto,
            "estado" => $estado,
            "no_serie" => $no_serie,
            "client" => $cliente->alias,
            'acciones' => null,
        );
    }

    // Prepare response data
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalRecords,
        "data" => $data_arr
    );

    // Return response as json
    return response()->json($response);
}


    public function evidenciastaller($id_solicitud)
    {
        $talleres =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 1)
            ->get();

        $solicitudes = TallerSolicitud::where('id', $id_solicitud)->first();
        $asignado_id = TallerAsignadoSolicitud::where('taller_solicitud_id', $solicitudes->id)->first();
        // dd($asignado_id);
        if($asignado_id != null){
            $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                ->where('taller.id', $asignado_id->taller_id)
                ->first();


            $servicios_asignados = TallerServicioAsignado::where('taller_id',$asignado_id->taller_id)->get();
            $id_taller = $asignado_id->taller_id;
        }else{
            $taller = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        $documentos = EvidenciaTaller::where('taller_solicitud_id',$id_solicitud)->get();

        $evaluacion_taller= EvaluacionTallerEjecutivo::where('taller_solicitud_id', $solicitudes->id)->first();
        // dd($evaluacion_taller);
        return view('taller.validacionejecutivo.evidencia-taller', compact('talleres', 'id_solicitud', 'solicitudes', 'asignado_id', 'taller', 'servicios_asignados', 'id_taller', 'documentos', 'evaluacion_taller'));
    }


    public function verSolicitud($id)
    {
        $solicitud = TallerSolicitud::with('unidad')->where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $documentosSolicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $id)->where('id_status_delete', 1)->get();
        $evidencia = false;
        foreach ($documentosSolicitud as $documento) {
            if ($documento->taller_solicitud_tipo_documento_id == 6) {
                $evidencia = true;
            }
        }

        $taller = Taller::where('id_status_delete', 1)->get();
        // dd($taller);

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        return view('taller.ver-solicitud', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver'));
    }

    public function autorizarSolicitud(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 2; //preautorizado
        $solicitud->proveedores_id = $request->proveedor;
        $solicitud->proveedor_cuentas_id = $request->cuenta;
        $solicitud->proveedor_direccion_id = $request->direccion;
        $solicitud->importe = $request->importe;
        $solicitud->fecha_cita = $request->fecha_cita;

        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud autorizada correctamente');
    }

    public function autorizarParaEvidencia(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 3; //autorizado
        $solicitud->importe = $request->importe;
        $solicitud->fecha_cita = $request->fecha_cita;
        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud autorizada correctamente');
    }

    //preautorizarconevidencia
    public function preautorizarConEvidencia(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 4; //con evidencia
        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud preautorizada correctamente');
    }

    // Confirmar pago
    public function confirmarPago(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 5; //pagado
        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud confirmada correctamente');
    }

    //finalizarSolicitud
    public function finalizarSolicitud(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 6; //finalizado
        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud finalizada correctamente');
    }

    //RECHAZAR SOLICITUD
    public function rechazarSolicitud(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->taller_solicitud_estado_id = 8; //rechazada
        $solicitud->save();
        return redirect()->route('taller.serviciossolicitados')->with('success', 'Solicitud rechazada correctamente');
    }

    public function buscarProveedor(Request $request)
    {
        $proveedores = Proveedor::where('rfc', 'like', '%' . $request->rfc . '%')->get();
        return response()->json($proveedores);
    }

    public function getCuenta(Request $request)
    {
        $cuentas = ProveedorCuentas::where('proveedores_id', $request->id)->get();
        return response()->json($cuentas);
    }

    public function getDireccion(Request $request)
    {
        $direcciones = ProveedorDireccion::where('proveedores_id', $request->id)->get();
        return response()->json($direcciones);
    }

    //EDITAR Y ACTUALIZAR SOLICITUD
    public function editarSolicitud($id)
    {
        $solicitud = TallerSolicitud::where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $proveedor = Proveedor::where('id', $solicitud->proveedores_id)->first();
        $cuentas = ProveedorCuentas::where('proveedores_id', $solicitud->proveedores_id)->get();
        $direcciones = ProveedorDireccion::where('proveedores_id', $solicitud->proveedores_id)->get();

        $tiposSolicitud = TallerTipoSolicitud::all();
        $estadosSolicitud = TallerSolicitudEstado::where('id', 6)->orWhere('id', 8)->get();
        $ultimos_mantenimientos = TallerSolicitud::where('unidad_id', $unidad->id)->orderBy('id', 'desc')->take(5)->get();

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }


        if ($solicitud) {
            return view('taller.editar-solicitud', compact('solicitud', 'proveedor', 'cuentas', 'direcciones', 'unidad', 'tiposSolicitud', 'estadosSolicitud', 'ultimos_mantenimientos', 'fotografias', 'active', 'ver'));
        } else {
            return redirect()->route('taller.solicitudes')->with('error', 'No se encontró la solicitud');
        }
    }

    public function actualizarSolicitud(Request $request)
    {
        $solicitud = TallerSolicitud::where('id', $request->id)->first();
        $solicitud->concepto = $request->concepto;
        $solicitud->importe = $request->importe;
        $solicitud->fecha_cita = $request->fecha_cita;
        $solicitud->proveedores_id = $request->proveedor;
        $solicitud->proveedor_cuentas_id = $request->cuenta;
        $solicitud->proveedor_direccion_id = $request->direccion;
        $solicitud->kilometraje = $request->kilometraje;
        $solicitud->codigo_postal = $request->codigo_postal;
        $solicitud->descripcion_falla = $request->descripcion_falla;
        $solicitud->traslado = $request->traslado;
        $solicitud->domicilio = $request->domicilio;
        $solicitud->observaciones = $request->observaciones;
        $solicitud->sustituto = $request->sustituto;
        $solicitud->fecha_solicitud = $request->fecha_solicitud;


        if ($request->tipo_solicitud != 0) {
            $solicitud->tipo_solicitud = $request->tipo_solicitud;
        }
        

        if ($request->estatus_solicitud != 0) {
            $solicitud->taller_solicitud_estado_id = $request->estatus_solicitud;
        }


        $solicitud->save();
        return redirect()->route('taller.editarsolicitud', $request->id)->with('success', 'Solicitud actualizada correctamente');
    }

    public function listadotallersol($id_solicitud)
    {
        $talleres =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 1)
            ->get();

        $solicitudes = TallerSolicitud::where('id', $id_solicitud)->first();
        $asignado_id = TallerAsignadoSolicitud::where('taller_solicitud_id', $solicitudes->id)->first();
        // dd($asignado_id);
        if($asignado_id != null){
            $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                ->where('taller.id', $asignado_id->taller_id)
                ->first();


            $servicios_asignados = TallerServicioAsignado::where('taller_id',$asignado_id->taller_id)->get();
            $id_taller = $asignado_id->taller_id;
        }else{
            $taller = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        $documentos = EvidenciaTaller::where('taller_solicitud_id',$id_solicitud)->get();

        $evaluacion_taller= EvaluacionTaller::where('taller_solicitud_id', $solicitudes->id)->first();
        // dd($evaluacion_taller);
        return view('taller.asignar-taller-solicitud', compact('talleres', 'id_solicitud', 'solicitudes', 'asignado_id', 'taller', 'servicios_asignados', 'id_taller', 'documentos', 'evaluacion_taller'));
    }

    public function complementartallersol($id_solicitud, $id_taller)
    {

        $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id', $id_taller)
            ->first();


        $servicios_asignados = TallerServicioAsignado::where('taller_id',$id_taller)->get();

        // dd($servicios_asignados);

        return view('taller.asignar-taller-info', compact('id_taller', 'id_solicitud', 'servicios_asignados', 'taller'));
    }

    public function tallerasignadosolicitud(Request $request)
    {
        // dd($request);
        $data = [
            'taller_solicitud_id' => $request->id_solicitud,
            'taller_id' => $request->taller,
            'fecha_asignacion' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
        ];

        TallerAsignadoSolicitud::insert($data);

        $data = [
            'op_taller' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'El taller se asigno correctamente');
        return redirect()->route('taller.serviciossolicitados');

    }

    public function eliminartallerasignado(Request $request)
    {
        // dd($request);
        TallerAsignadoSolicitud::where('taller_solicitud_id',$request->id_solicitud)->delete();

        $data = [
            'op_taller' => 0,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'El taller se elimino correctamente');
        return redirect()->route('taller.listadotallersol',$request->id_solicitud );
    }


    public function Validacionmantenimientos()
    {
        $solicitudes = TallerSolicitud::with('unidad')->get();
        $tipoSolicitudes = TallerTipoSolicitud::all();
        $estados = TallerSolicitudEstado::all();
                // dd($solicitudes );

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->get();
        // dd($records);


        return view('taller.validacion.validacion-mantenimientos', compact('solicitudes', 'tipoSolicitudes', 'estados'));
    }

    public function verSolicitudvalidacion($id)
    {
        // dd($id);
        $solicitud = TallerSolicitud::with('unidad')->where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $documentosSolicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $id)->where('id_status_delete', 1)->get();
        $evidencia = false;
        foreach ($documentosSolicitud as $documento) {
            if ($documento->taller_solicitud_tipo_documento_id == 6) {
                $evidencia = true;
            }
        }

        $taller = Taller::where('id_status_delete', 1)->get();
        // dd($taller);

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        $asignado_id = TallerAsignadoSolicitud::where('taller_solicitud_id', $solicitud->id)->first();
        // dd($asignado_id);
        if($asignado_id != null){
            $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                ->where('taller.id', $asignado_id->taller_id)
                ->first();


            $servicios_asignados = TallerServicioAsignado::where('taller_id',$asignado_id->taller_id)->get();
            $id_taller = $asignado_id->taller_id;
        }else{
            $taller = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        $documentos_solicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $solicitud->id)->get();

        $ejecutivos_mantenimiento = User::where('op_disponible', 0)->where('role', 17)->get();

        return view('taller.validacion.ver-solicitud-validacion', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver', 'taller', 'servicios_asignados', 'documentos_solicitud', 'ejecutivos_mantenimiento'));
    }


    public function solicitudesValidacionDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TallerSolicitud::all()->count();
        $totalRecordswithFilter = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            ->count();
        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            ->where('taller_solicitud.id_proceso', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.id', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'no_serie') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('unidad.no_serie', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('tipo_solicitud', 'like', '%' . $searchValue . '%')
                        ->where('tipo_solicitud', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'concepto') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.concepto', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'estado') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud_estado.estado', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'fecha_solicitud') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $fecha = date('Y-m-d', strtotime($valor));
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.fecha_solicitud', 'like', '%' . $fecha . '%')
                        ->where('taller_solicitud.id_proceso', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        $data_arr = array();
        foreach ($records as $solicitud) {

            $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
            // $proyecto = Proyecto::where('id', $unidad->proyectos_id)->first();
            // $licitacion = Licitacion::where('id', $proyecto->licitacion_id)->first();
            // $cliente = Cliente::where('id_cliente', $licitacion->cliente)->first();

            $proveedor = Proveedor::where('id', $solicitud->proveedores_id)->first();
            $proveedor = $proveedor ? $proveedor->nombre : 'No asignado';


            $data_arr[] = array(
                "id" => $solicitud->id,
                "fecha_solicitud" => $solicitud->fecha_solicitud,
                "no_serie" => $solicitud->unidad->no_serie,
                'prioridad' => $solicitud->prioridad,
                "tipo" => $solicitud->tipo_solicitud,
                "concepto" => $solicitud->concepto,
                "client" => null,
                "estado" => $solicitud->tallerSolicitudEstado->estado,
                'acciones' => null,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function solicitudafinanzas(Request $request)
    {
        $solicitud = TallerSolicitud::find($request->id);
        $solicitud->id_proceso = 1;
        $solicitud->taller_solicitud_estado_id = 2;
        $solicitud->iduserUpdated = Auth::user()->id;
        $solicitud->save();

        return response()->json(['success' => 'Solicitud enviada correctamente']);  
    }

    public function rechazarsolicitudmantenimiento(Request $request)
    {

        $data = [
            'taller_solicitud_estado_id' => 3,
            'id_proceso' => 0,
            'motivo' => $request->motivo,
            'fecha_validacion' =>date('Y-m-d H:i:s'),
            'user_validacion' => Auth::user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La solicitud se rechazo correctamente');
        return redirect()->route('taller.Validacionmantenimientos');


    }

    public function validacionsolicitudmantenimiento(Request $request)
    {
        
        $data = [
            'taller_solicitud_estado_id' => 4,
            'id_proceso' => 0,
            'fecha_validacion' =>date('Y-m-d H:i:s'),
            'user_validacion' => Auth::user()->id,
            'ejecutivo_mantenimiento' => $request->ejecutivo,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La solicitud se autorizo correctamente');
        return redirect()->route('taller.Validacionmantenimientos');
    }

    public function validacionsolicitudmantenimientoaleatorio(Request $request)
    {
        

        $ejecutivos_mantenimiento = User::where('op_disponible', 0)->where('role', 17)->get();
        $id_ejecutivo = array();
        foreach ($ejecutivos_mantenimiento as $key => $value) {
            
            $id_ejecutivo[] = $value->id;
        }
        $rand_keys = array_rand($id_ejecutivo, 1);

        $data = [
            'taller_solicitud_estado_id' => 4,
            'id_proceso' => 0,
            'ejecutivo_mantenimiento' => $id_ejecutivo[$rand_keys],
            'fecha_autorizacion' =>date('Y-m-d H:i:s'),
            'user_autorizacion' => Auth::user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];


        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La solicitud se autorizo correctamente');
        return redirect()->route('taller.Validacionmantenimientos');
    }

    public function evidenciassolicitudtaller(Request $request)
    {
        
        $id_taller= TallerAsignadoSolicitud::where('taller_solicitud_id',$request->id_solicitud)->first();
        

        $observaciones = $request->observaciones;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('mantenimiento/'.$id_taller->taller_solicitud_id, $archivo, $archivoNombre);
                $data = [
                    'taller_solicitud_id' => $id_taller->taller_solicitud_id,
                    'taller_id'=> $id_taller->taller_id,
                    'evidencia' => $observaciones[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];

                EvidenciaTaller::insert($data);
            }
        }

        session()->flash('success', 'El documento se añadió correctamente');
        return redirect()->route('taller.listadotallersol', $id_taller->taller_solicitud_id );

    }

    public function eliminarevidenciataller(Request $request)
    {
        $doc = EvidenciaTaller::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('mantenimiento/'.$doc->taller_solicitud_id.'/'.$doc->documento);
            EvidenciaTaller::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function Validacionmantenimientosejecutivo()
    {
        $solicitudes = TallerSolicitud::with('unidad')->get();
        $tipoSolicitudes = TallerTipoSolicitud::all();
        $estados = TallerSolicitudEstado::all();
                // dd($solicitudes );

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->get();

        $user = User::where('id', auth()->user()->id)->first();

        return view('taller.validacionejecutivo.validacion-mantenimientos-ejecutivo', compact('solicitudes', 'tipoSolicitudes', 'estados', 'user'));
    }

    public function solicitudesValidacionDatatableejecutivo(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TallerSolicitud::all()->count();
        $totalRecordswithFilter = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            ->count();
        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
            ->where('taller_solicitud.taller_solicitud_estado_id', 4) 
            ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.id', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'no_serie') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('unidad.no_serie', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('tipo_solicitud', 'like', '%' . $searchValue . '%')
                        ->where('tipo_solicitud', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'concepto') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.concepto', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'estado') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud_estado.estado', 'like', '%' . $valor . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'fecha_solicitud') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $fecha = date('Y-m-d', strtotime($valor));
                    $records = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
                        ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
                        ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
                        ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
                        // ->join('proyectos', 'unidad.proyectos_id', '=', 'proyectos.id')
                        // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
                        ->where('taller_tipo_solicitud.tipo', 'like', '%' . $searchValue . '%')
                        ->where('taller_solicitud.fecha_solicitud', 'like', '%' . $fecha . '%')
                        ->where('taller_solicitud.taller_solicitud_estado_id', 4)
                        ->where('taller_solicitud.ejecutivo_mantenimiento', auth()->user()->id) 
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        $data_arr = array();
        foreach ($records as $solicitud) {

            $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
            // $proyecto = Proyecto::where('id', $unidad->proyectos_id)->first();
            // $licitacion = Licitacion::where('id', $proyecto->licitacion_id)->first();
            // $cliente = Cliente::where('id_cliente', $licitacion->cliente)->first();

            $proveedor = Proveedor::where('id', $solicitud->proveedores_id)->first();
            $proveedor = $proveedor ? $proveedor->nombre : 'No asignado';


            $data_arr[] = array(
                "id" => $solicitud->id,
                "fecha_solicitud" => $solicitud->fecha_solicitud,
                "no_serie" => $solicitud->unidad->no_serie,
                'prioridad' => $solicitud->prioridad,
                "tipo" => $solicitud->tipo_solicitud,
                "concepto" => $solicitud->concepto,
                "client" => null,
                "estado" => $solicitud->tallerSolicitudEstado->estado,
                'acciones' => null,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);       
    }

    public function verSolicitudvalidacionejecutivo($id)
    {
        // dd($id);
        $solicitud = TallerSolicitud::with('unidad')->where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $documentosSolicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $id)->where('id_status_delete', 1)->get();
        $evidencia = false;
        foreach ($documentosSolicitud as $documento) {
            if ($documento->taller_solicitud_tipo_documento_id == 6) {
                $evidencia = true;
            }
        }

        $taller = Taller::where('id_status_delete', 1)->get();
        // dd($taller);

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        $asignado_id = TallerAsignadoSolicitud::where('taller_solicitud_id', $solicitud->id)->first();
        // dd($asignado_id);
        if($asignado_id != null){
            $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                ->where('taller.id', $asignado_id->taller_id)
                ->first();


            $servicios_asignados = TallerServicioAsignado::where('taller_id',$asignado_id->taller_id)->get();
            $id_taller = $asignado_id->taller_id;
        }else{
            $taller = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        $documentos_solicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $solicitud->id)->get();
        // dd($documentos_solicitud);
        return view('taller.validacionejecutivo.ver-solicitud-validacion-ejecutivo', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver', 'taller', 'servicios_asignados', 'documentos_solicitud'));
    }

    public function validacionsolicitudmantenimientoejecutivo(Request $request)
    {
        $data = [
            'taller_solicitud_estado_id' => 4,
            'id_proceso' => 0,
            'fecha_validacion' =>date('Y-m-d H:i:s'),
            'user_validacion' => Auth::user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La solicitud se autorizo correctamente');
        return redirect()->route('taller.Validacionmantenimientosejecutivo');       
    }

    public function rechazarsolicitudmantenimientoejecutivo(Request $request)
    {

        $data = [
            'taller_solicitud_estado_id' => 3,
            'id_proceso' => 0,
            'motivo' => $request->motivo,
            'fecha_autorizacion' =>date('Y-m-d H:i:s'),
            'user_autorizacion' => Auth::user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TallerSolicitud::where('id', $request->id_solicitud)->update($data);

        session()->flash('success', 'La solicitud se rechazo correctamente');
        return redirect()->route('taller.Validacionmantenimientosejecutivo');       
    }

    public function evaluaciontaller(Request $request)
    {
        
        $servicios_asignados = TallerAsignadoSolicitud::where('taller_solicitud_id',$request->id_solicitud)->first();

        $taller = Taller::where('id', $servicios_asignados->taller_id)->get();

        $res_tecnica = $request->tecnica_uno * 2;
        $res_operativa = ($request->operativa_uno + $request->operativa_dos +  $request->operativa_tres) * 2;
        $res_administrativa =  ($request->admin_uno + $request->admin_dos + $request->admin_tres) * 2;
        $res_cliente = ($request->serv_uno + $request->serv_dos +  $request->serv_tres) * 2;
        $res_financiera = ($request->fin_uno + $request->fin_dos) * 2;
        $res_total =  $res_tecnica + $res_operativa + $res_administrativa + $res_cliente + $res_financiera;

        
        $data = [
            'taller_solicitud_id' => $request->id_solicitud,
            'taller_id' => $servicios_asignados->taller_id,
            'tec_calidad' => $request->tecnica_uno,
            'tec_calidad_obs' => $request->tecnica_uno_ob,
            'ope_tiempo' => $request->operativa_uno,
            'ope_tiempo_obs' => $request->operativa_uno_ob,
            'ope_cumplimiento' => $request->operativa_dos,
            'ope_cumplimiento_obs' => $request->operativa_dos_ob,
            'ope_cobertura' => $request->operativa_tres,
            'ope_cobertura_obs' => $request->operativa_tres_ob,
            'adm_documentacion' => $request->admin_uno,
            'adm_documentacion_obs' => $request->admin_uno_ob,
            'adm_claridad' => $request->admin_dos,
            'adm_claridad_obs' => $request->admin_dos_ob,
            'adm_registro' => $request->admin_tres,
            'adm_registro_obs' => $request->admin_tres_ob,
            'cli_trato' => $request->serv_uno,
            'cli_trato_obs' => $request->serv_uno_ob,
            'cli_disposicion' => $request->serv_dos,
            'cli_disposicion_obs' => $request->serv_dos_ob,
            'cli_resultados' => $request->serv_tres,
            'cli_resultados_obs' => $request->serv_tres_ob,
            'fin_relacion' => $request->fin_uno,
            'fin_relacion_obs' => $request->fin_uno_ob,
            'fin_entrega' => $request->fin_dos,
            'fin_entrega_obs' => $request->fin_dos_ob,

            'res_tecnica' => $res_tecnica,
            'res_operativa' => $res_operativa,
            'res_administrativa' => $res_administrativa,
            'res_cliente' => $res_cliente,
            'res_financiera' => $res_financiera,
            'res_total' => $res_total,

            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id
        ];

        EvaluacionTaller::insert($data);
        $taller_evaluaciones = EvaluacionTaller::where('taller_id', $servicios_asignados->taller_id)->get();

        // dd( $taller_evaluaciones);
        $promedio = 0;
        foreach ($taller_evaluaciones as $key => $value) {
            $div_promedio = $value->res_total / 12;
            $dec_promedio_res = round($div_promedio, 2);
            $promedio = $promedio + $div_promedio;
        }
            $total_prom = $promedio / count($taller_evaluaciones);
        // dd($total_prom);

        $data_prom = [
            'calificacion' => $total_prom,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Taller::where('id', $servicios_asignados->taller_id)->update($data_prom);


        session()->flash('success', 'La calificación se añadió correctamente');
        return redirect()->route('taller.listadotallersol', $request->id_solicitud);
    }

    public function ejecutivonodisponible(Request $request)
    {
        // dd($request);
        $data = [
            'op_disponible' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        User::where('id', auth()->user()->id)->update($data);

        session()->flash('success', 'El estatus se cambio correctamente, no recibiras solicitudes');
        return redirect()->route('taller.Validacionmantenimientosejecutivo');

    }

    public function ejecutivodisponible(Request $request)
    {
        $data = [
            'op_disponible' => 0,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        User::where('id', auth()->user()->id)->update($data);

        session()->flash('success', 'El estatus se cambio correctamente, recibiras solicitudes');
        return redirect()->route('taller.Validacionmantenimientosejecutivo');        
    }

    public function evaluaciontallerejecutivo(Request $request)
    {
        $servicios_asignados = TallerAsignadoSolicitud::where('taller_solicitud_id',$request->id_solicitud)->first();

        $taller = Taller::where('id', $servicios_asignados->taller_id)->get();

        $res_tecnica = $request->tecnica_uno * 2;
        $res_operativa = ($request->operativa_uno + $request->operativa_dos +  $request->operativa_tres) * 2;
        $res_administrativa =  ($request->admin_uno + $request->admin_dos + $request->admin_tres) * 2;
        $res_cliente = ($request->serv_uno + $request->serv_dos +  $request->serv_tres) * 2;
        $res_financiera = ($request->fin_uno + $request->fin_dos) * 2;
        $res_total =  $res_tecnica + $res_operativa + $res_administrativa + $res_cliente + $res_financiera;

        
        $data = [
            'taller_solicitud_id' => $request->id_solicitud,
            'taller_id' => $servicios_asignados->taller_id,
            'tec_calidad' => $request->tecnica_uno,
            'tec_calidad_obs' => $request->tecnica_uno_ob,
            'ope_tiempo' => $request->operativa_uno,
            'ope_tiempo_obs' => $request->operativa_uno_ob,
            'ope_cumplimiento' => $request->operativa_dos,
            'ope_cumplimiento_obs' => $request->operativa_dos_ob,
            'ope_cobertura' => $request->operativa_tres,
            'ope_cobertura_obs' => $request->operativa_tres_ob,
            'adm_documentacion' => $request->admin_uno,
            'adm_documentacion_obs' => $request->admin_uno_ob,
            'adm_claridad' => $request->admin_dos,
            'adm_claridad_obs' => $request->admin_dos_ob,
            'adm_registro' => $request->admin_tres,
            'adm_registro_obs' => $request->admin_tres_ob,
            'cli_trato' => $request->serv_uno,
            'cli_trato_obs' => $request->serv_uno_ob,
            'cli_disposicion' => $request->serv_dos,
            'cli_disposicion_obs' => $request->serv_dos_ob,
            'cli_resultados' => $request->serv_tres,
            'cli_resultados_obs' => $request->serv_tres_ob,
            'fin_relacion' => $request->fin_uno,
            'fin_relacion_obs' => $request->fin_uno_ob,
            'fin_entrega' => $request->fin_dos,
            'fin_entrega_obs' => $request->fin_dos_ob,

            'res_tecnica' => $res_tecnica,
            'res_operativa' => $res_operativa,
            'res_administrativa' => $res_administrativa,
            'res_cliente' => $res_cliente,
            'res_financiera' => $res_financiera,
            'res_total' => $res_total,

            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id
        ];

        EvaluacionTallerEjecutivo::insert($data);
        $taller_evaluaciones = EvaluacionTallerEjecutivo::where('taller_id', $servicios_asignados->taller_id)->get();

        // dd( $taller_evaluaciones);
        $promedio = 0;
        foreach ($taller_evaluaciones as $key => $value) {
            $div_promedio = $value->res_total / 12;
            $dec_promedio_res = round($div_promedio, 2);
            $promedio = $promedio + $div_promedio;
        }
            $total_prom = $promedio / count($taller_evaluaciones);
        // dd($total_prom);

        $data_prom = [
            'calificacion' => $total_prom,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Taller::where('id', $servicios_asignados->taller_id)->update($data_prom);


        session()->flash('success', 'La calificación se añadió correctamente');
        return redirect()->route('taller.evidenciastaller', $request->id_solicitud);        
    }

    public function responsablemantenimiento()
    {
        $solicitudes = TallerSolicitud::orderBy('id', 'desc')->get();

        return view('taller.responsable-mantenimientos', compact('solicitudes'));        
    }

    public function versolicitudresponsablemantenimiento($id)
    {
        $solicitud = TallerSolicitud::with('unidad')->where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $documentosSolicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $id)->where('id_status_delete', 1)->get();
        $evidencia = false;
        foreach ($documentosSolicitud as $documento) {
            if ($documento->taller_solicitud_tipo_documento_id == 6) {
                $evidencia = true;
            }
        }

        $taller = Taller::where('id_status_delete', 1)->get();
        // dd($taller);

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        $asignado_id = TallerAsignadoSolicitud::where('taller_solicitud_id', $solicitud->id)->first();
        // dd($asignado_id);
        if($asignado_id != null){
            $taller =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                ->where('taller.id', $asignado_id->taller_id)
                ->first();


            $servicios_asignados = TallerServicioAsignado::where('taller_id',$asignado_id->taller_id)->get();
            $id_taller = $asignado_id->taller_id;
            $taller_op = 1;
        }else{
            $taller = 0;
            $taller_op = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        // dd($taller);

        $documentos_solicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $solicitud->id)->get();

        $taller_evidencia = EvidenciaTaller::where('taller_solicitud_id', $solicitud->id)->first();
        $pago_taller = TallerPagoFinanzas::where('taller_solicitud_id', $solicitud->id)->first();
        // dd($taller_evidencia);
        return view('taller.responsable-mantenimiento-ver', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver', 'taller', 'servicios_asignados', 'documentos_solicitud', 'taller_op','taller_evidencia', 'pago_taller'));
    }
}