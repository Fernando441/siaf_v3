<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\LantaRefaccion;

class LlantaRefaccionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadollantarefaccion()
    {
    	$llanta = LantaRefaccion::where('id_status_delete', 1)->get();

    	return view('segmentos.llantarefaccion.catalogo-llantarefaccion', compact('llanta'));
    }

    public function llantarefacciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = LantaRefaccion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = LantaRefaccion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = LantaRefaccion::select('segmento_llanta_refaccion.id', 'segmento_llanta_refaccion.llanta_refaccion', 'segmento_llanta_refaccion.id_status_delete')
            ->where('segmento_llanta_refaccion.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_llanta_refaccion.llanta_refaccion", '=' , $valor);
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
                "nombre" => $record->llanta_refaccion,
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

    public function guardarllantarefaccion(Request $request)
    {
        $data = [
            'llanta_refaccion' => $request->llanta_refaccion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        LantaRefaccion::insert($data);

        session()->flash('success', 'La llanta de refacción se creo correctamente');
    	return redirect()->route('llantar.catalogollantarefaccion');
    }

    public function editarllantarefaccion(Request $request)
    {
        $data = [
            'llanta_refaccion' => $request->llanta_refaccion,
            'iduserUpdated' =>auth()->user()->id
        ];  

        LantaRefaccion::where('id', $request->id_llanta)->update($data);

        session()->flash('success', 'La llanta de refacción se modifico correctamente');
    	return redirect()->route('llantar.catalogollantarefaccion');
    }

    public function desactivarllanta(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	LantaRefaccion::where('id', $request->id)->update($data);

        session()->flash('success', 'La llanta de refacción se desactivo correctamente');
    	return redirect()->route('llantar.catalogollantarefaccion');
    }

    public function catalogollantasinactivos()
    {
    	$llanta = LantaRefaccion::where('id_status_delete', 2)->get();

    	return view('segmentos.llantarefaccion.catalogo-llantarefaccion-inactivas', compact('llanta'));
    }

    public function activarllanta(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	LantaRefaccion::where('id', $request->id)->update($data);

        session()->flash('success', 'La llanta de refacción se activo correctamente');
    	return redirect()->route('llantar.catalogollantasinactivos');   	
    }


}