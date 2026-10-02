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
use App\Models\Unidad\TramiteBajaVehiculoRoboRequisito;
use App\Models\Unidad\TramiteBajaVehiculoRoboEvidencia;

class TramiteBajaVehiculosRoboController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadobajarobo()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRoboRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.robo.bajavehiculo-robo-requisitos', compact('aseguramientorequisito'));
    }

    public function bajaroboreqdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoRoboRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoRoboRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteBajaVehiculoRoboRequisito::select('unidad_tramite_bajavehiculo_robo_requisitos.id', 'unidad_tramite_bajavehiculo_robo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete', 1)
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

                    $records = TramiteBajaVehiculoRoboRequisito::select('unidad_tramite_bajavehiculo_robo_requisitos.id', 'unidad_tramite_bajavehiculo_robo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_robo_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoRoboRequisito::select('unidad_tramite_bajavehiculo_robo_requisitos.id', 'unidad_tramite_bajavehiculo_robo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_robo_requisitos.id_status_delete', 1)
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

    public function guardarreqbajarobo(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoRoboRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('bajar.listadobajarobo');
    }

    public function editarbajaroboreq(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoRoboRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('bajar.listadobajarobo');
    }

    public function eliminarrequisitobajarobo(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRoboRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajar.listadobajarobo');
    }

    public function catalogrequisitobajareliminadas()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRoboRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.robo.bajavehiculo-robo-requisitos-inactivo', compact('aseguramientorequisito'));    	
    }

    public function activarrequisitobajarobo(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRoboRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajar.catalogrequisitobajareliminadas');
    }

    public function listadoevidenciabajarobo()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.robo.bajavehiculo-robo-evidencia', compact('aseguramientorequisito'));  
    }

    public function bajaroevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoRoboEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoRoboEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteBajaVehiculoRoboEvidencia::select('unidad_tramite_bajavehiculo_robo_evidencia.id', 'unidad_tramite_bajavehiculo_robo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete', 1)
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

                    $records = TramiteBajaVehiculoRoboEvidencia::select('unidad_tramite_bajavehiculo_robo_evidencia.id', 'unidad_tramite_bajavehiculo_robo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_robo_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoRoboEvidencia::select('unidad_tramite_bajavehiculo_robo_evidencia.id', 'unidad_tramite_bajavehiculo_robo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_robo_evidencia.id_status_delete', 1)
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

    public function guardarevidenciabajarobo(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoRoboEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('bajar.listadoevidenciabajarobo');
    }

    public function editarevbajarobo(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoRoboEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('bajar.listadoevidenciabajarobo');
    }

    public function eliminarevidenciabajarobo(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRoboEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('bajar.listadoevidenciabajarobo');
    }

    public function catalogoevidenciabreliminada()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRoboEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.robo.bajavehiculo-robo-evidencia-inactiva', compact('aseguramientorequisito'));    	
    }

    public function activarevidenciabajarobo(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRoboEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('bajar.catalogoevidenciabreliminada');
    }

}