<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\RequisicionCfdi;

class CatalogoCfdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadocatalogocfdi()
    {
        $data = RequisicionCfdi::where('id_status_delete', 1)->get();

        return view('licitaciones.requisicion.catalogo-cfdi', compact('data'));
    }

    public function catalogocfdidatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionCfdi::select('count(*) as allcount')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = RequisicionCfdi::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = RequisicionCfdi::select('*')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'uso_cfdi') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("uso_cfdi", 'like', '%' . $valor . '%');
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
                "uso_cfdi" => $record->uso_cfdi,
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

    public function guardarcatalogocfdi(Request $request)
    {

        if (empty($request->tipo_documento)) {
            session()->flash('error', 'El registro no puede estar vacio');
            return redirect()->route('catalogocfdi.listadocatalogocfdi');
        }

        $data = [
            'uso_cfdi' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionCfdi::insert($data);

        session()->flash('success', 'El registro se creo correctamente');
        return redirect()->route('catalogocfdi.listadocatalogocfdi');
    }

    public function editarcatalogocfdi(Request $request)
    {

        $data = [
            'uso_cfdi' => $request->tipo_documento,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionCfdi::where('id', $request->id_tipo_documento)->update($data);

        session()->flash('success', 'El registro modifico correctamente');
        return redirect()->route('catalogocfdi.listadocatalogocfdi');
    }

    public function desactivarcatalogocfdi(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionCfdi::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('catalogocfdi.listadocatalogocfdi');
    }

    public function catalogocatalogocfdiinactivas()
    {
        $data = RequisicionCfdi::where('id_status_delete', 2)->get();

        return view('licitaciones.requisicion.catalogo-cfdi-inactivos', compact('data'));
    }

    public function activarcatalogocfdi(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionCfdi::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se activo correctamente');
        return redirect()->route('catalogocfdi.catalogocatalogocfdiinactivas');
    }
}
