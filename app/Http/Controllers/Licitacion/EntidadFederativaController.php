<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Licitacion\RequisicionEntidadFederativa;

class EntidadFederativaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadoentidadfederativa()
    {
        $data = RequisicionEntidadFederativa::where('id_status_delete', 1)->get();

        return view('licitaciones.requisicion.catalogo-entidad-federativa', compact('data'));
    }

    public function entidadfederativadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionEntidadFederativa::select('count(*) as allcount')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = RequisicionEntidadFederativa::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = RequisicionEntidadFederativa::select('*')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'descripcion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("descripcion", 'like', '%' . $valor . '%');
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
                "descripcion" => $record->descripcion,
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

    public function guardarentidadfederativa(Request $request)
    {

        if (empty($request->tipo_documento)) {
            session()->flash('error', 'El registro no puede estar vacio');
            return redirect()->route('entidadfederativa.listadocatalogoentidadfederativa');
        }

        $data = [
            'descripcion' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionEntidadFederativa::insert($data);

        session()->flash('success', 'El registro se creo correctamente');
        return redirect()->route('entidadfederativa.listadocatalogoentidadfederativa');
    }

    public function editarentidadfederativa(Request $request)
    {

        $data = [
            'descripcion' => $request->tipo_documento,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionEntidadFederativa::where('id', $request->id_tipo_documento)->update($data);

        session()->flash('success', 'El registro modifico correctamente');
        return redirect()->route('entidadfederativa.listadocatalogoentidadfederativa');
    }

    public function desactivarentidadfederativa(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionEntidadFederativa::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('entidadfederativa.listadocatalogoentidadfederativa');
    }

    public function listadoentidadfederativainactivas()
    {
        $data = RequisicionEntidadFederativa::where('id_status_delete', 2)->get();

        return view('licitaciones.requisicion.catalogo-entidad-federativa-inactivos', compact('data'));
    }

    public function activarentidadfederativa(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionEntidadFederativa::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se activo correctamente');
        return redirect()->route('entidadfederativa.listadocatalogoentidadfederativainactivas');
    }
}
