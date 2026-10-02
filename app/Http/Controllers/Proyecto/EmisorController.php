<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Proyecto\Emisor;

class EmisorController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoemisores()
    {
    	$emisores = Emisor::where('id_status_delete', 1)->get();

    	return view('proyectos.emisores.listado-emisores', compact('emisores'));
    }

    public function emisordatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Emisor::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Emisor::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Emisor::select('emisores.id', 'emisores.razon_social', 'emisores.rfc', 'emisores.dom_fiscal', 
            'emisores.id_status_delete')
            ->where('emisores.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("emisores.razon_social", '=' , $valor);
                }
            }

            if($columna['data']=='rfc'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("emisores.rfc", '=' , $valor);
                }
            }

            if($columna['data']=='dom_fiscal'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("emisores.dom_fiscal", '=' , $valor);
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
                "rfc" => $record->rfc,
                "dom_fiscal" => $record->dom_fiscal,
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

    public function guardaremisor(Request $request)
    {
        $data = [
            'razon_social' => $request->razon_social,
            'rfc' => $request->rfc,
            'dom_fiscal' => $request->dom_fiscal,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Emisor::insert($data);

        session()->flash('success', 'La razon social se creo correctamente');
    	return redirect()->route('emisores.listadoemisores');
    }

    public function editaremisor(Request $request)
    {
        $data = [
            'razon_social' => $request->razon_social,
            'rfc' => $request->rfc,
            'dom_fiscal' => $request->dom_fiscal,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Emisor::where('id', $request->id_emisor)->update($data);

        session()->flash('success', 'La razon social se modifico correctamente');
    	return redirect()->route('emisores.listadoemisores');

    }

    public function eliminaremisor(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Emisor::where('id', $request->id)->update($data);

        session()->flash('success', 'La razon social se desactivo correctamente');
    	return redirect()->route('emisores.listadoemisores');

    }

    public function catalogoemisoresinactivos()
    {
    	$emisores = Emisor::where('id_status_delete', 2)->get();

    	return view('proyectos.emisores.listado-emisores-inactivos', compact('emisores'));
    }

    public function activaremisor(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	Emisor::where('id', $request->id)->update($data);

        session()->flash('success', 'La razon social se activo correctamente');
    	return redirect()->route('emisores.emisoresinactivos');

    }

}