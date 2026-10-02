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


class UsuarioTallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadosolmanttl()
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


        return view('taller.usuariotaller.listado-solicitudes', compact('solicitudes', 'tipoSolicitudes', 'estados'));
    }

    public function dtmantenimientotll(Request $request)
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
                'prioridad' => null,
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

    public function versolicitudtll($id)
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
        }else{
            $taller = 0;
            $servicios_asignados = 0;
            $id_taller = 0;
        }

        $documentos_solicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $solicitud->id)->get();
        // dd($documentos_solicitud);
        return view('taller.usuariotaller.ver-solicitud-tll', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver', 'taller', 'servicios_asignados', 'documentos_solicitud'));
    }

    public function evidenciastall($id_solicitud)
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
        // dd($documentos);
        return view('taller.usuariotaller.evidencias-solicitud', compact('talleres', 'id_solicitud', 'solicitudes', 'asignado_id', 'taller', 'servicios_asignados', 'id_taller', 'documentos'));
    }


}