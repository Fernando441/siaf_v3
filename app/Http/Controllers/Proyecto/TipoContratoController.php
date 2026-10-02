<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\TipoContrato;

class TipoContratoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadotipocontrato()
    {
    	$contratos = TipoContrato::where('status_delete', 0)->get();

    	return view('proyectos.tipocontrato.listado-tipocontrato', compact('contratos'));
    }

    public function tipocontratodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TipoContrato::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TipoContrato::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = TipoContrato::select('tipo_contrato.id', 'tipo_contrato.tipo_contrato', 'tipo_contrato.status_delete')
            ->where('tipo_contrato.status_delete', 0)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("tipo_contrato.tipo_contrato", '=' , $valor);
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
                "nombre" => $record->tipo_contrato,
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

    public function guardarcontrato(Request $request)
    {
        $data = [
            'tipo_contrato' => $request->tipo_contrato,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoContrato::insert($data);

        session()->flash('success', 'El tipo de contrato se creo correctamente');
    	return redirect()->route('tipocontrato.listadotipocontrato');

    }

    public function editarcontrato(Request $request)
    {
        $data = [
            'tipo_contrato' => $request->tipo_contrato,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TipoContrato::where('id', $request->id_contrato)->update($data);

        session()->flash('success', 'El tipo de contrato se modifico correctamente');
    	return redirect()->route('tipocontrato.listadotipocontrato');
    }

    public function eliminarcontrato(Request $request)
    {
        $data = [
            'status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TipoContrato::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de contrato se desctivo correctamente');
    	return redirect()->route('tipocontrato.listadotipocontrato');

    }

    public function catalogocontratosinactivos()
    {
    	$contratos = TipoContrato::where('status_delete', 1)->get();

    	return view('proyectos.tipocontrato.listado-tipocontrato-inactivos', compact('contratos'));   	
    }

    public function activarcontrato(Request $request)
    {
        $data = [
            'status_delete' => 0,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TipoContrato::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de contrato se activo correctamente');
    	return redirect()->route('tipocontrato.contratosinactivos');
    }

}