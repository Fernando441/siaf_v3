<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Blindaje;

class BlindajeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoblindaje()
    {
    	$blindaje = Blindaje::where('id_status_delete', 1)->get();

    	return view('segmentos.blindaje.catalogo-blindaje', compact('blindaje'));
    }

    public function blindajedatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Blindaje::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Blindaje::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Blindaje::select('segmento_blindaje.id', 'segmento_blindaje.blindaje', 'segmento_blindaje.id_status_delete')
            ->where('segmento_blindaje.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_blindaje.blindaje", '=' , $valor);
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
                "nombre" => $record->blindaje,
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

    public function guardarblindaje(Request $request)
    {
        $data = [
            'blindaje' => $request->blindaje,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Blindaje::insert($data);

        session()->flash('success', 'El nombre del blindaje se creo correctamente');
    	return redirect()->route('blindaje.catalogoblindaje');
    }

    public function editarblindaje(Request $request)
    {
        $data = [
            'blindaje' => $request->blindaje,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Blindaje::where('id', $request->id_blindaje)->update($data);

        session()->flash('success', 'El nombre del blindaje se modifico correctamente');
    	return redirect()->route('blindaje.catalogoblindaje');
    }

    public function desactivarblindaje(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Blindaje::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del blindaje se desactivo correctamente');
    	return redirect()->route('blindaje.catalogoblindaje');
    }

    public function catalogoblindajeinactivos()
    {
    	$blindaje = Blindaje::where('id_status_delete', 2)->get();

    	return view('segmentos.blindaje.catalogo-blindaje-inactivos', compact('blindaje'));   	
    }

    public function activarblindaje(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Blindaje::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del blindaje se activo correctamente');
    	return redirect()->route('blindaje.catalogoblindajeinactivos');    	
    }


}