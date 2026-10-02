<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\Afianzadora;

class AfianzadoraController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadoafianzadora()
    {
    	$afianzadora = Afianzadora::where('id_status_delete', 1)->get();

    	return view('licitaciones.afianzadoras.catalogo-afianzadoras', compact('afianzadora'));    	
    }

    public function afianzadoradatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Afianzadora::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Afianzadora::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Afianzadora::select('afianzadoras.id', 'afianzadoras.nombre_afianzadora', 'afianzadoras.id_status_delete')
            ->where('afianzadoras.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("afianzadoras.nombre_afianzadora", '=' , $valor);
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
                "nombre" => $record->nombre_afianzadora,
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

    public function guardarafianzadora(Request $request)
    {
        $data = [
            'nombre_afianzadora' => $request->nombre_afianzadora,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Afianzadora::insert($data);

        session()->flash('success', 'La afianzadora se creo correctamente');
    	return redirect()->route('afianzadora.listadocatalogoafianzadora');
    }

    public function editarafianzadora(Request $request)
    {
        $data = [
            'nombre_afianzadora' => $request->nombre_afianzadora,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        Afianzadora::where('id', $request->id_afianzadora)->update($data);

        session()->flash('success', 'La afianzadora se modifico correctamente');
    	return redirect()->route('afianzadora.listadocatalogoafianzadora');
    }

    public function desactivarafianzadora(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        Afianzadora::where('id', $request->id)->update($data);

        session()->flash('success', 'La afianzadora se desactivo correctamente');
       	return redirect()->route('afianzadora.listadocatalogoafianzadora');
    }

    public function listadoafianzadorainactivas()
    {
    	$afianzadora = Afianzadora::where('id_status_delete', 2)->get();

    	return view('licitaciones.afianzadoras.catalogo-afianzadoras-inactivas', compact('afianzadora'));       	
    }

    public function activarafianzadora(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        Afianzadora::where('id', $request->id)->update($data);

        session()->flash('success', 'La afianzadora se activo correctamente');
        return redirect()->route('afianzadora.listadocatalogoafianzadorainactivas'); 
    }


}