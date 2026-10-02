<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use App\Services\Folio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion\RequisicionCfdi;
use App\Models\Requisicion\AreaPersonal;
use App\Models\Requisicion\Requisicion;
use App\Models\Requisicion\RequisicionEstatus;
use App\Models\Requisicion\RequisicionPartida;
use App\Models\Requisicion\RequisicionPartidaEstatus;
use App\Models\Requisicion\RequisicionFormaPago;
use App\Models\Requisicion\RequisicionMetodoPago;
use App\Models\Requisicion\RequisicionOrdenCompra;
use App\Models\Requisicion\RequisicionOrdenProveedor;
use App\Models\Requisicion\RequisicionOrdenPartida;
use App\Models\Licitacion\RequisicionPartidaEquipamiento;
use App\Models\Licitacion\RequisicionPartidaAseguramiento;
use App\Models\Licitacion\RequisicionPartidaEmplacamiento;
use App\Models\Licitacion\RequisicionPartidaLugarEntrega;

use App\Models\Segmento\TipoVehiculo;
use App\Models\Segmento\Segmento;
use App\Models\Unidad\Proveedores;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\UnidadRequisicionEstatus;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use App\Models\Logistica\AsignacionLogistica;
use App\Models\Logistica\AsignacionTipoDocumento;
use App\Models\Logistica\AsignacionDocumento;

class RequisicionOperacionesController extends Controller
{
    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function catalogoRequisicionOperaciones()
    {
        return view('licitaciones.requisicion.operaciones.catalogo-requisicion-operaciones');
    }

    public function requisicionoperacionesDatatable(Request $request)
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
        $totalRecords = Requisicion::all()->count();
        $totalRecordswithFilter = Requisicion::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->where('requisicion_estatus_id', 2)->orWhere('requisicion_estatus_id', 4)->count();

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


        $records = Requisicion::select('*')
            ->where('id', 'like', '%' . $searchValue . '%')
            ->where('requisicion_estatus_id', 2)
            ->orWhere('requisicion_estatus_id', 4)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        foreach ($columnName_arr as $indice => $columna) {

            if ($columna['data'] == 'folio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->where('folio', 'like', '%' . $valor . '%')
                        ->where('requisicion_estatus_id', 2)
                        ->orWhere('requisicion_estatus_id', 4)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }

            if ($columna['data'] == 'solicitante') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->where('id', 'like', '%' . $searchValue . '%')
                        ->where('solicitante', 'like', '%' . $valor . '%')
                        ->where('requisicion_estatus_id', 2)
                        ->orWhere('requisicion_estatus_id', 4)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }

            if ($columna['data'] == 'area') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->where('id', 'like', '%' . $searchValue . '%')
                        ->where('area', 'like', '%' . $valor . '%')
                        ->where('requisicion_estatus_id', 2)
                        ->orWhere('requisicion_estatus_id', 4)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "folio" => $record->folio,
                "solicitante" => $record->usersolicitante->name,
                "area" => $record->areaPersonal->nombre_area,
                "estatus" => $record->requisicionEstatus->estatus,
                "fecha_solicitud" => $record->fecha_solicitud,
                "op_estatus" => $record->requisicion_estatus_id,
                "permisos" => $permiso_array,
                'acciones' => null
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


    public function verRequisicionoperaciones($id)
    {

        $requisicion = Requisicion::find($id);
        $partidas = RequisicionPartida::where('requisicion_id', $id)->where('id_status_delete', 1)->get();

        $segmento = Segmento::where('id_status_delete', 1)->get();
        //Avance financiero en formato json
        $cadenatipovehiculo = "";
        foreach ($segmento as $av) {

            $cadenatipovehiculo .= '"' . $av->id . '":"' . $av->segmentoTipoVehiculo->tipo_vehiculo . ", " . $av->segmentoNoCilindro->no_cilindro . " cilindros, " .  $av->segmentoTransmision->transmision . ", " . $av->segmentoMotor->motor  . '",';
        }
        $cadenatipovehiculo = '{' . rtrim($cadenatipovehiculo, ',') . '}';



        return view('licitaciones.requisicion.operaciones.ver-partidas-operaciones', compact('requisicion', 'partidas', 'cadenatipovehiculo'));
    }


    public function verPartidaoperaciones($partida, $requisicion)
    {

        $info_partida = RequisicionPartida::where('id', $partida)->where('id_status_delete', 1)->first();
        $equipamientos = RequisicionPartidaEquipamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $aseguramientos = RequisicionPartidaAseguramiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $emplacamientos = RequisicionPartidaEmplacamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $lugares_entrega = RequisicionPartidaLugarEntrega::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();

        return view('licitaciones.requisicion.operaciones.ver-partida-operciones', compact('requisicion', 'partida', 'info_partida', 'equipamientos', 'aseguramientos', 'emplacamientos', 'lugares_entrega'));
    }

