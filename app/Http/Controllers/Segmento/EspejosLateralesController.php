<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\EspejosLaterales;

class EspejosLateralesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoespejoslaterales()
    {
    	$espejos = EspejosLaterales::where('id_status_delete', 1)->get();

    	return view('segmentos.espejoslaterales.catalogo-espejoslaterales', compact('espejos'));
    }

    public function espejoslateralesdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = EspejosLaterales::select('count(*) as allcount')->count();
        $totalRecordswithFilter = EspejosLaterales::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = EspejosLaterales::select('segmento_espejos_laterales.id', 'segmento_espejos_laterales.espejos_laterales', 'segmento_espejos_laterales.id_status_delete')
            ->where('segmento_espejos_laterales.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("segmento_espejos_laterales.espejos_laterales", '=' , $valor);
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
                "nombre" => $record->espejos_laterales,
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

    public function guardarespejoslaterales(Request $request)
    {
        $data = [
            'espejos_laterales' => $request->espejos_laterales,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        EspejosLaterales::insert($data);

        session()->flash('success', 'El espejo lateral se creo correctamente');
    	return redirect()->route('espejosl.catalogoespejoslaterales');
    }

    public function editarespejoslaterales(Request $request)
    {
        $data = [
            'espejos_laterales' => $request->espejos_laterales,
            'iduserUpdated' =>auth()->user()->id
        ];  

        EspejosLaterales::where('id', $request->id_espejos)->update($data);

        session()->flash('success', 'El espejo lateral se modifico correctamente');
    	return redirect()->route('espejosl.catalogoespejoslaterales');
    }

    public function desactivarespejos(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	EspejosLaterales::where('id', $request->id)->update($data);

        session()->flash('success', 'El espejo lateral se desactivo correctamente');
    	return redirect()->route('espejosl.catalogoespejoslaterales');
    }

    public function catalogoespejosinactivos()
    {
    	$espejos = EspejosLaterales::where('id_status_delete', 2)->get();

    	return view('segmentos.espejoslaterales.catalogo-espejoslaterales-inactivos', compact('espejos'));
    }

    public function activarespejos(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	EspejosLaterales::where('id', $request->id)->update($data);

        session()->flash('success', 'El espejo lateral se activo correctamente');
    	return redirect()->route('espejosl.catalogoespejosinactivos'); 	
    }


}