<?php

namespace App\Http\Controllers\Taller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Taller\TallerTipoSolicitud;
use App\Models\Taller\ServicioTaller;
use App\Models\Taller\TipoDocumentoTaller;
use App\Models\Taller\Taller;
use App\Models\Taller\DocumentoTaller;
use App\Models\Taller\TallerServicioAsignado;
use App\Models\Taller\EvaluacionTaller;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use Carbon\Carbon;

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
use App\Models\Taller\TallerSolicitudEstado;
use App\Models\Taller\TallerSolicitudTipoDocumento;
use App\Models\Taller\TallerSolicitudDocumento;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Taller\TallerAsignadoSolicitud;
use App\Models\Taller\EvidenciaTaller;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class InventarioTallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inventariotaller()
    {
		$talleres =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 1)
            ->get();

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        	->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        	->where('municipio.id_status_delete', 1)
        	->get();
        // dd($talleres);
    	return view('taller.inventario-talleres.catalogo-talleres', compact('talleres', 'estados', 'municipios'));
    }

    public function invtallerdatatable(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Taller::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Taller::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        $records = Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                        ->where('taller.id_status_delete', 1)
                        ->where('taller.nombre', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }


            if($columna['data']=='id_estado'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                        ->where('taller.id_status_delete', 1)
                        ->where('taller.estado_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_municipio'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","taller.estado_id")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
                        ->where('taller.id_status_delete', 1)
                        ->where('taller.municipio_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

        }

        if($valor == "No"){
            $records = Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro="";
        foreach($records as $record){

            $data_arr[] = array(
                "id" => $record->id,
                "alias" => $record->alias,
                "direccion" =>$record->direccion,
                "tel_local" => $record->tel_local,
                "correo" => $record->correo,
                "id_municipio" => $record->municipio_nombre,
                "id_estado" => $record->estado_nombre,
                "permisos" => $permiso_array,
                'acciones'=>null,
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

    public function creartaller()
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        	->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        	->where('municipio.id_status_delete', 1)
        	->get();
        $servicios = ServicioTaller::where('id_status_delete', 1)->get();
        // ;
        $documentos = TipoDocumentoTaller::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $usuarios_taller = User::where('id_status_delete',1)->where('tipo_usuario_id',2)->where('op_taller',0)->get(); 
        // dd($usuarios_taller);

    	return view('taller.inventario-talleres.crear-tallerer', compact('estados', 'municipios', 'servicios', 'cadenaTipoDocumento', 'usuarios_taller'));    	
    }

    public function guardartaller(Request $request)
    {

        $data_user = [
            'op_taller' =>1,
        ];
        User::where('id', $request->user_taller)->update($data_user);

        $data = [
            'user_taller' =>$request->user_taller,
        	'users_id' =>auth()->user()->id,
            'nombre' => $request->nombre,
            'alias' => $request->alias,
            'direccion' => $request->direccion,
            'codigo_postal' => $request->codigo_postal,
            'referencia' => $request->referencia,
            'tel_local' => $request->tel_local,
            'tel_celular' => $request->tel_celular,
            'correo' => $request->correo,
            'municipio_id' => $request->id_municipio,
            'estado_id' => $request->id_estado,
            'coordenadas'=> $request->coordenadas,
            'id_status_delete' => 1,
                'rfc' => $request->rfc,
                'colonia' => $request->colonia,
                'tel_tres' => $request->tel_tres,
                'nombre_resp' => $request->nombre_resp,
                'observaciones' => $request->observaciones,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];

        $taller_id = Taller::insertGetId($data);

        if($request->servicio != null){
            foreach ($request->servicio as $key => $value) {
                $data = [
                    'servicio_id' => $value,
                    'taller_id' => $taller_id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id,
                ];
                TallerServicioAsignado::insert($data);
            }           
        }


        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('taller/'.$taller_id, $archivo, $archivoNombre);
                $data = [
                    'taller_id' => $taller_id,
                    'taller_tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                DocumentoTaller::insert($data);
            }
        }

        session()->flash('success', 'El taller se añadió correctamente');
        return redirect()->route('invtaller.inventariotaller');
    }

    public function editartaller($id_taller)
    {
    	$taller_info = Taller::where('id', $id_taller)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        	->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        	->where('municipio.id_status_delete', 1)
        	->get();
        $servicios = ServicioTaller::where('id_status_delete', 1)->get();
        // ;
        $documentos = TipoDocumentoTaller::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $documento_taller = DocumentoTaller::where('taller_id',$id_taller)->get();

        $servicios_asignados = TallerServicioAsignado::where('taller_id',$id_taller)->get();
        // dd($servicios_asignados);

        $evaluaciones = EvaluacionTaller::where('taller_id',$id_taller)->get();

        $usuarios_taller = User::where('id_status_delete',1)->where('tipo_usuario_id',2)->where('op_taller',0)->get(); 

    	return view('taller.inventario-talleres.editar-taller', compact('estados', 'municipios', 'servicios', 'cadenaTipoDocumento', 'taller_info', 'id_taller', 'documento_taller', 'servicios_asignados', 'evaluaciones', 'usuarios_taller'));  
    }

    public function modificartaller(Request $request)
    {

        $data_user = [
            'op_taller' =>1,
        ];
        User::where('id', $request->user_taller)->update($data_user);

        $data = [
            'user_taller' =>$request->user_taller,
        	'users_id' =>auth()->user()->id,
            'nombre' => $request->nombre,
            'alias' => $request->alias,
            'direccion' => $request->direccion,
            'codigo_postal' => $request->codigo_postal,
            'referencia' => $request->referencia,
            'tel_local' => $request->tel_local,
            'tel_celular' => $request->tel_celular,
            'correo' => $request->correo,
            'municipio_id' => $request->id_municipio,
            'estado_id' => $request->id_estado,
            'coordenadas'=> $request->coordenadas,
            'id_status_delete' => 1,
                'rfc' => $request->rfc,
                'colonia' => $request->colonia,
                'tel_tres' => $request->tel_tres,
                'nombre_resp' => $request->nombre_resp,
                'observaciones' => $request->observaciones,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Taller::where('id', $request->id_taller)->update($data);

        TallerServicioAsignado::where('taller_id',  $request->id_taller)->delete();
        foreach ($request->servicio as $key => $value) {
            $data = [
                'servicio_id' => $value,
                'taller_id' => $request->id_taller,
            	'created_at' =>date('Y-m-d H:i:s'),
            	'updated_at' =>date('Y-m-d H:i:s'),
            	'iduserCreated' =>auth()->user()->id,
            	'iduserUpdated' =>auth()->user()->id,
            ];
            TallerServicioAsignado::insert($data);
        }

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('taller/'.$request->id_taller, $archivo, $archivoNombre);
                $data = [
                    'taller_id' => $request->id_taller,
                    'taller_tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                DocumentoTaller::insert($data);
            }
        }


        session()->flash('success', 'El taller se modifico correctamente');
        return redirect()->route('invtaller.inventariotaller'); 	
    }

    public function eliminardocumentotaller(Request $request)
    {
        $doc = DocumentoTaller::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('taller/'.$doc->taller_id.'/'.$doc->documento);
            DocumentoTaller::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function desactivarintaller(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo' => $request->motivo,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Taller::where('id', $request->id)->update($data);

        session()->flash('success', 'El taller se desactivo correctamente');
        return redirect()->route('invtaller.inventariotaller');
    }

    public function inventariotallerinactivo()
    {
        $talleres =  Taller::select('taller.id', 'taller.alias', 'taller.nombre', 'taller.direccion', 'taller.tel_local', 'taller.tel_celular', 'taller.correo', 'es.estado_nombre', 'mu.municipio_nombre', 'taller.motivo')
            ->leftjoin("estado as es","es.id_estado","taller.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "taller.municipio_id")
            ->where('taller.id_status_delete', 2)
            ->get();

        return view('taller.inventario-talleres.catalogo-talleres-inactivos', compact('talleres'));        
    }

    public function activarintaller(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Taller::where('id', $request->id)->update($data);

        session()->flash('success', 'El taller se activo correctamente');
        return redirect()->route('invtaller.inventariotallerinactivo');        
    }

    public function evaluaciontaller( $taller, $id)
    {
        // dd($taller);
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

        $evaluacion_taller= EvaluacionTaller::where('taller_solicitud_id', $solicitud->id)->first();
        // dd($evaluacion_taller);
        return view('taller.inventario-talleres.evaluacion-taller',compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver', 'taller', 'servicios_asignados', 'documentos_solicitud', 'evaluacion_taller'));  
    }

    public function vertaller($id_taller)
    {
        $taller_info = Taller::where('id', $id_taller)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();
        $servicios = ServicioTaller::where('id_status_delete', 1)->get();
        // ;
        $documentos = TipoDocumentoTaller::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $documento_taller = DocumentoTaller::where('taller_id',$id_taller)->get();

        $servicios_asignados = TallerServicioAsignado::where('taller_id',$id_taller)->get();
        // dd($servicios_asignados);

        $evaluaciones = EvaluacionTaller::where('taller_id',$id_taller)->get();

        $usuarios_taller = User::where('id_status_delete',1)->where('tipo_usuario_id',2)->where('op_taller',0)->get(); 

        return view('taller.inventario-talleres.ver-taller', compact('estados', 'municipios', 'servicios', 'cadenaTipoDocumento', 'taller_info', 'id_taller', 'documento_taller', 'servicios_asignados', 'evaluaciones', 'usuarios_taller'));
    }

}