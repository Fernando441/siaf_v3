<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Requisicion\RequisicionFormaPago;

class FormaPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadoformaspago()
    {
        $formas_pago = RequisicionFormaPago::where('id_status_delete', 1)->get();

        return view('licitaciones.formapago.catalogo-formapago', compact('formas_pago'));
    }

    public function formapagodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionFormaPago::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RequisicionFormaPago::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = RequisicionFormaPago::select('requisicion_forma_pago.id', 'requisicion_forma_pago.forma_pago', 'requisicion_forma_pago.id_status_delete')
            ->where('requisicion_forma_pago.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'forma_pago') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("requisicion_forma_pago.forma_pago", 'like', '%' . $valor . '%');
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
                "forma_pago" => $record->forma_pago,
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

    public function guardarformapago(Request $request)
    {

        if (empty($request->forma_pago)) {
            session()->flash('error', 'El campo forma de pago no puede estar vacio');
            return redirect()->route('formapago.listadoformapago');
        }

        $data = [
            'forma_pago' => $request->forma_pago,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionFormaPago::insert($data);

        session()->flash('success', 'La forma de pago se creo correctamente');
        return redirect()->route('formapago.listadoformapago');
    }

    public function editarformapago(Request $request)
    {

        $data = [
            'forma_pago' => $request->forma_pago,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionFormaPago::where('id', $request->id_formapago)->update($data);

        session()->flash('success', 'La forma de pago se modifico correctamente');
        return redirect()->route('formapago.listadoformapago');
    }

    public function desactivarformapago(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionFormaPago::where('id', $request->id)->update($data);

        session()->flash('success', 'La forma de pago se desactivo correctamente');
        return redirect()->route('formapago.listadoformapago');
    }

    public function catalogoformapagoinactivas()
    {
        $formas_pago = RequisicionFormaPago::where('id_status_delete', 2)->get();

        return view('licitaciones.formapago.catalogo-formapago-inactivo', compact('formas_pago'));
    }

    public function activarformapago(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        RequisicionFormaPago::where('id', $request->id)->update($data);

        session()->flash('success', 'La forma de pago se activo correctamente');
        return redirect()->route('formapago.formapagoinactivas');
    }
}
