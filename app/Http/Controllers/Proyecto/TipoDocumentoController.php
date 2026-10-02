<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\ProyectoTipoDocumento;

class TipoDocumentoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadotipodocumento()
    {
    	$documento = ProyectoTipoDocumento::where('id_status_delete', 1)->get();

    	return view('proyectos.tipodedocumento.listado-tipodocumento', compact('documento'));
    }

    public function tipodedocumentodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = ProyectoTipoDocumento::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ProyectoTipoDocumento::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = ProyectoTipoDocumento::select('proyecto_tipo_documento.id', 'proyecto_tipo_documento.tipo', 'proyecto_tipo_documento.id_status_delete')
            ->where('proyecto_tipo_documento.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("proyecto_tipo_documento.tipo", '=' , $valor);
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
                "nombre" => $record->tipo,
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

    public function guardartipodedocumento(Request $request)
    {
        $data = [
            'tipo' => $request->tipo,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        ProyectoTipoDocumento::insert($data);

        session()->flash('success', 'El tipo de documento se creo correctamente');
    	return redirect()->route('tipodoc.listadotipodocumento'); 
    }

    public function editartipodedocumento(Request $request)
    {
        $data = [
            'tipo' => $request->tipo,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ProyectoTipoDocumento::where('id', $request->id_tipodocumento)->update($data);

        session()->flash('success', 'El tipo de documento se modifico correctamente');
    	return redirect()->route('tipodoc.listadotipodocumento');
    }

    public function eliminartipodedocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	ProyectoTipoDocumento::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se desctivo correctamente');
    	return redirect()->route('tipodoc.listadotipodocumento');
    }

    public function catalogotipodedocumentoinactivos()
    {
    	$documento = ProyectoTipoDocumento::where('id_status_delete', 2)->get();

    	return view('proyectos.tipodedocumento.listado-tipodocumento-inactivas', compact('documento'));
    }

    public function activartipodedocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	ProyectoTipoDocumento::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se activo correctamente');
    	return redirect()->route('tipodoc.tipodedocumentoinactivas');
    }


}