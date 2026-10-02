<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Carroceria;

class CarroceriaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadocarroceria()
    {
    	$carroceria = Carroceria::where('id_status_delete', 1)->get();

    	return view('segmentos.carroceria.catalogo-carroceria', compact('carroceria'));
    }

    public function carroceriadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Carroceria::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Carroceria::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Carroceria::select('segmento_carroceria.id', 'segmento_carroceria.carroceria', 'segmento_carroceria.id_status_delete')
            ->where('segmento_carroceria.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_carroceria.carroceria", '=' , $valor);
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
                "nombre" => $record->carroceria,
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

    public function guardarcarroceria(Request $request)
    {
        $data = [
            'carroceria' => $request->carroceria,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Carroceria::insert($data);

        session()->flash('success', 'La carroceria se creo correctamente');
    	return redirect()->route('carroceria.catalogocarroceria');
    }

    public function editarcarroceria(Request $request)
    {
        $data = [
            'carroceria' => $request->carroceria,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Carroceria::where('id', $request->id_carroceria)->update($data);

        session()->flash('success', 'La carroceria se modifico correctamente');
    	return redirect()->route('carroceria.catalogocarroceria');
    }

    public function desactivarcarroceria(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Carroceria::where('id', $request->id)->update($data);

        session()->flash('success', 'La carroceria se desactivo correctamente');
    	return redirect()->route('carroceria.catalogocarroceria');
    }

    public function catalogocarroceriainactivas()
    {
    	$carroceria = Carroceria::where('id_status_delete', 2)->get();

    	return view('segmentos.carroceria.catalogo-carroceria-inactivas', compact('carroceria'));	
    }

    public function activarcarroceria(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Carroceria::where('id', $request->id)->update($data);

        session()->flash('success', 'La carroceria se activo correctamente');
    	return redirect()->route('carroceria.catalogocarroceriainactivos');	
    }

}