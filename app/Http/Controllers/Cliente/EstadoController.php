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

class EstadoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function catalogoEstado()
    {
        $estados = Estado::where('id_status_delete', 1)->get();

        return view('clientes.estados.catalogo-estados', compact('estados'));
    }

    public function estadosdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Estado::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Estado::select('count(*) as allcount')->where('id_estado', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = Estado::select('estado.id_estado', 'estado.estado_nombre', 'estado.id_status_delete')
            ->where('estado.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("estado.estado_nombre", '=' , $valor);
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
                "id" => $record->id_estado,
                "nombre" => $record->estado_nombre,
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

    public function guardarEstado(Request $request)
    {

        $validated = $request->validate([
            'estado' => 'required',
        ]);

        $data = [
            'estado_nombre' => $request->estado,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id
        ];

        Estado::insert($data);

        session()->flash('success', 'El estado se añadió correctamente');
        return redirect()->route('cliente.catalogoEstado');

    }

    public function editarEstado(Request $request)
    {
        $data = [
            'estado_nombre' => $request->estado,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id
        ];

        Estado::where('id_estado', $request->id_estado)->update($data);

        session()->flash('success', 'El estado se modifico correctamente');
        return redirect()->route('cliente.catalogoEstado');
    }


    public function eliminarEstado(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Estado::where('id_estado', $request->id)->update($data);

        session()->flash('success', 'El estado se desactivo correctamente');
        return redirect()->route('cliente.catalogoEstado');

    }

    public function catalogoestadosinactivos()
    {
        $estados = Estado::where('id_status_delete', 2)->get();

        return view('clientes.estados.catalogo-estados-inactivos', compact('estados'));
    }

    public function activarestado(Request $request){
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        Estado::where('id_estado', $request->id)->update($data);

        session()->flash('success', 'El estado se activo correctamente');
        return redirect()->route('cliente.estadosinactivos');
    }


}
