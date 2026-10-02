<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Capacidad;

class CapacidadController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadocapacidad()
    {
    	$capacidad = Capacidad::where('id_status_delete', 1)->get();

    	return view('segmentos.capacidad.catalogo-capacidad', compact('capacidad'));
    }

    public function capacidaddatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Capacidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Capacidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Capacidad::select('segmento_capacidad.id', 'segmento_capacidad.capacidad', 'segmento_capacidad.id_status_delete')
            ->where('segmento_capacidad.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_capacidad.capacidad", '=' , $valor);
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
                "nombre" => $record->capacidad,
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

    public function guardarcapacidad(Request $request)
    {
        $data = [
            'capacidad' => $request->capacidad,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Capacidad::insert($data);

        session()->flash('success', 'El nombre de la capacidad se creo correctamente');
    	return redirect()->route('capacidad.catalogocapacidad');
    }

    public function editarcapacidad(Request $request)
    {
        $data = [
            'capacidad' => $request->capacidad,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Capacidad::where('id', $request->id_capacidad)->update($data);

        session()->flash('success', 'El nombre de la capacidad se modifico correctamente');
    	return redirect()->route('capacidad.catalogocapacidad');
    }

    public function desactivarcapacidad(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Capacidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de la capacidad se desactivo correctamente');
    	return redirect()->route('capacidad.catalogocapacidad');
    }

    public function catalogocapacidadinactivos()
    {
    	$capacidad = Capacidad::where('id_status_delete', 2)->get();

    	return view('segmentos.capacidad.catalogo-capacidad-inactiva', compact('capacidad'));   	
    }

    public function activarcapacidad(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Capacidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de la capacidad se activo correctamente');
    	return redirect()->route('capacidad.catalogocapacidadinactivos');	
    }

}