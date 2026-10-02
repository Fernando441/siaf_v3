<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Requisicion\RequisicionMetodoPago;

class MetodoPagoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadometodospago()
    {
    	$metodos = RequisicionMetodoPago::where('id_status_delete', 1)->get();

    	return view('licitaciones.metodopago.catalogo-metodospago', compact('metodos'));
    }

    public function metodopagodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionMetodoPago::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RequisicionMetodoPago::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = RequisicionMetodoPago::select('requisicion_metodo_pago.id', 'requisicion_metodo_pago.metodo_pago', 'requisicion_metodo_pago.clave', 'requisicion_metodo_pago.id_status_delete')
            ->where('requisicion_metodo_pago.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("requisicion_metodo_pago.metodo_pago", '=' , $valor);
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
                "nombre" => $record->metodo_pago,
                "clave" => $record->clave,
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

    public function guardarmetodopago(Request $request)
    {
    	
    	$pago = RequisicionMetodoPago::where('clave', $request->clave)->first();
    	if($pago != null){
        	session()->flash('warning', 'La clave ya existe, verifica los datos ingresados');
    		return redirect()->route('metodopago.listadometodopago');
    	}

        $data = [
            'metodo_pago' => $request->metodo_pago,
            'clave' => $request->clave,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        RequisicionMetodoPago::insert($data);

        session()->flash('success', 'El método de pago se creo correctamente');
    	return redirect()->route('metodopago.listadometodopago');
    }

    public function editarmetodopago(Request $request)
    {
    	
    	$pago = RequisicionMetodoPago::where('clave', $request->clave)->first();
    	if($pago->id != $request->id_metodopago){
        	session()->flash('warning', 'La clave ya existe, verifica los datos ingresados');
    		return redirect()->route('metodopago.listadometodopago');
    	}

        $data = [
            'metodo_pago' => $request->metodo_pago,
            'clave' => $request->clave,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        RequisicionMetodoPago::where('id', $request->id_metodopago)->update($data);

        session()->flash('success', 'El método de pago se modifico correctamente');
    	return redirect()->route('metodopago.listadometodopago');
    }

    public function desactivarmetodopago(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        RequisicionMetodoPago::where('id', $request->id)->update($data);

        session()->flash('success', 'El método de pago se desactivo correctamente');
        return redirect()->route('metodopago.listadometodopago');
    }

    public function catalogometodopagoinactivas()
    {
    	$metodos = RequisicionMetodoPago::where('id_status_delete', 2)->get();

    	return view('licitaciones.metodopago.catalogo-metodospago-inactivo', compact('metodos'));	
    }

    public function activarmetodopago(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        RequisicionMetodoPago::where('id', $request->id)->update($data);

        session()->flash('success', 'El método de pago se activo correctamente');
        return redirect()->route('metodopago.metodopagoinactivas');
    }	

}