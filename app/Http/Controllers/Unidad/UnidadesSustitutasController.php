<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Licitacion\Licitacion;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\InventarioEntrega;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;

use App\Models\Logistica\SustitutoMotivo;
use App\Models\Logistica\SustitutoSolicitud;
use App\Models\Logistica\SustitutoEvidencia;


use App\Models\Requisicion\Requisicion;
use App\Services\BusquedaService;

class UnidadesSustitutasController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }


    public function listadounidadessustitutas()
    {

// $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
//             	'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre')
//             ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
//             ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
//             ->where('sustituto_solicitud.id_status_delete', 1)
//             ->get();

//         dd($records);

    	return view('unidades.unidadessustitutas.listado-unidades-sustitutas');
    }

    public function sustitutosdatatable(Request $request)
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
        $totalRecords = SustitutoSolicitud::select('count(*) as allcount')->count();
        $totalRecordswithFilter = SustitutoSolicitud::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
            'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id',
            'es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo','unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.created_at as datesolicitud')
            ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            ->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            ->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            ->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            ->where('sustituto_solicitud.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='motivo_id'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.created_at as datesolicitud')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
                        ->where('sustituto_solicitud.motivo_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='proyectos_id'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.created_at as datesolicitud')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
                        ->where('sustituto_solicitud.proyectos_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_estado'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.created_at as datesolicitud')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
                        ->where('sustituto_solicitud.estado_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_municipio'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo'
                    	, 'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.created_at as datesolicitud')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
                        ->where('sustituto_solicitud.municipio_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

        }

        if($valor == "No"){
            $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
            	'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo', 
            	'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus', 'sustituto_solicitud.created_at as datesolicitud')
            ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            ->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            ->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            ->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            
            ->where('sustituto_solicitud.id_status_delete', 1)
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
                "nombre_responsable" => $record->nombre_responsable,
                "fecha" => $record->datesolicitud,
                "motivo" => $record->motivo,
                "unidadbase" => $record->no_serie,
                "contrato" => $record->no_contrato,
                "estado" => $record->estado_nombre,
                "municipio" => $record->municipio_nombre,
                "estatus" => $record->estatus,
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


    public function crearsolicutud()
    {

    	return view('unidades.unidadessustitutas.crear-solicitud-unidades-sustitutas');	
    }

    public function busquedaunidadbase(Request $request)
    {

    	if($request->busqueda == 0){
    		$unidad = Unidad::where('numero_economico', $request->no_economico)->first();	
    	}

    	if($request->busqueda == 1){
    		$unidad = Unidad::where('no_serie', $request->no_serie)->first();	
    	}

    	if($request->busqueda == 2){
    		$unidad = Unidad::where('placa', $request->placa)->first();	
    	}

 
    	if($unidad == null){
	        session()->flash('warning', 'No se encontro la unidad ');
	        return redirect()->route('unidadessustitutas.crearsolicutud');
    	}else{
	        session()->flash('success', 'Información procesada');
	        return redirect()->route('unidadessustitutas.unidadbase', $unidad->id);    		
    	}


    }

    public function unidadbase($unidad_id)
    {
    	
    	$unidad = Unidad::where('id', $unidad_id)->first();
    	$fotografias = UnidadFotografia::where('unidad_id', $unidad_id)->get();
    	$active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
    	
        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        if($unidad->unidad_asignacion_id == 1){
        	$proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
	        $info_licitacion = Licitacion::select(
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
	            'tc.tipo_contratacion',
	            'licitaciones.id_licitacion_prioridad',
	            'licitaciones.contratacion'
	        )
	            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
	            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
	            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
	            ->where('licitaciones.id', $unidad->licitaciones_id)
	            ->get();

        }else{
        	$proyecto_info = 1;
        	$info_licitacion= 1;
        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();

        $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

    	return view('unidades.unidadessustitutas.crear-solicitud-unidades-sustitutas-validacion', compact('unidad', 'fotografias', 'ver', 'proyecto_info', 'info_licitacion', 'estados', 'municipios', 'sustituto'));
    }

    public function guardarsolicitud(Request $request)
    {
    	// dd($request);

        $data = [
            'fecha_hora_solicitud' => $request->fecha_solicitud ? Carbon::now():null,  
            'motivo_id' => $request->motivo,
            'descripcion_motivo' => $request->desc_motivo,
            'calle' => $request->calle,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->cp,
            'estado_id' => $request->id_estado,
            'municipio_id' => $request->id_municipio,
            'nombre_responsable' => $request->nombre_responsable,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'unidad_id_base' => $request->unidad_id_base,
            'proyectos_id' => $request->proyectos_id,
            'id_status_delete' => 1,
            'estatus' => 1,
            'op_unidad_sustituta' => 0,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_solicitud = SustitutoSolicitud::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('solicitud_sustituto/'.$id_solicitud, $archivo, $archivoNombre);
                $data = [
                    'sustituto_solicitud_id' => $id_solicitud,
                    'tipo_documento' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                ];
                SustitutoEvidencia::insert($data);
            }
        }

        session()->flash('success', 'La solicitud de sustituto se creo correctamente');
        return redirect()->route('unidadessustitutas.listadounidadessustitutas');

    }

    public function deletesolicitud(Request $request)
    {
        $doc = SustitutoEvidencia::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('solicitud_sustituto/'.$doc->sustituto_solicitud_id.'/'.$doc->documento);
            SustitutoEvidencia::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);    	
    }

    public function versolicitudsustitutos($id_solicitud)
    {	
    	$solicitud_sustituto = SustitutoSolicitud::where('id', $id_solicitud)->first();
 
		$unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
    	$fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
    	$active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
    	
        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        if($unidad->unidad_asignacion_id == 1){
        	$proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
	        $info_licitacion = Licitacion::select(
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
	            'tc.tipo_contratacion',
	            'licitaciones.id_licitacion_prioridad',
	            'licitaciones.contratacion'
	        )
	            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
	            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
	            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
	            ->where('licitaciones.id', $unidad->licitaciones_id)
	            ->get();

        }else{
        	$proyecto_info = 1;
        	$info_licitacion= 1;
        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();

        $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->where('unidad.unidad_asignacion_id', 2)
            ->where('unidad.apartado_sustituto', 0) 
            ->where('unidad.id_status_delete', 1)->get();  

		if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
		{
			$unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
	    	$fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
	    	$active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
	    	
	        if ($active_s == null) {
	                $ver_s = 0;
	        } else {
	                $ver_s = $active->id;
	        }
		}else{
			$unidad_sustituta = 0;
	    	$fotografias_sustitutas = 0;
	    	$active_s = 0;
	    	$ver_s=0;
		}  

    	return view('unidades.unidadessustitutas.ver-solicitud-sustitutos',compact('unidad', 'fotografias', 'ver', 'proyecto_info', 'info_licitacion', 'estados', 'municipios', 'sustituto', 'solicitud_sustituto', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s'));
    }

    public function editarsolicitudsustitutos($id_solicitud)
    {
    	$solicitud_sustituto = SustitutoSolicitud::where('id', $id_solicitud)->first();
 
		$unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
    	$fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
    	$active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
    	
        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        if($unidad->unidad_asignacion_id == 1){
        	$proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
	        $info_licitacion = Licitacion::select(
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
	            'tc.tipo_contratacion',
	            'licitaciones.id_licitacion_prioridad',
	            'licitaciones.contratacion'
	        )
	            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
	            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
	            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
	            ->where('licitaciones.id', $unidad->licitaciones_id)
	            ->get();

        }else{
        	$proyecto_info = 1;
        	$info_licitacion= 1;
        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();

        $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();
        $documentos = SustitutoEvidencia::where('id',$id_solicitud)->get();

    	return view('unidades.unidadessustitutas.editar-solicitud-sustitutos',compact('unidad', 'fotografias', 'ver', 'proyecto_info', 'info_licitacion', 'estados', 'municipios', 'sustituto', 'solicitud_sustituto', 'id_solicitud', 'documentos'));    	
    }

    public function updatesolicitud(Request $request)
    {

        $data = [
            'fecha_hora_solicitud' => $request->fecha_solicitud ? Carbon::now():null,  
            'motivo_id' => $request->motivo,
            'descripcion_motivo' => $request->desc_motivo,
            'calle' => $request->calle,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->cp,
            'estado_id' => $request->id_estado,
            'municipio_id' => $request->id_municipio,
            'nombre_responsable' => $request->nombre_responsable,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'unidad_id_base' => $request->unidad_id_base,
            'proyectos_id' => $request->proyectos_id,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        SustitutoSolicitud::where('id', $request->id_solicitud)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('solicitud_sustituto/'.$request->id_solicitud, $archivo, $archivoNombre);
                $data = [
                    'sustituto_solicitud_id' => $request->id_solicitud,
                    'tipo_documento' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'users_id' =>auth()->user()->id,
                ];
                SustitutoEvidencia::insert($data);
            }
        }

        session()->flash('success', 'La solicitud de sustituto se modifico correctamente');
        return redirect()->route('unidadessustitutas.listadounidadessustitutas');
    }


    public function enviarlogistica(Request $request)
    {
        $solicitud = SustitutoSolicitud::find($request->id);
        $solicitud->estatus = 2;
        $solicitud->enviada_logistica = date('Y-m-d H:i:s');
        $solicitud->env_logistica_id = Auth::user()->id;
        $solicitud->iduserUpdated = Auth::user()->id;
        $solicitud->save();

        return response()->json(['success' => 'Solicitud enviada correctamente']);  
    }


// SOLICITUD SUSTITUTOS LOGISTICA
    public function listadosustitutologistica()
    {
    	return view('unidades.unidadessustitutas.logistica.listado-solicitudes');
    }

    public function sustitutoslogisticadatatable(Request $request)
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
        $totalRecords = SustitutoSolicitud::select('count(*) as allcount')->count();
        $totalRecordswithFilter = SustitutoSolicitud::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
            'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id',
            'es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo','unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            ->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            ->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            ->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            ->where('sustituto_solicitud.id_status_delete', 1)
            ->where('sustituto_solicitud.estatus', 2)
            ->orwhere('sustituto_solicitud.estatus', 3)
            ->orwhere('sustituto_solicitud.estatus', 4)

            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='motivo_id'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
            			->where('sustituto_solicitud.estatus', 2)
            			->orwhere('sustituto_solicitud.estatus', 3)
            			->orwhere('sustituto_solicitud.estatus', 4)

                        ->where('sustituto_solicitud.motivo_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='proyectos_id'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
            			->where('sustituto_solicitud.estatus', 2)
            			->orwhere('sustituto_solicitud.estatus', 3)
            			->orwhere('sustituto_solicitud.estatus', 4)

                        ->where('sustituto_solicitud.proyectos_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_estado'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo',
                		'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
            			->where('sustituto_solicitud.estatus', 2)
            			->orwhere('sustituto_solicitud.estatus', 3)
            			->orwhere('sustituto_solicitud.estatus', 4)

                        ->where('sustituto_solicitud.estado_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_municipio'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base','sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo'
                    	, 'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            			->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            			->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            			->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            			->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            			->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            			->where('sustituto_solicitud.id_status_delete', 1)
            			->where('sustituto_solicitud.estatus', 2)
            			->orwhere('sustituto_solicitud.estatus', 3)
            			->orwhere('sustituto_solicitud.estatus', 4)

                        ->where('sustituto_solicitud.municipio_id', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

        }

        if($valor == "No"){
            $records = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
            	'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id','es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo', 
            	'unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus')
            ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            ->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            ->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            ->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            
            ->where('sustituto_solicitud.id_status_delete', 1)
            ->where('sustituto_solicitud.estatus', 2)
            ->orwhere('sustituto_solicitud.estatus', 3)
            ->orwhere('sustituto_solicitud.estatus', 4)
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
                "nombre_responsable" => $record->nombre_responsable,
                "fecha" => $record->fecha_hora_solicitud,
                "motivo" => $record->motivo,
                "unidadbase" => $record->no_serie,
                "contrato" => $record->no_contrato,
                "estado" => $record->estado_nombre,
                "municipio" => $record->municipio_nombre,
                "estatus" => $record->estatus,
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

    public function asignarsustituta($id_solicitud)
    {
    	$solicitud_sustituto = SustitutoSolicitud::where('id', $id_solicitud)->first();
 
		$unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
    	$fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
    	$active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
    	
        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }

        if($unidad->unidad_asignacion_id == 1){
        	$proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
	        $info_licitacion = Licitacion::select(
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
	            'tc.tipo_contratacion',
	            'licitaciones.id_licitacion_prioridad',
	            'licitaciones.contratacion'
	        )
	            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
	            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
	            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
	            ->where('licitaciones.id', $unidad->licitaciones_id)
	            ->get();

        }else{
        	$proyecto_info = 1;
        	$info_licitacion= 1;
        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();

        $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->where('unidad.unidad_asignacion_id', 2)
            ->where('unidad.apartado_sustituto', 0) 
            ->where('unidad.id_status_delete', 1)->get();  

		if($solicitud_sustituto->estatus == 3)
		{
			$unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
	    	$fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
	    	$active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
	    	
	        if ($active_s == null) {
	                $ver_s = 0;
	        } else {
	                $ver_s = $active->id;
	        }
		}else{
			$unidad_sustituta = 0;
	    	$fotografias_sustitutas = 0;
	    	$active_s = 0;
	    	$ver_s=0;
		}        

    	return view('unidades.unidadessustitutas.logistica.asignar-sustitutos',compact('unidad', 'fotografias', 'ver', 'proyecto_info', 'info_licitacion', 'estados', 'municipios', 'sustituto', 'solicitud_sustituto', 'ubicacion_data', 'id_solicitud', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s'));    	
    }

    public function addunidadsolicitud(Request $request)
    {

    	if(isset($request->radios)){
    		$uno = "si hay dato";

	        $data = [
	        	'unidad_id_sustituta' => $request->radios,
	        	'op_unidad_sustituta' => 1,
	        	'estatus' => 3,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserUpdated' =>auth()->user()->id,
	        ];
	        SustitutoSolicitud::where('id', $request->id_solicitud)->update($data);

	        $data_unidad = [
	        	'apartado_sustituto' => 1,
	            'updated_at' =>date('Y-m-d H:i:s'),
	            'iduserUpdated' =>auth()->user()->id,
	        ];
	        Unidad::where('id', $request->radios)->update($data_unidad);

	        session()->flash('success', 'La información se agrego correctamente');
        	return redirect()->route('unidadessustitutas.asignarsustituta', $request->id_solicitud); 
    	}else{
    		$uno = "no hay dato";
          	session()->flash('warning', 'Para continuar debes seleccionar una unidad sustituta');
        	return redirect()->route('unidadessustitutas.asignarsustituta', $request->id_solicitud); 
    	}
    	
    }

    public function deleteunidadsolicitud(Request $request)
    {

	    $data = [
	     	'unidad_id_sustituta' => null,
	     	'op_unidad_sustituta' => 0,
	     	'estatus' => 2,
	        'updated_at' =>date('Y-m-d H:i:s'),
	        'iduserUpdated' =>auth()->user()->id,
	    ];
	    SustitutoSolicitud::where('id', $request->id_solicitud)->update($data);

	    $data_unidad = [
	     	'apartado_sustituto' => 0,
	        'updated_at' =>date('Y-m-d H:i:s'),
	        'iduserUpdated' =>auth()->user()->id,
	    ];
	    Unidad::where('id', $request->id_unidad)->update($data_unidad);

	    session()->flash('success', 'La información se agrego correctamente');
     	return redirect()->route('unidadessustitutas.asignarsustituta', $request->id_solicitud); 

    }

    public function finalizarsolicitud(Request $request)
    {
	    $data = [
	     	'estatus' => 4,
	        'updated_at' =>date('Y-m-d H:i:s'),
	        'iduserUpdated' =>auth()->user()->id,
	    ];
	    SustitutoSolicitud::where('id', $request->id_solicitud)->update($data);

	    session()->flash('success', 'La solicitud finalizo correctamente');
     	return redirect()->route('unidadessustitutas.listadosustitutologistica');     	
    }



}