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
use App\Models\Taller\ServicioTaller;
use App\Models\Taller\TipoDocumentoTaller;
use Carbon\Carbon;

class TipoDocumentoTallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tipodocumentotaller()
    {
		$documento = TipoDocumentoTaller::where('id_status_delete', 1)->get();

    	return view('taller.tipodocumentos.catalogo-documentos', compact('documento'));
    }

    public function tipodocumentotallerdatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = TipoDocumentoTaller::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TipoDocumentoTaller::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();

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
        $records = TipoDocumentoTaller::select('taller_tipo_documento.id', 'taller_tipo_documento.tipo_documento', 'taller_tipo_documento.id_status_delete')
            ->where('taller_tipo_documento.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='tipo_documento'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);

                    $records = TipoDocumentoTaller::select('taller_tipo_documento.id', 'taller_tipo_documento.tipo_documento', 'taller_tipo_documento.id_status_delete')
                    ->where('taller_tipo_documento.id_status_delete', 1)
                    ->where("taller_tipo_documento.tipo_documento", '=' , $valor)
                    ->orderBy($order_column_name, $order_column_dir)
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                }
            }
        }

        if($valor == "No"){
            $records = TipoDocumentoTaller::select('taller_tipo_documento.id', 'taller_tipo_documento.tipo_documento', 'taller_tipo_documento.id_status_delete')
            ->where('taller_tipo_documento.id_status_delete', 1)
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
                "tipo_documento" => $record->tipo_documento,
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

    public function guardartipodocumentotall(Request $request)
    {
        $data = [
            'tipo_documento' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        TipoDocumentoTaller::insert($data);

        session()->flash('success', 'El tipo de documento se creo correctamente');
    	return redirect()->route('tipdoctaller.tipodocumentotaller');
    }

    public function editartipodocumentotaller(Request $request)
    {
        $data = [
            'tipo_documento' => $request->tipo_documento,
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  

        TipoDocumentoTaller::where('id', $request->id_servicio)->update($data);

        session()->flash('success', 'El tipo de documento se modifico correctamente');
    	return redirect()->route('tipdoctaller.tipodocumentotaller');
    }

    public function desactivartipdoctaler(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TipoDocumentoTaller::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se desactivo correctamente');
    	return redirect()->route('tipdoctaller.tipodocumentotaller');
    }

    public function catalogotipdoctallerinactivas()
    {
		$documento = TipoDocumentoTaller::where('id_status_delete', 2)->get();

    	return view('taller.tipodocumentos.catalogo-documentos-inactivos', compact('documento'));   	
    }

    public function activartipodocumentotaller(Request $request)
    {
         $data = [
            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];  
    	TipoDocumentoTaller::where('id', $request->id)->update($data);

        session()->flash('success', 'El tipo de documento se activo correctamente');
    	return redirect()->route('tipdoctaller.catalogotipdoctallerinactivas');   
    }

}