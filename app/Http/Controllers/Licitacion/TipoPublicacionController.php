<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\PublicacionLicitacion;

class TipoPublicacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadopublicacion()
    {
    	$documentos = PublicacionLicitacion::where('status_delete', 0)->get();

    	return view('licitaciones.tipopublicacion.catalogo-publicacion', compact('documentos'));
    }

    public function publicaciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = PublicacionLicitacion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = PublicacionLicitacion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = PublicacionLicitacion::select('publicacion_licitacion.id', 'publicacion_licitacion.publicacion_licitacion', 'publicacion_licitacion.status_delete')
            ->where('publicacion_licitacion.status_delete', 0)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("publicacion_licitacion.publicacion_licitacion", '=' , $valor);
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
                "nombre" => $record->publicacion_licitacion,
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

    public function guardarpublicacion(Request $request)
    {
        $data = [
            'publicacion_licitacion' => $request->publicacion_licitacion,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        PublicacionLicitacion::insert($data);

        session()->flash('success', 'La publicación de licitación se creo correctamente');
    	return redirect()->route('publicacion.listadopublicacion');
    }

    public function editarpublicacion(Request $request)
    {
        $data = [
            'publicacion_licitacion' => $request->publicacion_licitacion,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        PublicacionLicitacion::where('id', $request->id_publicacion)->update($data);

        session()->flash('success', 'La publicación de licitación se modifico correctamente');
    	return redirect()->route('publicacion.listadopublicacion');
    }

    public function desactivarpublicacion(Request $request)
    {
        $data = [
            'status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        PublicacionLicitacion::where('id', $request->id)->update($data);

        session()->flash('success', 'La publicación de licitación se desactivo correctamente');
        return redirect()->route('publicacion.listadopublicacion');
    }

    public function catalogopublicacionesinactivas()
    {
        $documentos = PublicacionLicitacion::where('status_delete', 1)->get();

        return view('licitaciones.tipopublicacion.catalogo-publicacion-inactivas', compact('documentos'));
    }

    public function activarpublicacion(Request $request)
    {
        $data = [
            'status_delete' => 0,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        PublicacionLicitacion::where('id', $request->id)->update($data);

        session()->flash('success', 'La publicación de licitación se activo correctamente');
        return redirect()->route('publicacion.publicacionesinactivas');   	
    }

}