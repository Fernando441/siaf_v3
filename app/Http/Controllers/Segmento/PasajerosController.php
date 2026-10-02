<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Pasajero;

class PasajerosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadopasajeros()
    {
    	$pasajeros = Pasajero::where('id_status_delete', 1)->get();

    	return view('segmentos.pasajeros.catalogo-pasajeros', compact('pasajeros'));
    }

    public function pasajerodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Pasajero::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Pasajero::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Pasajero::select('segmento_pasajero.id', 'segmento_pasajero.segmento_pasajerocol', 'segmento_pasajero.id_status_delete')
            ->where('segmento_pasajero.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_pasajero.segmento_pasajerocol", '=' , $valor);
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
                "nombre" => $record->segmento_pasajerocol,
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

    public function guardarpasajero(Request $request)
    {
        $data = [
            'segmento_pasajerocol' => $request->segmento_pasajerocol,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Pasajero::insert($data);

        session()->flash('success', 'El número de pasajeros se creo correctamente');
    	return redirect()->route('pasajero.catalogopasajeros');
    }

    public function editarpasajero(Request $request)
    {
        $data = [
            'segmento_pasajerocol' => $request->segmento_pasajerocol,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Pasajero::where('id', $request->id_pasajero)->update($data);

        session()->flash('success', 'El número de pasajeros se modifico correctamente');
    	return redirect()->route('pasajero.catalogopasajeros');
    }

    public function desactivarpasajero(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Pasajero::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de pasajeros se desactivo correctamente');
    	return redirect()->route('pasajero.catalogopasajeros');
    }

    public function catalogopasajeroinactivos()
    {
    	$pasajeros = Pasajero::where('id_status_delete', 2)->get();

    	return view('segmentos.pasajeros.catalogo-pasajeros-inactivos', compact('pasajeros'));   	
    }

    public function activarpasajero(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Pasajero::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de pasajeros se activo correctamente');
    	return redirect()->route('pasajero.catalogopasajeroinactivos');	
    }

}