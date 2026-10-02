<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\LicitacionTipoFianza;

class TipodFianzaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadotipodefianza()
    {
    	$tipoafianzadora = LicitacionTipoFianza::where('id_status_delete', 1)->get();

    	return view('licitaciones.tipofianza.catalogo-tipofianza', compact('tipoafianzadora'));    	
    }

    public function tipofianzadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = LicitacionTipoFianza::select('count(*) as allcount')->count();
        $totalRecordswithFilter = LicitacionTipoFianza::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = LicitacionTipoFianza::select('licitacion_tipo_fianza.id', 'licitacion_tipo_fianza.tipo_fianza', 'licitacion_tipo_fianza.id_status_delete')
            ->where('licitacion_tipo_fianza.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("licitacion_tipo_fianza.tipo_fianza", '=' , $valor);
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
                "nombre" => $record->tipo_fianza,
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

    public function guardartipofianza(Request $request)
    {
        $data = [
            'tipo_fianza' => $request->tipo_fianza,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        LicitacionTipoFianza::insert($data);

        session()->flash('success', 'El tipo de fianza se creo correctamente');
    	return redirect()->route('tipofianza.listadocatalogoatipodfianza');
    }

    public function editartipofianza(Request $request)
    {
        $data = [
            'tipo_fianza' => $request->tipo_fianza,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        LicitacionTipoFianza::where('id', $request->id_tipofianza)->update($data);

        session()->flash('success', 'El tipo de fianza se modifico correctamente');
    	return redirect()->route('tipofianza.listadocatalogoatipodfianza');
    }

    public function desactivartipofianza(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        LicitacionTipoFianza::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de fianza se desactivo correctamente');
       	return redirect()->route('tipofianza.listadocatalogoatipodfianza');
    }

    public function listadotipofianzainactivas()
    {
    	$tipoafianzadora = LicitacionTipoFianza::where('id_status_delete', 2)->get();

    	return view('licitaciones.tipofianza.catalogo-tipofianza-inactivas', compact('tipoafianzadora'));      	
    }

    public function activartipofianza(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        LicitacionTipoFianza::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de fianza se activo correctamente');
        return redirect()->route('tipofianza.listadocatalogotipofianzainactivas'); 
    }

}