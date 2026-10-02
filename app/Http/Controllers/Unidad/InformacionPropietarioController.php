<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Unidad\InformacionPropietario;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use App\Models\Cliente\ClienteTipoDocumento;

class InformacionPropietarioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function infopropietario()
    {
		$propietario = InformacionPropietario::where('id_status_delete', 1)->get();

    	return view('unidades.tramitesvehiculares.informacionpropietario.catalogo-informacion-propietario', compact('propietario'));
    }

    public function infopropietariodatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = InformacionPropietario::select('count(*) as allcount')->count();
        $totalRecordswithFilter = InformacionPropietario::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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

        // Fetch records
        $records = InformacionPropietario::select('unidad_informacion_propietario.id', 'unidad_informacion_propietario.nombre_propietario', 'unidad_informacion_propietario.rfc','unidad_informacion_propietario.no_identificacion', 'unidad_informacion_propietario.direccion', 'unidad_informacion_propietario.id_status_delete')
            ->where('unidad_informacion_propietario.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_propietario'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = InformacionPropietario::select('unidad_informacion_propietario.id', 'unidad_informacion_propietario.nombre_propietario', 'unidad_informacion_propietario.rfc', 
        	 'unidad_informacion_propietario.no_identificacion', 'unidad_informacion_propietario.direccion', 'unidad_informacion_propietario.id_status_delete')
                    ->where('unidad_informacion_propietario.id_status_delete', 1)
                    ->where("unidad_informacion_propietario.nombre_propietario", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = InformacionPropietario::select('unidad_informacion_propietario.id', 'unidad_informacion_propietario.nombre_propietario', 'unidad_informacion_propietario.rfc', 
        	 'unidad_informacion_propietario.no_identificacion', 'unidad_informacion_propietario.direccion', 'unidad_informacion_propietario.id_status_delete')
            ->where('unidad_informacion_propietario.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);          
        }

        $data_arr = array();
        $pro="";
        foreach($records as $record){

            $data_arr[] = array(
                "id" => $record->id,
                "nombre_propietario" => $record->nombre_propietario,
                "rfc" => $record->rfc,
                "no_identificacion" => $record->no_identificacion,
                "direccion" => $record->direccion,
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

    public function agregarpropietario()
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        $documentos = ClienteTipoDocumento::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.informacionpropietario.agregar-propietario', compact('estados', 'municipios', 'cadenaTipoDocumento'));
    }

    public function guardarpropietario(Request $request)
    {

        $data = [
            'nombre_propietario' => $request->nombre_propietario,
            'rfc' => $request->rfc,
            'no_identificacion' => $request->no_identificacion,
            'direccion' => $request->direccion,
            'estado_id' => $request->estado_id,
            'ciudad_id' => $request->ciudad_id,
            'cp' => $request->cp,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];

        InformacionPropietario::insert($data);

        session()->flash('success', 'La información del propietario se añadió correctamente');
        return redirect()->route('propietario.infopropietario');

    }

    public function vistaeditarpropietario($id_propietario)
    {
        $propietario = InformacionPropietario::where('id',$id_propietario)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        $documentos = ClienteTipoDocumento::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        return view('unidades.tramitesvehiculares.informacionpropietario.editar-propietario', compact('estados', 'municipios', 'cadenaTipoDocumento', 'propietario'));       
    }

    public function modificarpropietario(Request $request)
    {
        $data = [
            'nombre_propietario' => $request->nombre_propietario,
            'rfc' => $request->rfc,
            'no_identificacion' => $request->no_identificacion,
            'direccion' => $request->direccion,
            'estado_id' => $request->estado_id,
            'ciudad_id' => $request->ciudad_id,
            'cp' => $request->cp,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];

        InformacionPropietario::where('id', $request->id_propietario)->update($data);   
        
        session()->flash('success', 'La información del propietario se modifico correctamente');
        return redirect()->route('propietario.infopropietario');        
    }

    public function eliminarpropietario(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        InformacionPropietario::where('id', $request->id)->update($data);

        session()->flash('success', 'El propietario se desactivo correctamente');
        return redirect()->route('propietario.infopropietario');
    }

    public function catalogopropietariosinactivos()
    {
        $propietario = InformacionPropietario::where('id_status_delete', 2)->get();

        return view('unidades.tramitesvehiculares.informacionpropietario.catalogo-informacion-propietario-inactivos', compact('propietario'));        
    }

    public function activarpropietario(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        InformacionPropietario::where('id', $request->id)->update($data);

        session()->flash('success', 'El propietario se activo correctamente');
        return redirect()->route('propietario.catalogopropietariosinactivos');        
    }

    public function verpropietario($id_propietario)
    {
        $propietario = InformacionPropietario::where('id',$id_propietario)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        return view('unidades.tramitesvehiculares.informacionpropietario.ver-propietario', compact('estados', 'municipios', 'propietario')); 
    }

}