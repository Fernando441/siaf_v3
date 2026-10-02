<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad\ProveedorCategoria;
use Illuminate\Http\Request;

class ProveedorCategoriaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function listado()
    {
        $metodos = ProveedorCategoria::where('id_status_delete', 1)->get();

        return view('unidades.proveedorcategoria.catalogo', compact('metodos'));
    }

    public function datatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = ProveedorCategoria::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ProveedorCategoria::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = ProveedorCategoria::select('id', 'categoria', 'id_status_delete')
            ->where('id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("categoria", '=', $valor);
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
                "tipo" => $record->categoria,
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

    public function guardar(Request $request)
    {
        $categoria = ProveedorCategoria::where('categoria', $request->tipo)->first();
        if ($categoria != null) {
            session()->flash('warning', 'El tipo de proveedor ya existe, verifica los datos ingresados');
            return redirect()->route('ProvCategoria.listado');
        }

        $data = [
            'categoria' => $request->tipo,
            'id_status_delete' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        ProveedorCategoria::insert($data);

        session()->flash('success', 'El tipo de proveedor se creo correctamente');
        return redirect()->route('ProvCategoria.listado');
    }

    public function editar(Request $request)
    {

        $categoria = ProveedorCategoria::where('categoria', $request->tipo)->first();
        if ($categoria && $categoria->categoria != $request->tipo) {
            session()->flash('warning', 'La categoria ya existe, verifica los datos ingresados');
            return redirect()->route('ProvCategoria.listado');
        }

        $data = [
            'categoria' => $request->tipo,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        ProveedorCategoria::where('id', $request->id_proveedorcategoria)->update($data);

        session()->flash('success', 'La categoria se modifico correctamente');
        return redirect()->route('ProvCategoria.listado');
    }

    public function desactivar(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        ProveedorCategoria::where('id', $request->id)->update($data);

        session()->flash('success', 'El método de pago se desactivo correctamente');
        return redirect()->route('ProvCategoria.listado');
    }

    public function inactivas()
    {
        $metodos = ProveedorCategoria::where('id_status_delete', 2)->get();

        return view('unidades.proveedorcategoria.inactivas', compact('metodos'));
    }

    public function activar(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        ProveedorCategoria::where('id', $request->id)->update($data);

        session()->flash('success', 'El la categoria de proveedor se activo correctamente');
        return redirect()->route('ProvCategoria.inactivas');
    }
}
