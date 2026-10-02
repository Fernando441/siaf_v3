<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Gps;

class GpsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadogps()
    {
    	$gps = Gps::where('id_status_delete', 1)->get();

    	return view('segmentos.gps.catalogo-gps', compact('gps'));
    }

    public function gpsdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Gps::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Gps::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Gps::select('segmento_gps.id', 'segmento_gps.gps', 'segmento_gps.id_status_delete')
            ->where('segmento_gps.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_gps.gps", '=' , $valor);
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
                "nombre" => $record->gps,
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

    public function guardargps(Request $request)
    {
        $data = [
            'gps' => $request->gps,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Gps::insert($data);

        session()->flash('success', 'El nombre del gps se creo correctamente');
    	return redirect()->route('gps.catalogogps');
    }

    public function editargps(Request $request)
    {
        $data = [
            'gps' => $request->gps,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Gps::where('id', $request->id_gps)->update($data);

        session()->flash('success', 'El nombre del gps se modifico correctamente');
    	return redirect()->route('gps.catalogogps');
    }

    public function desactivargps(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Gps::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del gps se desactivo correctamente');
    	return redirect()->route('gps.catalogogps');
    }

    public function catalogogpsinactivos()
    {
    	$gps = Gps::where('id_status_delete', 2)->get();

    	return view('segmentos.gps.catalogo-gps-inactivo', compact('gps'));   	
    }

    public function activargps(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Gps::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del gps se activo correctamente');
    	return redirect()->route('gps.catalogogpsinactivos');
    }

}