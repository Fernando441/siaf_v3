<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\FuenteProyecto;

class FuenteProyectoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadofuenteproyecto()
    {
    	$fuentes = FuenteProyecto::where('id_status_delete', 1)->get();

    	return view('proyectos.fuenteproyecto.listado-fuenteproyecto', compact('fuentes'));
    }

    public function fuentecontratodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = FuenteProyecto::select('count(*) as allcount')->count();
        $totalRecordswithFilter = FuenteProyecto::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = FuenteProyecto::select('fuente_proyecto.id', 'fuente_proyecto.fuente_proyecto', 'fuente_proyecto.id_status_delete')
            ->where('fuente_proyecto.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("fuente_proyecto.fuente_proyecto", '=' , $valor);
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
                "nombre" => $record->fuente_proyecto,
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

    public function guardarfuente(Request $request)
    {
        $data = [
            'fuente_proyecto' => $request->fuente_proyecto,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        FuenteProyecto::insert($data);

        session()->flash('success', 'La fuente de proyecto se creo correctamente');
    	return redirect()->route('fuenteproyecto.listadofuenteproyecto');    	
    }

    public function editarfuente(Request $request)
    {
        $data = [
            'fuente_proyecto' => $request->fuente_proyecto,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        FuenteProyecto::where('id', $request->id_fuente)->update($data);

        session()->flash('success', 'La fuente de proyecto se modifico correctamente');
    	return redirect()->route('fuenteproyecto.listadofuenteproyecto');    
    }

    public function eliminarfuente(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	FuenteProyecto::where('id', $request->id)->update($data);

        session()->flash('success', 'La fuente de proyecto se desctivo correctamente');
    	return redirect()->route('fuenteproyecto.listadofuenteproyecto');   
    }

    public function catalogofuntesinactivos()
    {
    	$fuentes = FuenteProyecto::where('id_status_delete', 2)->get();

    	return view('proyectos.fuenteproyecto.listado-fuenteproyecto-inactivas', compact('fuentes'));    	
    }

    public function activarfuente(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	FuenteProyecto::where('id', $request->id)->update($data);

        session()->flash('success', 'La fuente de proyecto se activo correctamente');
    	return redirect()->route('fuenteproyecto.fuentesinactivas');
    }

}