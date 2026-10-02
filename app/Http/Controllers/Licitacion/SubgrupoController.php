<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Licitacion\RequisicionGrupo;
use App\Models\Licitacion\RequisicionSubgrupo;

class SubgrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadosubgrupo($id)
    {
        $grupo = RequisicionGrupo::where('id', $id)->where('id_status_delete', 1)->first();
        $subgrupo = RequisicionSubgrupo::where('id_status_delete', 1)->where('requisicion_grupo_id', $id)->get();
        return view('licitaciones.requisicion.catalogo-subgrupo', compact('subgrupo', 'grupo'));
    }

    public function subgrupodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionSubgrupo::select('count(*) as allcount')->where('id_status_delete', 1)->where('requisicion_grupo_id', $request->id)->count();
        $totalRecordswithFilter = RequisicionSubgrupo::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->where('requisicion_grupo_id', $request->id)->count();
        // Fetch records
        $records = RequisicionSubgrupo::select('*')
            ->where('id_status_delete', 1)
            ->where('requisicion_grupo_id', $request->id)
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

    public function guardarsubgrupo(Request $request)
    {

        if (empty($request->tipo_documento)) {
            session()->flash('error', 'El registro no puede estar vacio');
            return redirect()->route('subgrupo.listadocatalogosubgrupo', ['id' => $request->id_grupo]);
        }

        $data = [
            'descripcion' => $request->tipo_documento,
            'requisicion_grupo_id' => $request->id_grupo,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionSubgrupo::insert($data);

        session()->flash('success', 'El registro se creo correctamente');
        return redirect()->route('subgrupo.listadocatalogosubgrupo', ['id' => $request->id_grupo]);
    }

    public function editarsubgrupo(Request $request)
    {

        $data = [
            'descripcion' => $request->tipo_documento,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionSubgrupo::where('id', $request->id_tipo_documento)->update($data);

        session()->flash('success', 'El registro modifico correctamente');
        return redirect()->route('subgrupo.listadocatalogosubgrupo', ['id' => $request->id_grupo]);
    }

    public function desactivarsubgrupo(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionSubgrupo::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se desactivo correctamente');
        return redirect()->route('subgrupo.listadocatalogosubgrupo', ['id' => $request->id_grupo]);
    }

    public function listadosubgrupoinactivas($id)
    {
        $data = RequisicionSubgrupo::where('id_status_delete', 2)->where('requisicion_grupo_id', $id)->get();
        $grupo = RequisicionGrupo::where('id', $id)->where('id_status_delete', 1)->first();
        return view('licitaciones.requisicion.catalogo-subgrupo-inactivos', compact('data', 'grupo'));
    }

    public function activarsubgrupo(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionSubgrupo::where('id', $request->id)->update($data);

        session()->flash('success', 'El registro se activo correctamente');
        return redirect()->route('subgrupo.listadocatalogosubgrupoinactivas', ['id' => $request->id_grupo]);
    }
}
