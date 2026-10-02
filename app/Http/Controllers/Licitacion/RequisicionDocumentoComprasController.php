<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Requisicion\RequisicionDocumentosCompras;

class RequisicionDocumentoComprasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function listadodocumentoscompras()
    {
        $data = RequisicionDocumentosCompras::where('id_status_delete', 1)->get();

        return view('licitaciones.requisicion.finanzas.documentacion.catalogo-documentos', compact('data'));
    }

    public function documentosdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionDocumentosCompras::select('count(*) as allcount')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = RequisicionDocumentosCompras::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = RequisicionDocumentosCompras::select('*')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo_documento') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("tipo_documento", 'like', '%' . $valor . '%');
                }
            }
        }

        if ($valor == "No") {
            $records = $records->get();
        } else {
            $records = $records->get();
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro = "";
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "tipo_documento" => $record->tipo_documento,
                'acciones' => null,
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
        if (empty($request->tipo_documento)) {
            session()->flash('error', 'El registro no puede estar vacio');
            return redirect()->route('doccompras.listadodocumentoscompras');
        }

        $data = [
            'tipo_documento' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionDocumentosCompras::insert($data);

        session()->flash('success', 'El registro se creo correctamente');
        return redirect()->route('doccompras.listadodocumentoscompras');
    }

    public function editardocumento(Request $request)
    {

        $data = [
            'tipo_documento' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        RequisicionDocumentosCompras::where('id', $request->id_documento)->update($data);

        session()->flash('success', 'El documento se modifico correctamente');
    	return redirect()->route('doccompras.listadodocumentoscompras');
    }

    public function desactivardocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	RequisicionDocumentosCompras::where('id', $request->id)->update($data);

        session()->flash('success', 'El documento se desactivo correctamente');
    	return redirect()->route('doccompras.listadodocumentoscompras');
    }

    public function catalogodocumentosinactivos()
    {
        $data = RequisicionDocumentosCompras::where('id_status_delete', 2)->get();

        return view('licitaciones.requisicion.finanzas.documentacion.catalogo-documentos-inactivos', compact('data'));   	
    }

    public function activardocumento(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	RequisicionDocumentosCompras::where('id', $request->id)->update($data);

        session()->flash('success', 'El documento se activo correctamente');
    	return redirect()->route('doccompras.documentosinactivos');    	
    }

}