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
use App\Models\Unidad\TramiteCambioPropietarioRequisito;
use App\Models\Unidad\TramiteCambioPropietarioEvidencia;

class TramiteCambioPropietarioController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listadocambiopro()
    {
		$verificacionrequisito = TramiteCambioPropietarioRequisito::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.cambiopropietario.cambiopropietario-requisitos', compact('verificacionrequisito'));
    }

    public function cambioproreqdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteCambioPropietarioRequisito::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteCambioPropietarioRequisito::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteCambioPropietarioRequisito::select('unidad_tramite_cambiopropietario_requisitos.id', 'unidad_tramite_cambiopropietario_requisitos.nombre_requisito', 'unidad_tramite_cambiopropietario_requisitos.id_status_delete')
            ->where('unidad_tramite_cambiopropietario_requisitos.id_status_delete', 1)
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

                    $records = TramiteCambioPropietarioRequisito::select('unidad_tramite_cambiopropietario_requisitos.id', 'unidad_tramite_cambiopropietario_requisitos.nombre_requisito', 'unidad_tramite_cambiopropietario_requisitos.id_status_delete')
                    ->where('unidad_tramite_cambiopropietario_requisitos.id_status_delete', 1)
                    ->where("unidad_tramite_cambiopropietario_requisitos.nombre_requisito", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteCambioPropietarioRequisito::select('unidad_tramite_cambiopropietario_requisitos.id', 'unidad_tramite_cambiopropietario_requisitos.nombre_requisito', 'unidad_tramite_cambiopropietario_requisitos.id_status_delete')
            ->where('unidad_tramite_cambiopropietario_requisitos.id_status_delete', 1)
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

    public function guardarreqcambioproo(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteCambioPropietarioRequisito::insert($data);

        session()->flash('success', 'El requisito del tramite se creo correctamente');
    	return redirect()->route('tcambiopro.listadocambiopro');
    }

    public function editarcambioproreq(Request $request)
    {
        $data = [
            'nombre_requisito' => $request->nombre_requisito,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteCambioPropietarioRequisito::where('id', $request->id_requisito)->update($data);

        session()->flash('success', 'El requisito del tramite se modifico correctamente');
    	return redirect()->route('tcambiopro.listadocambiopro');
    }

    public function eliminarrequisitocambio(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteCambioPropietarioRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('tcambiopro.listadocambiopro');
    }

    public function catalogorequisitocambioeliminadas()
    {
		$verificacionrequisito = TramiteCambioPropietarioRequisito::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.cambiopropietario.cambiopropietario-requisitos-inactiva', compact('verificacionrequisito'));    	
    }

    public function activarrequisitocambio(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteCambioPropietarioRequisito::where('id', $request->id)->update($data);

        session()->flash('success', 'El requisito se desactivo correctamente');
    	return redirect()->route('tcambiopro.catalogorequisitocambioeliminadas');    	
    }

    public function listadoevidenciascambio()
    {
		$verificacionrequisito = TramiteCambioPropietarioEvidencia::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.cambiopropietario.cambiopropietario-evidencias', compact('verificacionrequisito'));     	
    }

    public function cambioevidenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TramiteCambioPropietarioEvidencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TramiteCambioPropietarioEvidencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TramiteCambioPropietarioEvidencia::select('unidad_tramite_cambiopropietario_evidencia.id', 'unidad_tramite_cambiopropietario_evidencia.nombre_evidencia', 'unidad_tramite_cambiopropietario_evidencia.id_status_delete')
            ->where('unidad_tramite_cambiopropietario_evidencia.id_status_delete', 1)
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

                    $records = TramiteCambioPropietarioEvidencia::select('unidad_tramite_cambiopropietario_evidencia.id', 'unidad_tramite_cambiopropietario_evidencia.nombre_evidencia', 'unidad_tramite_cambiopropietario_evidencia.id_status_delete')
                    ->where('unidad_tramite_cambiopropietario_evidencia.id_status_delete', 1)
                    ->where("unidad_tramite_cambiopropietario_evidencia.nombre_evidencia", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TramiteCambioPropietarioEvidencia::select('unidad_tramite_cambiopropietario_evidencia.id', 'unidad_tramite_cambiopropietario_evidencia.nombre_evidencia', 'unidad_tramite_cambiopropietario_evidencia.id_status_delete')
            ->where('unidad_tramite_cambiopropietario_evidencia.id_status_delete', 1)
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

    public function guardarevidencvcambio(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TramiteCambioPropietarioEvidencia::insert($data);

        session()->flash('success', 'La evidencia del tramite se creo correctamente');
    	return redirect()->route('tcambiopro.listadoevidenciascambio');    	
    }

    public function editarevcambiopro(Request $request)
    {
        $data = [
            'nombre_evidencia' => $request->nombre_evidencia,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TramiteCambioPropietarioEvidencia::where('id', $request->id_evidencia)->update($data);

        session()->flash('success', 'La evidencia del tramite se modifico correctamente');
    	return redirect()->route('tcambiopro.listadoevidenciascambio'); 
    }

    public function eliminarevidenciacambiop(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteCambioPropietarioEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se desactivo correctamente');
    	return redirect()->route('tcambiopro.listadoevidenciascambio');
    }

    public function catalogoevidenciacambiopeliminadas()
    {
		$verificacionrequisito = TramiteCambioPropietarioEvidencia::where('id_status_delete', 2)->get();

    	return view('unidades.tramitesvehiculares.cambiopropietario.cambiopropietario-evidencias-inactivas', compact('verificacionrequisito'));     	
    }

    public function activarevidenciacambiopro(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TramiteCambioPropietarioEvidencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La evidencia se activo correctamente');
    	return redirect()->route('tcambiopro.catalogoevidenciacambiopeliminadas');
    }

}