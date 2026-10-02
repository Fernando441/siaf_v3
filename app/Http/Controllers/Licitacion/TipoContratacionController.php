<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\TipoContratacion;

class TipoContratacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadotipocontratacion()
    {
    	$contratacion = TipoContratacion::where('id_status_delete', 1)->get();

    	return view('licitaciones.tipocontratacion.catalogo-contrataciones', compact('contratacion'));
    }

    public function contrataciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TipoContratacion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TipoContratacion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = TipoContratacion::select('tipo_contratacion.id', 'tipo_contratacion.tipo_contratacion', 'tipo_contratacion.id_status_delete')
            ->where('tipo_contratacion.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("tipo_contratacion.tipo_contratacion", '=' , $valor);
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
                "nombre" => $record->tipo_contratacion,
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

    public function guardarcontratacion(Request $request)
    {
        $data = [
            'tipo_contratacion' => $request->tipo_contratacion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoContratacion::insert($data);

        session()->flash('success', 'El tipo de contrato se creo correctamente');
    	return redirect()->route('contratacion.listadotipocontratacion');
    }

    public function editarcontratacion(Request $request)
    {
        $data = [
            'tipo_contratacion' => $request->tipo_contratacion,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoContratacion::where('id', $request->id_contratacion)->update($data);

        session()->flash('success', 'El tipo de contratación se modifico correctamente');
    	return redirect()->route('contratacion.listadotipocontratacion');
    }

    public function desactivarcontratacion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        TipoContratacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de contratación se desactivo correctamente');
        return redirect()->route('contratacion.listadotipocontratacion');
    }

    public function catalogocontratacionesinactivas()
    {
    	$contratacion = TipoContratacion::where('id_status_delete', 2)->get();

    	return view('licitaciones.tipocontratacion.catalogo-contrataciones-inactivas', compact('contratacion'));   	
    }

    public function activarcontratacion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        TipoContratacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de contratación se activo correctamente');
        return redirect()->route('contratacion.contratacionesinactivas');   	
    }

}