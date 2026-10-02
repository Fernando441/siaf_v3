<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Direccion;

class DireccionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadodireccion()
    {
    	$direccion = Direccion::where('id_status_delete', 1)->get();

    	return view('segmentos.direccion.catalogo-direccion', compact('direccion'));
    }

    public function direcciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Direccion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Direccion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Direccion::select('segmento_direccion.id', 'segmento_direccion.direccion', 'segmento_direccion.id_status_delete')
            ->where('segmento_direccion.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_direccion.direccion", '=' , $valor);
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
                "nombre" => $record->direccion,
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

    public function guardardireccion(Request $request)
    {
        $data = [
            'direccion' => $request->direccion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Direccion::insert($data);

        session()->flash('success', 'El nombre de la dirección se creo correctamente');
    	return redirect()->route('direccion.catalogodireccion');
    }

    public function editardireccion(Request $request)
    {
        $data = [
            'direccion' => $request->direccion,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Direccion::where('id', $request->id_direccion)->update($data);

        session()->flash('success', 'El nombre de la dirección se modifico correctamente');
    	return redirect()->route('direccion.catalogodireccion');
    }

    public function desactivardireccion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Direccion::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de la dirección se desactivo correctamente');
    	return redirect()->route('direccion.catalogodireccion');
    }

    public function catalogodireccioninactivos(Request $request)
    {
    	$direccion = Direccion::where('id_status_delete', 2)->get();

    	return view('segmentos.direccion.catalogo-direccion-inactivos', compact('direccion'));	
    }

    public function activardireccion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Direccion::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre de la dirección se activo correctamente');
    	return redirect()->route('direccion.catalogodireccioninactivos');   	
    }

}