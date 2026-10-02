<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\TipoDocumentoLicitacion;

class TipoDocumentoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function listadodocumentos()
    {
    	$documentos = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();

    	return view('licitaciones.tipodocumentos.catalogo-licitaciones', compact('documentos'));
    }

    public function documentodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TipoDocumentoLicitacion::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TipoDocumentoLicitacion::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = TipoDocumentoLicitacion::select('tipo_documentos_licitaciones.id', 'tipo_documentos_licitaciones.documento_licitacion', 'tipo_documentos_licitaciones.id_status_delete')
            ->where('tipo_documentos_licitaciones.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("tipo_documentos_licitaciones.documento_licitacion", '=' , $valor);
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
                "nombre" => $record->documento_licitacion,
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

    public function guardardocumento(Request $request)
    {
        $data = [
            'documento_licitacion' => $request->documento_licitacion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoDocumentoLicitacion::insert($data);

        session()->flash('success', 'El tipo de documento se creo correctamente');
    	return redirect()->route('documentos.listadodocumentos');

    }

    public function editardocumento(Request $request)
    {
        $data = [
            'documento_licitacion' => $request->documento_licitacion,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TipoDocumentoLicitacion::where('id', $request->id_documento)->update($data);

        session()->flash('success', 'El tipo de documento se modifico correctamente');
    	return redirect()->route('documentos.listadodocumentos');
    }

    public function eliminardocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
        TipoDocumentoLicitacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se desactivo correctamente');
        return redirect()->route('documentos.listadodocumentos');
    }

    public function catalogodocumentosinactivos()
    {
        $documentos = TipoDocumentoLicitacion::where('id_status_delete', 2)->get();

        return view('licitaciones.tipodocumentos.catalogo-licitaciones-inactivas', compact('documentos'));
    }

    public function activardocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TipoDocumentoLicitacion::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se activo correctamente');
        return redirect()->route('documentos.docmuentosinactivos');       
    }

}