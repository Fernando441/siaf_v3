<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Cilindro;

class CilindrosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadocilindros()
    {
    	$cilindros = Cilindro::where('id_status_delete', 1)->get();

    	return view('segmentos.cilindros.catalogo-cilindros', compact('cilindros'));
    }

    public function cilindrosdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Cilindro::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Cilindro::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Cilindro::select('segmento_cilindro.id', 'segmento_cilindro.cilindro', 'segmento_cilindro.id_status_delete')
            ->where('segmento_cilindro.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_cilindro.cilindro", '=' , $valor);
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
                "nombre" => $record->cilindro,
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

    public function guardarcilindro(Request $request)
    {
        $data = [
            'cilindro' => $request->cilindro,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Cilindro::insert($data);

        session()->flash('success', 'El cilindro se creo correctamente');
    	return redirect()->route('cilindros.catalogocilindros');
    }

    public function editarcilindro(Request $request)
    {
        $data = [
            'cilindro' => $request->cilindro,
            'iduserUpdated' =>auth()->user()->id
        ];  

        Cilindro::where('id', $request->id_cilindro)->update($data);

        session()->flash('success', 'El cilindro se modifico correctamente');
    	return redirect()->route('cilindros.catalogocilindros');
    }

    public function desactivarcilindro(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Cilindro::where('id', $request->id)->update($data);

        session()->flash('success', 'El cilindro se desactivo correctamente');
    	return redirect()->route('cilindros.catalogocilindros');
    }

    public function catalogocilindroinactivos()
    {
    	$cilindros = Cilindro::where('id_status_delete', 2)->get();

    	return view('segmentos.cilindros.catalogo-cilindros-inactivos', compact('cilindros'));   	
    }

    public function activarcilindro(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Cilindro::where('id', $request->id)->update($data);

        session()->flash('success', 'El cilindro se activo correctamente');
    	return redirect()->route('cilindros.catalogocilindroinactivos');  	
    }

}