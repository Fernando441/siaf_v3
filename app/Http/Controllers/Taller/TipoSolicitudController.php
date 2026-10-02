<?php

namespace App\Http\Controllers\Taller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Taller\TallerTipoSolicitud;
use Carbon\Carbon;

class TipoSolicitudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function catalogoTipoSolicitud()
    {
        $tipoSolicitudes = TallerTipoSolicitud::all();
        return view('taller.tipo-solicitud', compact('tipoSolicitudes'));
    }

    public function tipoSolicitudDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TallerTipoSolicitud::all()->count();
        $totalRecordswithFilter = TallerTipoSolicitud::where('tipo', 'like', '%' . $searchValue . '%')->count();
        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';

        $valor = false;
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = TallerTipoSolicitud::where('tipo', 'like', '%' . $valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        if (!$valor) {
            $records = TallerTipoSolicitud::where('tipo', 'like', '%' . $searchValue . '%')
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)->take($rowperpage)->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        foreach ($records as $tipo) {
            $data_arr[] = array(
                "id" => $tipo->id,
                "tipo" => $tipo->tipo,
                "acciones" => null,
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

    public function guardarTipoSolicitud(Request $request)
    {
        $tipoSolicitud = new TallerTipoSolicitud();
        $tipoSolicitud->tipo = $request->tipo;
        $tipoSolicitud->iduserCreated = Auth::user()->id;
        $tipoSolicitud->iduserUpdated = Auth::user()->id;
        $tipoSolicitud->created_at = Carbon::now();
        $tipoSolicitud->updated_at = Carbon::now();
        $tipoSolicitud->save();

        return redirect()->route('taller.catalogotiposolicitud')->with('success', 'Tipo de solicitud guardado correctamente');
    }

    public function editarTipoSolicitud(Request $request)
    {
        $tipoSolicitud = TallerTipoSolicitud::find($request->id_tipo_solicitud);
        $tipoSolicitud->tipo = $request->edit_tipo_solicitud_input;
        $tipoSolicitud->iduserUpdated = Auth::user()->id;
        $tipoSolicitud->updated_at = Carbon::now();
        $tipoSolicitud->save();

        return redirect()->route('taller.catalogotiposolicitud')->with('success', 'Tipo de solicitud actualizado correctamente');
    }
}
