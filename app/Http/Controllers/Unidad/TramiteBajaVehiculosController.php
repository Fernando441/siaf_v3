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
use App\Models\Unidad\TramiteBajaVehiculoRequisito;
use App\Models\Unidad\TramiteBajaVehiculoEvidencia;

class TramiteBajaVehiculosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadobajaventa()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.bajavehiculo-venta-requisitos', compact('aseguramientorequisito'));
    }

    public function bajaventareqdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteBajaVehiculoRequisito::select('unidad_tramite_bajavehiculo_requisitos.id', 'unidad_tramite_bajavehiculo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_requisitos.id_status_delete', 1)
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

                    $records = TramiteBajaVehiculoRequisito::select('unidad_tramite_bajavehiculo_requisitos.id', 'unidad_tramite_bajavehiculo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_requisitos.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoRequisito::select('unidad_tramite_bajavehiculo_requisitos.id', 'unidad_tramite_bajavehiculo_requisitos.nombre_requisito', 'unidad_tramite_bajavehiculo_requisitos.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_requisitos.id_status_delete', 1)
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

    public function guardarreqbajaventa(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('bajav.listadobajaventa');
    }

    public function editarbajaventareq(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('bajav.listadobajaventa');
    }

    public function eliminarrequisitobajaventa(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajav.listadobajaventa');    	
    }

    public function catalogorequisitobajaveliminadas()
    {
		$aseguramientorequisito = TramiteBajaVehiculoRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.bajavehiculo-venta-requisitos-inactivos', compact('aseguramientorequisito'));  	
    }

    public function activarrequisitobajav(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('bajav.catalogorequisitobajaveliminadas');
    }

    public function listadoevidenciabajaventa()
    {
		$aseguramientorequisito = TramiteBajaVehiculoEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.bajavehiculo-venta-evidencia', compact('aseguramientorequisito'));   	
    }

    public function bajavevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteBajaVehiculoEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteBajaVehiculoEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteBajaVehiculoEvidencia::select('unidad_tramite_bajavehiculo_evidencia.id', 'unidad_tramite_bajavehiculo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_evidencia.id_status_delete', 1)
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

                    $records = TramiteBajaVehiculoEvidencia::select('unidad_tramite_bajavehiculo_evidencia.id', 'unidad_tramite_bajavehiculo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_evidencia.id_status_delete')
                    ->where('unidad_tramite_bajavehiculo_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_bajavehiculo_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteBajaVehiculoEvidencia::select('unidad_tramite_bajavehiculo_evidencia.id', 'unidad_tramite_bajavehiculo_evidencia.nombre_evidencia', 'unidad_tramite_bajavehiculo_evidencia.id_status_delete')
            ->where('unidad_tramite_bajavehiculo_evidencia.id_status_delete', 1)
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

    public function guardarevidenciabajav(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteBajaVehiculoEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('bajav.listadoevidenciabajaventa');
    }

    public function editarevbajaventa(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteBajaVehiculoEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('bajav.listadoevidenciabajaventa');
    }

    public function eliminarevidenciabajaventa(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('bajav.listadoevidenciabajaventa');
    }

    public function catalogoevidenciabveliminadas()
    {
		$aseguramientorequisito = TramiteBajaVehiculoEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.bajavehiculo.bajavehiculo-venta-evidencia-inactiva', compact('aseguramientorequisito'));     
    }

    public function activarevidenciabajaventa(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteBajaVehiculoEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('bajav.catalogoevidenciabveliminadas');
    }

}