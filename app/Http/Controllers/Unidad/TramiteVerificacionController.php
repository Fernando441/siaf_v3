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
use App\Models\Unidad\TramiteVerificacionRequisito;
use App\Models\Unidad\TramiteVerificacionEvidencia;

class TramiteVerificacionController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoverificacion()
    {
		$verificacionrequisito = TramiteVerificacionRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.verificacion.verificacion-requisitos', compact('verificacionrequisito'));
    }

    public function verireqdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteVerificacionRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteVerificacionRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteVerificacionRequisito::select('unidad_tramite_verificacion_requisitos.id', 'unidad_tramite_verificacion_requisitos.nombre_requisito', 'unidad_tramite_verificacion_requisitos.id_status_delete')
            ->where('unidad_tramite_verificacion_requisitos.id_status_delete', 1)
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

                    $records = TramiteVerificacionRequisito::select('unidad_tramite_verificacion_requisitos.id', 'unidad_tramite_verificacion_requisitos.nombre_requisito', 'unidad_tramite_verificacion_requisitos.id_status_delete')
                    ->where('unidad_tramite_verificacion_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_verificacion_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteVerificacionRequisito::select('unidad_tramite_verificacion_requisitos.id', 'unidad_tramite_verificacion_requisitos.nombre_requisito', 'unidad_tramite_verificacion_requisitos.id_status_delete')
            ->where('unidad_tramite_verificacion_requisitos.id_status_delete', 1)
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

    public function guardarreqver(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteVerificacionRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('tverificacion.listadoverificacion');
    }

    public function editarverificacionreq(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteVerificacionRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('tverificacion.listadoverificacion');
    }

    public function eliminarrequisitover(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteVerificacionRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('tverificacion.listadoverificacion');
    }

    public function catalogorequisitovereliminadas()
    {
		$verificacionrequisito = TramiteVerificacionRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.verificacion.verificacion-requisitos-inactivos', compact('verificacionrequisito'));    	
    }

    public function activarrequisitover(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteVerificacionRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('tverificacion.catalogorequisitovereliminadas'); 
    }

    public function listadoevidenciastver()
    {
		$verificacionrequisito = TramiteVerificacionEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.verificacion.verificacion-evidencia', compact('verificacionrequisito'));        	
    }

    public function verevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteVerificacionEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteVerificacionEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteVerificacionEvidencia::select('unidad_tramite_verificacion_evidencia.id', 'unidad_tramite_verificacion_evidencia.nombre_evidencia', 'unidad_tramite_verificacion_evidencia.id_status_delete')
            ->where('unidad_tramite_verificacion_evidencia.id_status_delete', 1)
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

                    $records = TramiteVerificacionEvidencia::select('unidad_tramite_verificacion_evidencia.id', 'unidad_tramite_verificacion_evidencia.nombre_evidencia', 'unidad_tramite_verificacion_evidencia.id_status_delete')
                    ->where('unidad_tramite_verificacion_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_verificacion_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteVerificacionEvidencia::select('unidad_tramite_verificacion_evidencia.id', 'unidad_tramite_verificacion_evidencia.nombre_evidencia', 'unidad_tramite_verificacion_evidencia.id_status_delete')
            ->where('unidad_tramite_verificacion_evidencia.id_status_delete', 1)
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

    public function guardarevidenciver(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteVerificacionEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('tverificacion.listadoevidenciastver');
    }

    public function editarevver(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteVerificacionEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('tverificacion.listadoevidenciastver'); 
    }

    public function eliminarevidenciatver(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteVerificacionEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('tverificacion.listadoevidenciastver'); 
    }

    public function catalogoevidenciavereliminadas()
    {
		$verificacionrequisito = TramiteVerificacionEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.verificacion.verificacion-evidencia-inactiva', compact('verificacionrequisito'));     	
    }

    public function activarevidenciaver(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteVerificacionEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('tverificacion.catalogoevidenciavereliminadas');
    }

}