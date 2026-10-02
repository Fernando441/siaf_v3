<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Transmision;

class TransmisionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadotransmision()
    {
    	$transmision = Transmision::where('id_status_delete', 1)->get();

    	return view('segmentos.transmision.catalogo-transmision', compact('transmision'));
    }

    public function transmisiondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Transmision::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Transmision::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Transmision::select('segmento_transmision.id', 'segmento_transmision.transmision', 'segmento_transmision.id_status_delete')
            ->where('segmento_transmision.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_transmision.transmision", '=' , $valor);
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
                "nombre" => $record->transmision,
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

    public function guardartransmision(Request $request)
    {
        $data = [
            'transmision' => $request->transmision,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Transmision::insert($data);

        session()->flash('success', 'La transmisión se creo correctamente');
    	return redirect()->route('transmision.catalogotransmision');
    }

    public function editartransmision(Request $request)
    {
        $data = [
            'transmision' => $request->transmision,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Transmision::where('id', $request->id_transmision)->update($data);

        session()->flash('success', 'La transmisión se modifico correctamente');
    	return redirect()->route('transmision.catalogotransmision');
    }

    public function desactivartransmision(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Transmision::where('id', $request->id)->update($data);

        session()->flash('success', 'La transmisión se desactivo correctamente');
    	return redirect()->route('transmision.catalogotransmision');
    }

    public function catalogotransmisioninactivos(Request $request)
    {
    	$transmision = Transmision::where('id_status_delete', 2)->get();

    	return view('segmentos.transmision.catalogo-transmision-inactivos', compact('transmision'));    	
    }

    public function activartransmision(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Transmision::where('id', $request->id)->update($data);

        session()->flash('success', 'La transmisión se activo correctamente');
    	return redirect()->route('transmision.catalogotransmisioninactivos');   	
    }

}