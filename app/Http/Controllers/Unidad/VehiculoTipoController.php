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
use App\Models\Unidad\UnidadTipoVehiculo;

class VehiculoTipoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogovehiculotipo()
    {
		$vehiculotipo = UnidadTipoVehiculo::where('id_status_delete', 1)->get();

    	return view('unidades.tipovehiculo.catalogo-tipo-vehiculo', compact('vehiculotipo'));
    }

    public function tipovehiculodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = UnidadTipoVehiculo::select('count(*) as allcount')->count();
        $totalRecordswithFilter = UnidadTipoVehiculo::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = UnidadTipoVehiculo::select('unidad_vehiculo_tipo.id', 'unidad_vehiculo_tipo.vehiculo_tipo', 'unidad_vehiculo_tipo.id_status_delete')
            ->where('unidad_vehiculo_tipo.id_status_delete', 1)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("unidad_vehiculo_tipo.vehiculo_tipo", '=' , $valor);
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
                "nombre" => $record->vehiculo_tipo,
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

    public function guardartipovehiculo(Request $request)
    {
        $data = [
            'vehiculo_tipo' => $request->vehiculo_tipo,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        UnidadTipoVehiculo::insert($data);

        session()->flash('success', 'El tipo de vehículo se creo correctamente');
    	return redirect()->route('vehiculotipo.catalogovehiculotipo');
    }

    public function editartipovehiculo(Request $request)
    {
        $data = [
            'vehiculo_tipo' => $request->vehiculo_tipo,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        UnidadTipoVehiculo::where('id', $request->id_tipo_vehiculo)->update($data);

        session()->flash('success', 'El tipo de vehículo se modifico correctamente');
    	return redirect()->route('vehiculotipo.catalogovehiculotipo');
    }

    public function eliminartipovehiculo(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	UnidadTipoVehiculo::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de vehículo se desactivo correctamente');
    	return redirect()->route('vehiculotipo.catalogovehiculotipo');
    }

    public function catalogotipovehiculoeliminadas()
    {
		$vehiculotipo = UnidadTipoVehiculo::where('id_status_delete', 2)->get();

    	return view('unidades.tipovehiculo.catalogo-tipo-vehiculo-inactivo', compact('vehiculotipo'));    	
    }

    public function activartipovehiculo(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

    	UnidadTipoVehiculo::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de vehículo se desactivo correctamente');
    	return redirect()->route('vehiculotipo.catalogotipovehiculoeliminadas');    	
    }

}