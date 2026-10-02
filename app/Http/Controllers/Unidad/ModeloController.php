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
use App\Models\Unidad\ModeloUnidad;

class ModeloController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogomodelos()
    {
		$modelo = ModeloUnidad::where('id_status_delete', 1)->get();

    	return view('unidades.catalogos.catalogo-modelo', compact('modelo'));
    }

    public function modelodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = ModeloUnidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ModeloUnidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = ModeloUnidad::select('modelo_unidad.id', 'modelo_unidad.nombre_modelo', 'modelo_unidad.id_status_delete')
            ->where('modelo_unidad.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_modelo'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = ModeloUnidad::select('modelo_unidad.id', 'modelo_unidad.nombre_modelo', 'modelo_unidad.id_status_delete')
                    ->where('modelo_unidad.id_status_delete', 1)
                    ->where("modelo_unidad.nombre_modelo", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = ModeloUnidad::select('modelo_unidad.id', 'modelo_unidad.nombre_modelo', 'modelo_unidad.id_status_delete')
            ->where('modelo_unidad.id_status_delete', 1)
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
                "nombre_modelo" => $record->nombre_modelo,
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

    public function guardarmodelo(Request $request)
    {
        $data = [
            'nombre_modelo' => $request->modelo,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        ModeloUnidad::insert($data);

        session()->flash('success', 'La marca se creo correctamente');
    	return redirect()->route('modelos.catalogomodelos');
    }

    public function editarmodelo(Request $request)
    {
        $data = [
            'nombre_modelo' => $request->nombre_modelo,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ModeloUnidad::where('id', $request->id_modelo)->update($data);

        session()->flash('success', 'El modelo se modifico correctamente');
    	return redirect()->route('modelos.catalogomodelos');
    }

    public function desactivarmodelo(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	ModeloUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El modelo se desactivo correctamente');
    	return redirect()->route('modelos.catalogomodelos');
    }

    public function catalogomodelosinactivos()
    {
		$modelo = ModeloUnidad::where('id_status_delete', 2)->get();

    	return view('unidades.catalogos.catalogo-modelo-inactivos', compact('modelo'));   	
    }

    public function activarmodelo(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	ModeloUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'El modelo se activo correctamente');
    	return redirect()->route('modelos.catalogomodelosinactivos');   	
    }

}