    public function asignacionunidades($requisicion)
    {

    	$req = Requisicion::where('id', $requisicion)->first();

    	$partidas = RequisicionPartida::where('requisicion_id', $requisicion)->where('id_status_delete', 1)->get();

    	$ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        $unidades_req = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.requisicion_partida_id')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.requisicion_id', $requisicion)->get();

		return view('licitaciones.requisicion.operaciones.asignacion-unidades', compact('requisicion', 'ubicacion', 'partidas','unidades_req', 'req'));    	
    }

    public function unidadesenpatioreq($patio, $requisicion)
    {
    	$ubi_patio = UbicacionUnidad::where('id', $patio)->first();

        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.id_ubicacion', $patio)->where('unidad.unidad_requisicion_estatus_id', 1)->get();

        $req = Requisicion::find($requisicion);

        $partidas = RequisicionPartida::where('requisicion_id', $req->id)->where('id_status_delete', 1)->get();

        $segmento = Segmento::where('id_status_delete', 1)->get();
        //Avance financiero en formato json
        $cadenatipovehiculo = "";
        foreach ($segmento as $av) {

            $cadenatipovehiculo .= '"' . $av->id . '":"' . $av->segmentoTipoVehiculo->tipo_vehiculo . ", " . $av->segmentoNoCilindro->no_cilindro . " cilindros, " .  $av->segmentoTransmision->transmision . ", " . $av->segmentoMotor->motor  . '",';
        }
        $cadenatipovehiculo = '{' . rtrim($cadenatipovehiculo, ',') . '}';

        return view('licitaciones.requisicion.operaciones.unidades-requisicion', compact('requisicion', 'patio', 'ubicacion_data', 'ubi_patio', 'cadenatipovehiculo', 'partidas', 'req'));  

    }

    public function asignarunidadrequisicion(Request $request)
    {

    	$unidad = count($request->unidad);
    	$dato = $unidad - 1;
    	for($i=0; $i <= $dato; $i ++){
    		$id_unidad = $request->unidad[$i];
    		$id_segmento = $request->segmento[$i];
	        $data = [
	            'unidad_requisicion_estatus_id' => 2,
	            'requisicion_id' => $request->id_requisicion,
	            'requisicion_partida_id' => $id_segmento,
	            'iduserUpdated' =>auth()->user()->id,
	            'updated_at' =>date('Y-m-d H:i:s')
	        ];  

	        Unidad::where('id', $id_unidad)->update($data);
    	}


        session()->flash('success', 'Las unidades se agregaron correctamente a la requisición');
    	return redirect()->route('reqoperaciones.asignacionunidades', $request->id_requisicion );
    }

    public function vistobuenooperaciones(Request $request)
    {

	    $data = [
	        'visto_bueno_operaciones' => 2,
	        'iduservistobueno' =>auth()->user()->id,
	        'hora_vistobueno' =>date('Y-m-d H:i:s')
	    ];  

	    Requisicion::where('id', $request->id)->update($data);

        session()->flash('success', 'Sedio el visto correctamente a la requisición');
    	return redirect()->route('reqoperaciones.asignacionunidades', $request->id );

    }

    public function eliminarunidadrequisicion (Request $request)
    {
	    $data = [
	        'unidad_requisicion_estatus_id' => 1,
	        'requisicion_id' => null,
	        'requisicion_partida_id' => null,
	        'iduserUpdated' =>auth()->user()->id,
	        'updated_at' =>date('Y-m-d H:i:s')
	    ];  

	    Unidad::where('id', $request->id)->update($data);

        session()->flash('success', 'Se elimino correctamente la unidad de la requisición');
    	return redirect()->route('reqoperaciones.asignacionunidades', $request->id_requisicion );
    }

    public function logisticaasignacion($requisicion)
    {
        $asignacionLogistica = AsignacionLogistica::where('requisicion_id', $requisicion)->get();


  
        return view('licitaciones.requisicion.operaciones.logistica-unidades-requisicion', compact('asignacionLogistica', 'requisicion')); 
    }

    public function nuevalogisticaasignacion($requisicion)
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        $documentos = AsignacionTipoDocumento::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';
 
        return view('licitaciones.requisicion.operaciones.logistica-nueva-asignacion', compact('estados', 'municipios','cadenaTipoDocumento', 'requisicion'));

    }


}