<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\EnInventario;

class EnInventarioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoeninventario()
    {
    	$inventario = EnInventario::where('id_status_delete', 1)->get();

    	return view('segmentos.inventario.catalogo-eninventario', compact('inventario'));
    }

    public function inventariodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = EnInventario::select('count(*) as allcount')->count();
        $totalRecordswithFilter = EnInventario::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = EnInventario::select('segmento_en_inventario.id', 'segmento_en_inventario.en_inventario', 'segmento_en_inventario.id_status_delete')
            ->where('segmento_en_inventario.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_en_inventario.en_inventario", '=' , $valor);
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
                "nombre" => $record->en_inventario,
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

    public function guardarinventario(Request $request)
    {
        $data = [
            'en_inventario' => $request->en_inventario,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        EnInventario::insert($data);

        session()->flash('success', 'El nombre del inventario se creo correctamente');
    	return redirect()->route('inventario.catalogoeninventario');
    }

    public function editarinventario(Request $request)
    {
        $data = [
            'en_inventario' => $request->en_inventario,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        EnInventario::where('id', $request->id_inventario)->update($data);

        session()->flash('success', 'El nombre del inventario se modifico correctamente');
    	return redirect()->route('inventario.catalogoeninventario');
    }

    public function desactivarinventario(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	EnInventario::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del inventario se desactivo correctamente');
    	return redirect()->route('inventario.catalogoeninventario');
    }

    public function catalogoinventarioinactivos()
    {
    	$inventario = EnInventario::where('id_status_delete', 2)->get();

    	return view('segmentos.inventario.catalogo-eninventario-inactivo', compact('inventario'));
    }

    public function activarinventario(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	EnInventario::where('id', $request->id)->update($data);

        session()->flash('success', 'El nombre del inventario se activo correctamente');
    	return redirect()->route('inventario.catalogoinventarioinactivos');   	
    }

}