<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\PublicacionLicitacion;

use App\Models\Requisicion\RequisicionOrdenCompra;
use App\Models\Requisicion\RequisicionOrdenProveedor;
use App\Models\Requisicion\RequisicionOrdenPartida;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;

class OrdenCompraController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoOrdencompra()
    {
    	$ordencompra = RequisicionOrdenCompra::get();


        $ordencompra = RequisicionOrdenCompra::select('requisicion_orden_compra.id', 'requisicion_orden_compra.requisicion_id', 're.estatus','us.name', 'ap.nombre_area', 'rq.fecha_solicitud')
            ->leftjoin("requisicion as rq", "rq.id", "requisicion_orden_compra.requisicion_id")
            ->leftjoin("requisicion_estatus as re", "re.id", "rq.requisicion_estatus_id")
            ->leftjoin("users as us", "us.id", "rq.solicitante")
            ->leftjoin("area_personal as ap", "ap.id", "rq.id_area")
            ->get();

    	return view('licitaciones.requisicion.ordencompra.catalogo-ordencompra', compact('ordencompra'));
    }

    public function ordencompraDatatable(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequisicionOrdenCompra::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RequisicionOrdenCompra::select('count(*) as allcount')->where('id', 'like', '%' .$searchValue . '%')->count();
        // Fetch records
        $records = RequisicionOrdenCompra::select('requisicion_orden_compra.id', 'requisicion_orden_compra.requisicion_id', 're.estatus','us.name', 'ap.nombre_area', 'rq.fecha_solicitud')
            ->leftjoin("requisicion as rq", "rq.id", "requisicion_orden_compra.requisicion_id")
            ->leftjoin("requisicion_estatus as re", "re.id", "rq.requisicion_estatus_id")
            ->leftjoin("users as us", "us.id", "rq.solicitante")
            ->leftjoin("area_personal as ap", "ap.id", "rq.id_area")
            ->where('rq.requisicion_estatus_id', 2)
            ->orWhere('rq.requisicion_estatus_id', 4)
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";   
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='requisicion_id'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("requisicion_orden_compra.requisicion_id", '=' , $valor);
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
                "solicitante" => $record->name,
                "area" => $record->nombre_area,
                "estatus" => $record->estatus,
                "fecha_solicitud" => $record->fecha_solicitud,
                "requisicion" => $record->requisicion_id,
                "permisos" => $permiso_array,
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

    public function verordenpago($requisicion_id, $orden_id)
    {

        $or_comp = RequisicionOrdenCompra::where('requisicion_id', $requisicion_id)->first();
        $or_prov = RequisicionOrdenProveedor::where('orden_compra_id', $orden_id)->get();
        $or_partidas = RequisicionOrdenPartida::where('orden_compra_id', $orden_id)->get(); 

        return view('licitaciones.requisicion.ordencompra.ver-orden-compra', compact('requisicion_id', 'orden_id','or_comp','or_prov','or_partidas'));
    }

    public function verOrdenPagoPDF($requisicion_id, $orden_id, $id)
    {

        $or_comp = RequisicionOrdenCompra::where('requisicion_id', $requisicion_id)->first();
        $or_prov = RequisicionOrdenProveedor::where('id', $id)->get();
        $or_partidas = RequisicionOrdenPartida::where('orden_compra_id', $orden_id)->get();

        $header = view('licitaciones.requisicion.finanzas.orden-compra-pdf-header', compact('requisicion_id', 'orden_id', 'or_comp', 'or_prov', 'or_partidas'))->render();
        $footer = view('licitaciones.requisicion.finanzas.orden-compra-pdf-footer')->render();
        $body = view('licitaciones.requisicion.finanzas.orden-compra-pdf-body', compact('requisicion_id', 'orden_id', 'or_comp', 'or_prov', 'or_partidas'))->render();

        $path = public_path() . '/theme/assets/media/logos/logojetvan-pdf.jpg';
        
        $mpdf = new Mpdf(['format' => [216, 340]]);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($body);
        if(File::exists($path)) {
            $mpdf->imageVars['logo'] = File::get($path);
        }
        $mpdf->Output();

    }
}