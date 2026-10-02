<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\NoCilindro;

class NoCilindrosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadonocilindros()
    {
    	$nocilindros = NoCilindro::where('id_status_delete', 1)->get();

    	return view('segmentos.nocilindro.catalogo-nocilindros', compact('nocilindros'));
    }

    public function nocilindrosdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = NoCilindro::select('count(*) as allcount')->count();
        $totalRecordswithFilter = NoCilindro::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = NoCilindro::select('segmento_no_cilindro.id', 'segmento_no_cilindro.no_cilindro', 'segmento_no_cilindro.id_status_delete')
            ->where('segmento_no_cilindro.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_no_cilindro.no_cilindro", '=' , $valor);
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
                "nombre" => $record->no_cilindro,
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

    public function guardarnocilindro(Request $request)
    {
        $data = [
            'no_cilindro' => $request->nocilindros,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        NoCilindro::insert($data);

        session()->flash('success', 'El número de cilindros se creo correctamente');
    	return redirect()->route('nocilindros.catalogonocilindros');
    }

    public function editarnocilindro(Request $request)
    {
        $data = [
            'no_cilindro' => $request->no_cilindro,
            'iduserUpdated' =>auth()->user()->id
        ];  

        NoCilindro::where('id', $request->id_nocilindros)->update($data);

        session()->flash('success', 'El número de cilindros se modifico correctamente');
    	return redirect()->route('nocilindros.catalogonocilindros');
    }

    public function desactivarnocilindro(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	NoCilindro::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de cilindros se desactivo correctamente');
    	return redirect()->route('nocilindros.catalogonocilindros');
    }

    public function catalogonocilindroinactivas()
    {
    	$nocilindros = NoCilindro::where('id_status_delete', 2)->get();

    	return view('segmentos.nocilindro.catalogo-nocilindros-inactivos', compact('nocilindros'));
    }

    public function activarnocilindro(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	NoCilindro::where('id', $request->id)->update($data);

        session()->flash('success', 'El número de cilindros se activo correctamente');
    	return redirect()->route('nocilindros.catalogonocilindroinactivos');  	
    }

}