<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\UnidadMovimientos;

class UbicacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoubicaciones()
    {
		$ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

    	return view('unidades.catalogos.catalogo-ubicaciones', compact('ubicacion'));
    }

    public function ubicaciondatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = UbicacionUnidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = UbicacionUnidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = UbicacionUnidad::select('ubicacion_unidad.id', 'ubicacion_unidad.ubicacion', 'ubicacion_unidad.id_status_delete',  'ubicacion_unidad.codigo')
            ->where('ubicacion_unidad.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("ubicacion_unidad.ubicacion", '=' , $valor);
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
                "nombre" => $record->ubicacion,
                "codigo" => $record->codigo,
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

    public function guardarubicacion(Request $request)
    {
        $data = [
            'ubicacion' => $request->ubicacion,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        UbicacionUnidad::insert($data);

        session()->flash('success', 'La ubicación se creo correctamente');
    	return redirect()->route('ubicacion.catalogoubicaciones');
    }

    public function editarubicacion(Request $request)
    {

        $data = [
            'ubicacion' => $request->ubicacion,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        UbicacionUnidad::where('id', $request->id_ubicacion)->update($data);

        session()->flash('success', 'La ubicación se modifico correctamente');
    	return redirect()->route('ubicacion.catalogoubicaciones');
    }

    public function desactivarubicacion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	UbicacionUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La ubicación se desactivo correctamente');
    	return redirect()->route('ubicacion.catalogoubicaciones');
    }

    public function catalogoubicacionesinactivas(Request $request)
    {
		$ubicacion = UbicacionUnidad::where('id_status_delete', 2)->get();

    	return view('unidades.catalogos.catalogo-ubicaciones-inactivas', compact('ubicacion'));
    }

    public function activarubicacion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	UbicacionUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La ubicación se activo correctamente');
    	return redirect()->route('ubicacion.catalogoubicacionesinactivas');
    }

    public function verubicacion($ubicacion)
    {
        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.id_ubicacion', $ubicacion)->get();

        return view('unidades.catalogos.listado-unidades', compact('ubicacion_data'));       
    }

}