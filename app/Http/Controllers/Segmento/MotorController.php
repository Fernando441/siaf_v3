<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Motor;

class MotorController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadomotor()
    {
    	$motor = Motor::where('id_status_delete', 1)->get();

    	return view('segmentos.motor.catalogo-motor', compact('motor'));
    }

    public function motordatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Motor::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Motor::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Motor::select('segmento_motor.id', 'segmento_motor.motor', 'segmento_motor.id_status_delete')
            ->where('segmento_motor.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_motor.motor", '=' , $valor);
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
                "nombre" => $record->motor,
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

    public function guardarmotor(Request $request)
    {
        $data = [
            'motor' => $request->motor,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Motor::insert($data);

        session()->flash('success', 'El tipo de motor se creo correctamente');
    	return redirect()->route('motor.catalogomotor');
    }

    public function editarmotor(Request $request)
    {
        $data = [
            'motor' => $request->motor,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Motor::where('id', $request->id_motor)->update($data);

        session()->flash('success', 'El tipo de motor se modifico correctamente');
    	return redirect()->route('motor.catalogomotor');
    }

    public function desactivarmotor(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Motor::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de motor se desactivo correctamente');
    	return redirect()->route('motor.catalogomotor');
    }

    public function catalogomotorinactivos()
    {
    	$motor = Motor::where('id_status_delete', 2)->get();

    	return view('segmentos.motor.catalogo-motor-inactivo', compact('motor'));  	
    }

    public function activarmotor(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Motor::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de motor se activo correctamente');
    	return redirect()->route('motor.catalogomotorinactivos');	
    }

}