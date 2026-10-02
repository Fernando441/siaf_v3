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
use App\Models\Unidad\AseguradoraUnidad;

class AseguradoraController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoaseguradoras()
    {
		$aseguradoras = AseguradoraUnidad::where('id_status_delete', 1)->get();

    	return view('unidades.aseguradora.catalogo-aseguradoras', compact('aseguradoras'));
    }

    public function aseguradoradatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = AseguradoraUnidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AseguradoraUnidad::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
            'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
            'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
            ->where('aseguradora_unidad.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='nombre_aseguradora'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
                    'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
                    'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
                    ->where('aseguradora_unidad.id_status_delete', 1)
                    ->where("aseguradora_unidad.nombre_aseguradora", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
            if($columna['data']=='nombre_contacto'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
                    'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
                    'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
                    ->where('aseguradora_unidad.id_status_delete', 1)
                    ->where("aseguradora_unidad.nombre_contacto", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
            if($columna['data']=='email_contacto'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
                    'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
                    'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
                    ->where('aseguradora_unidad.id_status_delete', 1)
                    ->where("aseguradora_unidad.email_contacto", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
            if($columna['data']=='telefono_contacto'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
                    'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
                    'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
                    ->where('aseguradora_unidad.id_status_delete', 1)
                    ->where("aseguradora_unidad.telefono_contacto", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }


        }

        if($valor == "No"){
            $records = AseguradoraUnidad::select('aseguradora_unidad.id', 'aseguradora_unidad.nombre_aseguradora', 
            'aseguradora_unidad.nombre_contacto', 'aseguradora_unidad.email_contacto', 'aseguradora_unidad.telefono_contacto',
            'aseguradora_unidad.calle','aseguradora_unidad.colonia','aseguradora_unidad.cp','aseguradora_unidad.id_status_delete')
            ->where('aseguradora_unidad.id_status_delete', 1)
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
                "nombre_aseguradora" => $record->nombre_aseguradora,
                "nombre_contacto" => $record->nombre_contacto,
                "email_contacto" => $record->email_contacto,
                "telefono_contacto" => $record->telefono_contacto,
                "calle" => $record->calle,
                "colonia" => $record->colonia,
                "cp" => $record->cp,
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

    public function crearaseguradoras()
    {   
        return view('unidades.aseguradora.crear-aseguradora');
    }

    public function guardaraseguradora(Request $request)
    {

        $data = [
            'nombre_aseguradora' => $request->nombre_aseguradora,
            'nombre_contacto' => $request->nombre_contacto,
            'email_contacto' => $request->email_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'calle' => $request->calle, 
            'colonia' => $request->colonia, 
            'cp' => $request->cp, 
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        AseguradoraUnidad::insert($data);

        session()->flash('success', 'La aseguradora se creo correctamente');
    	return redirect()->route('aseguradora.catalogoaseguradora');
    }

    public function modificaraseguradoras($aseguradora)
    {
        $aseguradora_info = AseguradoraUnidad::where('id', $aseguradora)->get();

        return view('unidades.aseguradora.editar-aseguradora', compact('aseguradora_info'));
    }



    public function editaraseguradora(Request $request)
    {
        $data = [
            'nombre_aseguradora' => $request->nombre_aseguradora,
            'nombre_contacto' => $request->nombre_contacto,
            'email_contacto' => $request->email_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'calle' => $request->calle, 
            'colonia' => $request->colonia, 
            'cp' => $request->cp, 
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        AseguradoraUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La aseguradora se modifico correctamente');
    	return redirect()->route('aseguradora.catalogoaseguradora');
    }

    public function eliminaraseguradora(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	AseguradoraUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La aseguradora se desactivo correctamente');
    	return redirect()->route('aseguradora.catalogoaseguradora');
    }

    public function catalogoaseguradorasinactivas(Request $request)
    {
		$aseguradoras = AseguradoraUnidad::where('id_status_delete', 2)->get();

    	return view('unidades.aseguradora.catalogo-aseguradoras-inactivas', compact('aseguradoras'));
    }

    public function activaraseguradora(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	AseguradoraUnidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La aseguradora se activo correctamente');
    	return redirect()->route('aseguradora.catalogoaseguradoraseliminadas');   	
    }

}