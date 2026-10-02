<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Puerta;

class PuertaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadopuertas()
    {
    	$puertas = Puerta::where('id_status_delete', 1)->get();

    	return view('segmentos.puertas.catalogo-puertas', compact('puertas'));
    }

    public function puertasdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Puerta::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Puerta::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Puerta::select('segmento_puerta.id', 'segmento_puerta.puertas', 'segmento_puerta.id_status_delete')
            ->where('segmento_puerta.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_puerta.puertas", '=' , $valor);
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
                "nombre" => $record->puertas,
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

    public function guardarpuertas(Request $request)
    {
        $data = [
            'puertas' => $request->puertas,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Puerta::insert($data);

        session()->flash('success', 'El número de puertas se creo correctamente');
    	return redirect()->route('puerta.catalopuertas');
    }

    public function editarpuerta(Request $request)
    {
        $data = [
            'puertas' => $request->puertas,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Puerta::where('id', $request->id_puertas)->update($data);

        session()->flash('success', 'El número de puertas se modifico correctamente');
    	return redirect()->route('puerta.catalopuertas');
    }

    public function desactivarpuerta(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Puerta::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de puertas se desactivo correctamente');
    	return redirect()->route('puerta.catalopuertas');	
    }

    public function catalogopuertainactivos(Request $request)
    {
    	$puertas = Puerta::where('id_status_delete', 2)->get();

    	return view('segmentos.puertas.catalogo-puertas-inactivas', compact('puertas'));   	
    }

    public function activarpuerta(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Puerta::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de puertas se activo correctamente');
    	return redirect()->route('puerta.catalogopuertainactivos');
    }

}