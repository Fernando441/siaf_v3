<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Unidad\Proveedor;
use App\Models\Unidad\AgenciaUnidad;

class AgenciaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function catalogoagencias()
    {
		$proveedor = Proveedor::where('id_status_delete', 1)->get();

    	return view('unidades.agencias.catalogo-agencias', compact('proveedor'));
    }

    public function agenciadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = AgenciaUnidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AgenciaUnidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = AgenciaUnidad::select('agencia_unidad.id', 'agencia_unidad.id_proveedor', 'agencia_unidad.razon_social',
    		'agencia_unidad.contacto', 'agencia_unidad.puesto', 'agencia_unidad.direccion', 'agencia_unidad.telefono',
    		'agencia_unidad.contacto', 'pr.nombre')
        	->leftjoin("proveedores as pr","pr.id","agencia_unidad.id_proveedor")
            ->where('agencia_unidad.status_delete', 0)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("agencia_unidad.razon_social", '=' , $valor);
                }
            }

            if($columna['data']=='proveedor'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("agencia_unidad.id_proveedor", '=' , $valor);
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
                "nombre" => $record->razon_social,
                "contacto" => $record->contacto,
                "proveedor" => $record->nombre,
                "puesto" => $record->puesto,
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

    public function crearagencias()
    {
    	$proveedor = Proveedor::where('id_status_delete', 0)->get();

    	return view('unidades.agencias.crear-agencia', compact('proveedor'));
    }

    public function guardaragencia(Request $request)
    {
        $data = [
            'razon_social' => $request->razon_social,
            'id_proveedor' => $request->id_proveedor,
            'contacto' => $request->contacto,
            'puesto' => $request->puesto,
            'direccion' => $request->direccion, 
            'telefono' => $request->telefono, 
            'correo' => $request->correo, 
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        AgenciaUnidad::insert($data);

        session()->flash('success', 'La agencia se creo correctamente');
    	return redirect()->route('agencia.catalogoagencias');
    }

    public function modificaragencia($agencia)
    {
        $agencia_info = AgenciaUnidad::where('id', $agencia)->get();
        $proveedor = Proveedor::where('id_status_delete', 0)->get();

        return view('unidades.agencias.editar-agencia', compact('agencia_info', 'proveedor'));
    }

    public function editaragencia(Request $request)
    {

        $data = [
            'razon_social' => $request->razon_social,
            'id_proveedor' => $request->id_proveedor,
            'contacto' => $request->contacto,
            'puesto' => $request->puesto,
            'direccion' => $request->direccion, 
            'telefono' => $request->telefono, 
            'correo' => $request->correo, 
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        AgenciaUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La agencia se modifico correctamente');
    	return redirect()->route('agencia.catalogoagencias');
    }

    public function eliminaragencia(Request $request)
    {
        $data = [
            'status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	AgenciaUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La agencia se desactivo correctamente');
    	return redirect()->route('agencia.catalogoagencias');
    }

    public function catalogoagenciasinactivas()
    {
		$agencia = AgenciaUnidad::select('agencia_unidad.id', 'agencia_unidad.id_proveedor', 'agencia_unidad.razon_social',
    		'agencia_unidad.contacto', 'agencia_unidad.puesto', 'agencia_unidad.direccion', 'agencia_unidad.telefono',
    		'agencia_unidad.contacto', 'pr.nombre')
        	->leftjoin("proveedores as pr","pr.id","agencia_unidad.id_proveedor")
            ->where('agencia_unidad.status_delete', 1)
            ->get();

    	return view('unidades.agencias.catalogo-agencias-inactivas', compact('agencia')); 	
    }

    public function activaragencia(Request $request)
    {
        $data = [
            'status_delete' => 0,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	AgenciaUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La agencia se activo correctamente');
    	return redirect()->route('agencia.catalogoagenciaseliminadas');
    }
}