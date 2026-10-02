<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\LicitacionInformacionFinanciera;

class PropTecFinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadoproptecfin()
    {
        $data = LicitacionInformacionFinanciera::where('id_status_delete', 1)->get();

        return view('licitaciones.propuestatecnica.catalogo-informacion-financiera', compact('data'));
    }

    public function proptecfindatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = LicitacionInformacionFinanciera::select('count(*) as allcount')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = LicitacionInformacionFinanciera::select('count(*) as allcount')->where('id_status_delete', 1)->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = LicitacionInformacionFinanciera::select('licitacion_informacion_financiera.id', 'licitacion_informacion_financiera.informacion')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'informacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("informacion", 'like', '%' . $valor . '%');
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
                "informacion" => $record->informacion,
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

    public function guardarproptecfin(Request $request)
    {

        if (empty($request->tipo_documento)) {
            session()->flash('error', 'El campo tipo de documento no puede estar vacio');
            return redirect()->route('proptecfin.listadoproptecfin');
        }

        $data = [
            'informacion' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LicitacionInformacionFinanciera::insert($data);

        session()->flash('success', 'El tipo de documetno se creo correctamente');
        return redirect()->route('proptecfin.listadoproptecfin');
    }

    public function editarproptecfin(Request $request)
    {

        $data = [
            'informacion' => $request->tipo_documento,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LicitacionInformacionFinanciera::where('id', $request->id_tipo_documento)->update($data);

        session()->flash('success', 'El tipo de documetno modifico correctamente');
        return redirect()->route('proptecfin.listadoproptecfin');
    }

    public function desactivarproptecfin(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LicitacionInformacionFinanciera::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documetno se desactivo correctamente');
        return redirect()->route('proptecfin.listadoproptecfin');
    }

    public function catalogoproptecfininactivas()
    {
        $data = LicitacionInformacionFinanciera::where('id_status_delete', 2)->get();

        return view('licitaciones.propuestatecnica.catalogo-informacion-financiera-inactivos', compact('data'));
    }

    public function activarproptecfin(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LicitacionInformacionFinanciera::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documetno se activo correctamente');
        return redirect()->route('proptecfin.proptecfininactivas');
    }
}
