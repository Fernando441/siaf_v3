<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroRequisito;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroEstatus;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroTipo;

class TramiteBajaVehiculosSiniestroController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadobajastro()
    {
		$aseguramientorequisito = TramiteBajaVehiculoSiniestroRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-requisitos', compact('aseguramientorequisito'));
    }

    public function bajastroreqdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoSiniestroRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoSiniestroRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        // Fetch records
        $records = TramiteBajaVehiculoSiniestroRequisito::select('unidad_tramite_bajavehiculo_siniestro_requisitos.id', 'unidad_tramite_bajavehiculo_siniestro_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_requisito'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = TramiteBajaVehiculoSiniestroRequisito::select('unidad_tramite_bajavehiculo_siniestro_requisitos.id', 'unidad_tramite_bajavehiculo_siniestro_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_siniestro_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoSiniestroRequisito::select('unidad_tramite_bajavehiculo_siniestro_requisitos.id', 'unidad_tramite_bajavehiculo_siniestro_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_requisitos.id_status_delete', 1)
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
                "nombre_requisito" => $record->nombre_requisito,
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

    public function guardarreqbajastro(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoSiniestroRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('bajas.listadobajastro');
    }

    public function editarbajastroreq(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoSiniestroRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('bajas.listadobajastro');
    }

    public function eliminarrequisitobajastro(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoSiniestroRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajas.listadobajastro');
    }

    public function catalogrequisitobasineliminadas()
    {
		$aseguramientorequisito = TramiteBajaVehiculoSiniestroRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-requisitos-inactivos', compact('aseguramientorequisito'));    	
    }

    public function activarrequisitobajastro(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoSiniestroRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajas.catalogrequisitobasineliminadas');
    }

    public function listadoevidenciabajastro()
    {
		$aseguramientorequisito = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-evidencia', compact('aseguramientorequisito'));   	
    }

    public function bajasinevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoSiniestroEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoSiniestroEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        // Fetch records
        $records = TramiteBajaVehiculoSiniestroEvidencia::select('unidad_tramite_bajavehiculo_siniestro_evidencia.id', 'unidad_tramite_bajavehiculo_siniestro_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_evidencia'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = TramiteBajaVehiculoSiniestroEvidencia::select('unidad_tramite_bajavehiculo_siniestro_evidencia.id', 'unidad_tramite_bajavehiculo_siniestro_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_siniestro_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoSiniestroEvidencia::select('unidad_tramite_bajavehiculo_siniestro_evidencia.id', 'unidad_tramite_bajavehiculo_siniestro_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_evidencia.id_status_delete', 1)
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
                "nombre_evidencia" => $record->nombre_evidencia,
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

    public function guardarevidenciabajasin(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoSiniestroEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('bajas.listadoevidenciabajastro');
    }

    public function editarevbajasin(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoSiniestroEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('bajas.listadoevidenciabajastro');
    }

    public function eliminarevidenciabajasin(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoSiniestroEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('bajas.listadoevidenciabajastro');
    }

    public function catalogoevidenciabsineliminada()
    {
		$aseguramientorequisito = TramiteBajaVehiculoSiniestroEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-evidencia-inactiva', compact('aseguramientorequisito'));    	
    }

    public function activarevidenciabajasin(request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoSiniestroEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('bajas.catalogoevidenciabsineliminada');
    }

    public function listadoestatusbajastro()
    {
        $aseguramientorequisito = TramiteBajaVehiculoSiniestroEstatus::where('id_status_delete', 1)->get();

        return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-estatus', compact('aseguramientorequisito'));
    }

    public function bajasinestatusdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoSiniestroEstatus::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoSiniestroEstatus::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        // Fetch records
        $records = TramiteBajaVehiculoSiniestroEstatus::select('unidad_tramite_bajavehiculo_siniestro_estatus.id', 'unidad_tramite_bajavehiculo_siniestro_estatus.nombre_estatus', 'unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_estatus'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = TramiteBajaVehiculoSiniestroEstatus::select('unidad_tramite_bajavehiculo_siniestro_estatus.id', 'unidad_tramite_bajavehiculo_siniestro_estatus.nombre_estatus', 'unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_siniestro_estatus.nombre_estatus", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoSiniestroEstatus::select('unidad_tramite_bajavehiculo_siniestro_estatus.id', 'unidad_tramite_bajavehiculo_siniestro_estatus.nombre_estatus', 'unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_siniestro_estatus.id_status_delete', 1)
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
                "nombre_estatus" => $record->nombre_estatus,
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

    public function guardarsintroest(Request $request)
    {
        $data = [
            'nombre_estatus' => $request->nombre_estatus,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoSiniestroEstatus::insert($data);

        session()->flash('success', 'El estatus se creo correctamente');
        return redirect()->route('bajasin.listadoestatusbajastro');       
    }

    public function editasintroest(Request $request)
    {
        $data = [
            'nombre_estatus' => $request->nombre_estatus,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoSiniestroEstatus::where('id', $request->id_estatus)->update($data);

        session()->flash('success', 'El estatus se modifico correctamente');
        return redirect()->route('bajasin.listadoestatusbajastro');         
    }

    public function desactivasintroest(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        TramiteBajaVehiculoSiniestroEstatus::where('id', $request->id)->update($data);

        session()->flash('success', 'El estatus se desactivo correctamente');
        return redirect()->route('bajasin.listadoestatusbajastro');      
    }

    public function listadoestatussinestinactivo(Request $request)
    {
        $aseguramientorequisito = TramiteBajaVehiculoSiniestroEstatus::where('id_status_delete', 2)->get();

        return view('unidades.tramitesvehiculares.bajavehiculo.siniestro.bajavehiculo-siniestro-estatus-inactivos', compact('aseguramientorequisito'));       
    }

    public function activasintroest(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        TramiteBajaVehiculoSiniestroEstatus::where('id', $request->id)->update($data);

        session()->flash('success', 'El estatus se activo correctamente');
        return redirect()->route('bajasin.listadoestatussinestinactivo');        
    }


}