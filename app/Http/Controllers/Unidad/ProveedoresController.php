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
use App\Models\Unidad\ProveedorTipo;

class ProveedoresController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoproveedores()
    {
		$proveedor = Proveedor::where('id_status_delete', 1)->get();

    	return view('unidades.proveedores.catalogo-proveedores', compact('proveedor'));
    }

    public function proveedordatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Proveedor::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Proveedor::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Proveedor::select('proveedores.id', 'proveedores.nombre', 'proveedores.direccion', 'proveedores.telefono',
    		'proveedores.contacto', 'proveedores.correo', 'proveedores.giro_comercial', 'proveedores.rfc')
            ->where('proveedores.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("proveedores.nombre", '=' , $valor);
                }
            }
            if($columna['data']=='contacto'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("proveedores.contacto", '=' , $valor);
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
                "nombre" => $record->nombre,
                "direccion" => $record->direccion,
                "contacto" => $record->contacto,
                "giro_comercial" => $record->giro_comercial,
                "rfc" => $record->rfc,
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

    public function crearproveedor()
    {
        $tipos_proveedor = ProveedorTipo::all();

        return view('unidades.proveedores.crear-proveedor', compact('tipos_proveedor'));
    }

    public function guardarproveedor(Request $request)
    {
        $data = [
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'contacto' => $request->contacto, 
            'correo' => $request->correo, 
            'giro_comercial' => $request->giro_comercial,
            'rfc' => $request->rfc,
            'proveedor_tipo_id' => $request->tipo_proveedor,
            'id_status_delete' => 1, 
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'convenio' => $request->convenio,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Proveedor::insert($data);

        session()->flash('success', 'El proveedor se creo correctamente');
    	return redirect()->route('proveedor.catalogoproveedores');
    }

    public function modificarproveedor($proveedor)
    {
		$proveedor_info = Proveedor::where('id', $proveedor)->get();
        //proveedor tipo
        $tipos_proveedor = ProveedorTipo::all();

    	return view('unidades.proveedores.editar-proveedor', compact('proveedor_info', 'tipos_proveedor'));
    }

    public function editarproveedor(Request $request)
    {
        $data = [
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'contacto' => $request->contacto, 
            'correo' => $request->correo, 
            'giro_comercial' => $request->giro_comercial,
            'rfc' => $request->rfc,
            'proveedor_tipo_id' => $request->proveedorTipo,
            'convenio' => $request->convenio,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Proveedor::where('id', $request->id)->update($data);

        session()->flash('success', 'El proveedor se modifico correctamente');
    	return redirect()->route('proveedor.catalogoproveedores');  	
    }

    public function eliminarproveedor(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Proveedor::where('id', $request->id)->update($data);

        session()->flash('success', 'El proveedor se desactivo correctamente');
    	return redirect()->route('proveedor.catalogoproveedores'); 
    }

    public function catalogoproveedoreseliminadas()
    {
		$proveedor = Proveedor::where('id_status_delete', 2)->get();

    	return view('unidades.proveedores.catalogo-proveedores-inactivos', compact('proveedor'));	
    }

    public function activarproveedor(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Proveedor::where('id', $request->id)->update($data);

        session()->flash('success', 'El proveedor se activo correctamente');
    	return redirect()->route('proveedor.catalogoproveedoreseliminadas');   	
    }

    public function checkProveedor(Request $request)
    {
        $rfc = $request->get('rfc');
        $response= true;

        if (!empty($rfc)) {
            $exist = Proveedor::select('id')->where('rfc',$rfc)->count();
            if (!empty($exist)) {
                $response = false;
            }
        }

        return response()->json(array(
            'valid' => $response,
        ));
    }

}