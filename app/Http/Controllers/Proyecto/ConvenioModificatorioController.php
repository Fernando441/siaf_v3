<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\ProyectoModificacionConvenio;

class ConvenioModificatorioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoconveniomodificatorio()
    {
    	$convenio = ProyectoModificacionConvenio::where('id_status_delete', 1)->get();

    	return view('proyectos.conveniomodificatorio.listado-convenios', compact('convenio'));
    }

    public function tipodeconveniomoddatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = ProyectoModificacionConvenio::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ProyectoModificacionConvenio::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = ProyectoModificacionConvenio::select('proyecto_modificacion_convenio.id', 'proyecto_modificacion_convenio.nombre_modificacion', 'proyecto_modificacion_convenio.id_status_delete')
            ->where('proyecto_modificacion_convenio.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("proyecto_modificacion_convenio.nombre_modificacion", '=' , $valor);
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
                "nombre" => $record->nombre_modificacion,
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

    public function guardarconveniomodificatorio(Request $request)
    {
        $data = [
            'nombre_modificacion' => $request->nombre_modificacion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        ProyectoModificacionConvenio::insert($data);

        session()->flash('success', 'El tipo de convenio modificatorio se creo correctamente');
    	return redirect()->route('conveniom.listadoconveniomodificatorio');
    }

    public function editarconveniomodificatorio(Request $request)
    {
        $data = [
            'nombre_modificacion' => $request->nombre_modificacion,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ProyectoModificacionConvenio::where('id', $request->id_convenio)->update($data);

        session()->flash('success', 'El tipo de convenio modificatorio se modifico correctamente');
    	return redirect()->route('conveniom.listadoconveniomodificatorio');
    }

    public function eliminarconveniom(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        ProyectoModificacionConvenio::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de convenio modificatorio se desactivo correctamente');
       	return redirect()->route('conveniom.listadoconveniomodificatorio');
    }

    public function catalogoconveniominactivos()
    {
    	$convenio = ProyectoModificacionConvenio::where('id_status_delete', 2)->get();

    	return view('proyectos.conveniomodificatorio.listado-convenios-inactivos', compact('convenio'));    	
    }

    public function activarconveniomodificatorio(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        ProyectoModificacionConvenio::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de convenio modificatorio se activo correctamente');
        return redirect()->route('conveniom.conveniominactivas'); 
    }

}