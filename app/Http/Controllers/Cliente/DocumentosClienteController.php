<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Cliente\ClienteTipoDocumento;

class DocumentosClienteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoDocumentos()
    {
        $documento = ClienteTipoDocumento::where('id_status_delete', 1)->get();

        return view('clientes.tipodocumento.catalogo-documentos', compact('documento'));
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
        $totalRecords = ClienteTipoDocumento::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ClienteTipoDocumento::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = ClienteTipoDocumento::select('cliente_tipo_documento.id', 'cliente_tipo_documento.tipo', 'cliente_tipo_documento.id_status_delete')
            ->where('cliente_tipo_documento.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("cliente_tipo_documento.tipo", '=' , $valor);
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
                "nombre" => $record->tipo,
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

    public function guardartipodocumento(Request $request)
    {
        $data = [
            'tipo' => $request->tipo,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        ClienteTipoDocumento::insert($data);

        session()->flash('success', 'El tipo de documento se creo correctamente');
    	return redirect()->route('doccliente.catalogoDocumentos');
    }

    public function editartipoDocumento(Request $request)
    {
        $data = [
            'tipo' => $request->tipo,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        ClienteTipoDocumento::where('id', $request->id_documento)->update($data);

        session()->flash('success', 'El tipo de documento se modifico correctamente');
    	return redirect()->route('doccliente.catalogoDocumentos');
    }

    public function eliminartipoDocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	ClienteTipoDocumento::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se desactivo correctamente');
    	return redirect()->route('doccliente.catalogoDocumentos');
    }

    public function catalogoetipodocumentosinactivos()
    {
        $documento = ClienteTipoDocumento::where('id_status_delete', 2)->get();

        return view('clientes.tipodocumento.catalogo-documentos-inactivos', compact('documento'));   	
    }

    public function activartipodocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	ClienteTipoDocumento::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se activo correctamente');
    	return redirect()->route('doccliente.tipodocumentosinactivos');    	
    }

}