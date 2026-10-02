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
use App\Models\Unidad\StatusUnidad;

class EstatusController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoestatus()
    {
		$estatus = StatusUnidad::where('id_status_delete', 1)->get();

    	return view('unidades.catalogos.catalogo-estatus', compact('estatus'));
    }

    public function estatusdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = StatusUnidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = StatusUnidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        // Fetch records
        $records = StatusUnidad::select('status_unidad.id', 'status_unidad.nombre_status', 'status_unidad.id_status_delete')
            ->where('status_unidad.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_status'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = StatusUnidad::select('status_unidad.id', 'status_unidad.nombre_status', 'status_unidad.id_status_delete')
                    ->where('status_unidad.id_status_delete', 1)
                    ->where("status_unidad.nombre_status", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = StatusUnidad::select('status_unidad.id', 'status_unidad.nombre_status', 'status_unidad.id_status_delete')
            ->where('status_unidad.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);          
        }

        $data_arr = array();
        $pro="";
        foreach($records as $record){

            $data_arr[] = array(
                "id" => $record->id,
                "nombre_status" => $record->nombre_status,
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

    public function guardarestatus(Request $request)
    {
        $data = [
            'nombre_status' => $request->estatus,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        StatusUnidad::insert($data);

        session()->flash('success', 'El estatus se creo correctamente');
    	return redirect()->route('estatus.catalogoestatus');
    }

    public function editarestatus(Request $request)
    {
        $data = [
            'nombre_status' => $request->nombre_estatus,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        StatusUnidad::where('id', $request->id_estatus)->update($data);

        session()->flash('success', 'El estatus se modifico correctamente');
    	return redirect()->route('estatus.catalogoestatus');
    }

    public function eliminarestatus(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	StatusUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El estatus se desactivo correctamente');
    	return redirect()->route('estatus.catalogoestatus');
    }


    public function catalogoestatusinactivos(Request $request)
    {
		$estatus = StatusUnidad::where('id_status_delete', 2)->get();

    	return view('unidades.catalogos.catalogo-estatus-inactivos', compact('estatus'));
    }

    public function activarestatus(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	StatusUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El estatus se activo correctamente');
    	return redirect()->route('estatus.catalogoestatuseliminados');   	
    }

}