<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Potencia;

class PotenciaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadopotencia()
    {
    	$potencia = Potencia::where('id_status_delete', 1)->get();

    	return view('segmentos.potencia.catalogo-potencia', compact('potencia'));
    }

    public function potenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Potencia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Potencia::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Potencia::select('segmento_potencia.id', 'segmento_potencia.potencia', 'segmento_potencia.id_status_delete')
            ->where('segmento_potencia.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_potencia.potencia", '=' , $valor);
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
                "nombre" => $record->potencia,
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

    public function guardarpotencia(Request $request)
    {
        $data = [
            'potencia' => $request->potencia,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Potencia::insert($data);

        session()->flash('success', 'La potencia se creo correctamente');
    	return redirect()->route('potencia.catalogopotencia');
    }

    public function editarpotencia(Request $request)
    {
        $data = [
            'potencia' => $request->potencia,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Potencia::where('id', $request->id_potencia)->update($data);

        session()->flash('success', 'La potencia se modifico correctamente');
    	return redirect()->route('potencia.catalogopotencia');
    }

    public function desactivarpotencia(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Potencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La potencia se desactivo correctamente');
    	return redirect()->route('potencia.catalogopotencia');
    }

    public function catalogopotenciainactivos()
    {
    	$potencia = Potencia::where('id_status_delete', 2)->get();

    	return view('segmentos.potencia.catalogo-potencia-inactivos', compact('potencia'));	
    }

    public function activarpotencia(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Potencia::where('id', $request->id)->update($data);

        session()->flash('success', 'La potencia se activo correctamente');
    	return redirect()->route('potencia.catalogopotenciainactivos');    	
    }


}