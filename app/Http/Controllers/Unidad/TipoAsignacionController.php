<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\TipoAsignacion;

class TipoAsignacionController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogotipoasignacion()
    {
		$tipoasignacion = TipoAsignacion::where('id_status_delete', 1)->get();

    	return view('unidades.tipoasignacion.catalogo-tipo-asignacion', compact('tipoasignacion'));
    }

    public function tipoasignaciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TipoAsignacion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TipoAsignacion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = TipoAsignacion::select('unidad_tipo_asignacion.id', 'unidad_tipo_asignacion.tipo_asignacion', 'unidad_tipo_asignacion.id_status_delete')
            ->where('unidad_tipo_asignacion.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("unidad_tipo_asignacion.tipo_asignacion", '=' , $valor);
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
                "nombre" => $record->tipo_asignacion,
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

    public function guardartipoasignacion(Request $request)
    {
        $data = [
            'tipo_asignacion' => $request->tipo_asignacion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoAsignacion::insert($data);

        session()->flash('success', 'El tipo de asignación se creo correctamente');
    	return redirect()->route('tipoasignacion.catalogotipoasignacion');
    }

    public function editartipoasignacion(Request $request)
    {
        $data = [
            'tipo_asignacion' => $request->nombre_asignacion,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TipoAsignacion::where('id', $request->id_asignacion)->update($data);

        session()->flash('success', 'El tipo de asignación se modifico correctamente');
    	return redirect()->route('tipoasignacion.catalogotipoasignacion');
    }

    public function eliminartipoasignacion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	TipoAsignacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de asignación se desactivo correctamente');
    	return redirect()->route('tipoasignacion.catalogotipoasignacion');
    }

    public function catalogotipoasignacioneliminadas()
    {
		$tipoasignacion = TipoAsignacion::where('id_status_delete', 2)->get();

    	return view('unidades.tipoasignacion.catalogo-tipo-asignacion-inactivos', compact('tipoasignacion'));    	
    }

    public function activartipoasignacion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	TipoAsignacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de asignación se activo correctamente');
    	return redirect()->route('tipoasignacion.catalogotipoasignacioneliminadas'); 
    }

}