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
use App\Models\Unidad\TramiteEmplacamientoRequisito;
use App\Models\Unidad\TramiteEmplacamientoEvidencia;

class TramiteemplacamientoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoemplacamiento()
    {
		$emplacamientorequisito = TramiteEmplacamientoRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.emplacamiento.emplacamiento-requisitos', compact('emplacamientorequisito'));
    }

    public function emprequisitodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteEmplacamientoRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteEmplacamientoRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteEmplacamientoRequisito::select('unidad_tramite_emplacamiento_requisitos.id', 'unidad_tramite_emplacamiento_requisitos.nombre_requisito', 'unidad_tramite_emplacamiento_requisitos.id_status_delete')
            ->where('unidad_tramite_emplacamiento_requisitos.id_status_delete', 1)
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

                    $records = TramiteEmplacamientoRequisito::select('unidad_tramite_emplacamiento_requisitos.id', 'unidad_tramite_emplacamiento_requisitos.nombre_requisito', 'unidad_tramite_emplacamiento_requisitos.id_status_delete')
                    ->where('unidad_tramite_emplacamiento_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_emplacamiento_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteEmplacamientoRequisito::select('unidad_tramite_emplacamiento_requisitos.id', 'unidad_tramite_emplacamiento_requisitos.nombre_requisito', 'unidad_tramite_emplacamiento_requisitos.id_status_delete')
            ->where('unidad_tramite_emplacamiento_requisitos.id_status_delete', 1)
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

    public function guardarrequisito(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteEmplacamientoRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('templacamiento.listadoemplacamiento');
    }

    public function editarrequisitoemp(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteEmplacamientoRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('templacamiento.listadoemplacamiento');
    }

    public function eliminarrequisitoemp(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteEmplacamientoRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('templacamiento.listadoemplacamiento');
    }

    public function catalogorequisitoempeliminadas()
    {
		$emplacamientorequisito = TramiteEmplacamientoRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.emplacamiento.emplacamiento-requisitos-inactivos', compact('emplacamientorequisito'));    	
    }

    public function activarrequisitoemp(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteEmplacamientoRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se activo correctamente');
    	return redirect()->route('templacamiento.catalogorequisitoempeliminadas');    	
    }

    //  EVIDENCIAS DEL TRAMITE EMPLACAMIENTO

    public function listadoevidenciasemp()
    {
		$emplacamientoevidencia = TramiteEmplacamientoEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.emplacamiento.emplacamiento-evidencia', compact('emplacamientoevidencia'));    	
    }

    public function empevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteEmplacamientoEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteEmplacamientoEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteEmplacamientoEvidencia::select('unidad_tramite_emplacamiento_evidencia.id', 'unidad_tramite_emplacamiento_evidencia.nombre_evidencia', 'unidad_tramite_emplacamiento_evidencia.id_status_delete')
            ->where('unidad_tramite_emplacamiento_evidencia.id_status_delete', 1)
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

                    $records = TramiteEmplacamientoEvidencia::select('unidad_tramite_emplacamiento_evidencia.id', 'unidad_tramite_emplacamiento_evidencia.nombre_evidencia', 'unidad_tramite_emplacamiento_evidencia.id_status_delete')
                    ->where('unidad_tramite_emplacamiento_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_emplacamiento_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteEmplacamientoEvidencia::select('unidad_tramite_emplacamiento_evidencia.id', 'unidad_tramite_emplacamiento_evidencia.nombre_evidencia', 'unidad_tramite_emplacamiento_evidencia.id_status_delete')
            ->where('unidad_tramite_emplacamiento_evidencia.id_status_delete', 1)
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

    public function guardarevidencia(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteEmplacamientoEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('templacamiento.listadoevidenciasemp');    	
    }

    public function editarevidenciaemp(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteEmplacamientoEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('templacamiento.listadoevidenciasemp');       	
    }

    public function eliminarevidenciaemp(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteEmplacamientoEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('templacamiento.listadoevidenciasemp');    	
    }

    public function catalogoevidenciaempeliminadas()
    {
		$emplacamientoevidencia = TramiteEmplacamientoEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.emplacamiento.emplacamiento-evidencia-inactivas', compact('emplacamientoevidencia'));        	
    }

    public function activarevidenciaemp(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteEmplacamientoEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('templacamiento.catalogoevidenciaempeliminadas');    	
    }

}