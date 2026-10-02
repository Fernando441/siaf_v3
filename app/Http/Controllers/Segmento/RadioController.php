<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Radio;

class RadioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoradio()
    {
    	$radio = Radio::where('id_status_delete', 1)->get();

    	return view('segmentos.radio.catalogo-radio', compact('radio'));
    }

    public function radiodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Radio::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Radio::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Radio::select('segmento_radio.id', 'segmento_radio.radio', 'segmento_radio.id_status_delete')
            ->where('segmento_radio.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_radio.radio", '=' , $valor);
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
                "nombre" => $record->radio,
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

    public function guardarradio(Request $request)
    {
        $data = [
            'radio' => $request->radio,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Radio::insert($data);

        session()->flash('success', 'El nombre de radio se creo correctamente');
    	return redirect()->route('radio.catalogoradio');
    }

    public function editarradio(Request $request)
    {
        $data = [
            'radio' => $request->radio,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Radio::where('id', $request->id_radio)->update($data);

        session()->flash('success', 'El nombre de radio se modifico correctamente');
    	return redirect()->route('radio.catalogoradio');
    }

    public function desactivarradio(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Radio::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de radio se desactivo correctamente');
    	return redirect()->route('radio.catalogoradio');
    }

    public function catalogoradioinactivos(Request $request)
    {
    	$radio = Radio::where('id_status_delete', 2)->get();

    	return view('segmentos.radio.catalogo-radio-inactivos', compact('radio'));
    }

    public function activarradio(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Radio::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de radio se activo correctamente');
    	return redirect()->route('radio.catalogoradioinactivos');
    }

}