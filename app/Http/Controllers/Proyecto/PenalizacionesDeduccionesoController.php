<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\PenalizacionesDeducciones;

class PenalizacionesDeduccionesoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadopenalizaciones()
    {
    	$penalizaciones = PenalizacionesDeducciones::where('id_status_delete', 1)->get();

    	return view('proyectos.penalizacionesydeducciones.listado-penalizaciones', compact('penalizaciones'));
    }

    public function penalizaciondeducciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = PenalizacionesDeducciones::select('count(*) as allcount')->count();
        $totalRecordswithFilter = PenalizacionesDeducciones::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = PenalizacionesDeducciones::select('proyecto_penalizaciones.id', 'proyecto_penalizaciones.penalizacion_deduccion', 'proyecto_penalizaciones.id_status_delete')
            ->where('proyecto_penalizaciones.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("proyecto_penalizaciones.penalizacion_deduccion", '=' , $valor);
                }
            }
        }

        if($valor == "No"){
            $records= $records->get();
        }else{
            $records = $records->get();
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);          
        }

        $data_arr = array();
        $pro="";
        foreach($records as $record){

            $data_arr[] = array(
                "id" => $record->id,
                "nombre" => $record->penalizacion_deduccion,
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

    public function guardarpenalizacion(Request $request)
    {
        $data = [
            'penalizacion_deduccion' => $request->penalizacion_deduccion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        PenalizacionesDeducciones::insert($data);

        session()->flash('success', 'La penalización o deducción se creo correctamente');
    	return redirect()->route('penalizaciones.listadopenalizaciones');
    }

    public function editarpenalizacion(Request $request)
    {
        $data = [
            'penalizacion_deduccion' => $request->penalizacion_deduccion,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        PenalizacionesDeducciones::where('id', $request->id_penalizacion)->update($data);

        session()->flash('success', 'La penalización o deducción se modifico correctamente');
    	return redirect()->route('penalizaciones.listadopenalizaciones'); 
    }

    public function eliminarpenalizacion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	PenalizacionesDeducciones::where('id', $request->id)->update($data);

        session()->flash('success', 'La penalización o deducción se desctivo correctamente');
    	return redirect()->route('penalizaciones.listadopenalizaciones');
    }

    public function catalogopenalizacionesinactivos()
    {
    	$penalizaciones = PenalizacionesDeducciones::where('id_status_delete', 2)->get();

    	return view('proyectos.penalizacionesydeducciones.listado-penalizaciones-inactivas', compact('penalizaciones')); 	
    }

    public function activarpenalizacion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	PenalizacionesDeducciones::where('id', $request->id)->update($data);

        session()->flash('success', 'La penalización o deducción se activo correctamente');
    	return redirect()->route('penalizaciones.penalizacionesinactivas');
    }

}