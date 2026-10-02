<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;

class MunicipioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoMunicipio()
    {
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        return view('clientes.municipios.catalogo-municipios', compact('municipios', 'estados'));
    }

    public function municipiosdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Municipio::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Municipio::select('count(*) as allcount')->where('id_municipio', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Municipio::select('municipio.id_municipio', 'municipio.municipio_nombre', 'municipio.id_estado', 'municipio.id_status_delete', 'es.estado_nombre')
            ->leftjoin("estado as es","es.id_estado","municipio.id_estado")
            ->where('municipio.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("municipio.municipio_nombre", '=' , $valor);
                }
            }

            if($columna['data']=='estado'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("municipio.id_estado", '=' , $valor);
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
                "id" => $record->id_municipio,
                "nombre" => $record->municipio_nombre,
                "estado" => $record->estado_nombre,
                "id_estado" => $record->id_estado,
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

    public function guardarMunicipio(Request $request)
    {

        $validated = $request->validate([
            'municipio' => 'required',
        ]);

        $data = [
            'municipio_nombre' => $request->municipio,
            'id_estado' => $request->estado,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id
        ];

        Municipio::insert($data);

        session()->flash('success', 'El municipio se añadió correctamente');
        return redirect()->route('cliente.catalogoMunicipio');
    }

    public function modificarmunicipio($municipio)
    {
        $info_municipio = Municipio::where('id_municipio', $municipio)->get();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 0)->get();

        return view('clientes.editar-municipio', compact('estados','info_municipio', 'municipio'));
    }

    public function editarMunicipio(Request $request)
    {
        $data = [
            'municipio_nombre' => $request->municipio,
            'id_estado' => $request->id_estado,
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id
        ];

        Municipio::where('id_municipio', $request->id_municipio)->update($data);

        session()->flash('success', 'El municipio se modifico correctamente');
        return redirect()->route('cliente.catalogoMunicipio');

    }

    public function eliminarMunicipio(Request $request)
    {

        $data = [
            'id_status_delete' => 2,
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        Municipio::where('id_municipio', $request->id)->update($data);

        session()->flash('success', 'El municipio se desactivo correctamente');
        return redirect()->route('cliente.catalogoMunicipio');

    }

    public function catalogoemunicipiosinactivos()
    {
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 2)
        ->get();

        return view('clientes.municipios.catalogo-municipios-inactivos', compact('municipios'));
    }

    public function activarmunicipio(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        Municipio::where('id_municipio', $request->id)->update($data);

        session()->flash('success', 'El municipio se activo correctamente');
        return redirect()->route('cliente.municipiosinactivos');
    }

}
