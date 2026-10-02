<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use App\Services\Folio;
use Carbon\Carbon;
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
use App\Models\Requisicion\RequisicionDocumentosCompras;
use App\Models\Requisicion\RequisicionEvidenciaCompra;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\UnidadRequisicionEstatus;
use App\Models\Unidad\ComplementoUnidad;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\UnidadTipoVehiculo;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Cliente\Cliente;
use App\Models\Proyecto\Proyecto;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UnidadMovimientos;
use App\Models\Unidad\InformacionSeguroUnidad;
use App\Models\Unidad\TipoCobertura;
use App\Models\Unidad\InformacionGpsUnidad;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Models\Unidad\UnidadEquipamiento;

use App\Models\Segmento\TipoVehiculo;
use App\Models\Segmento\Segmento;
use App\Models\Unidad\Proveedores;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnidadesImport;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;

class RequisicionFinanzasController extends Controller
{
    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function catalogoRequisicion()
    {
        return view('licitaciones.requisicion.finanzas.catalogo-requisicion-finanzas');
    }

    public function requisicionDatatable(Request $request)
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


        $records = Requisicion::select(
            'requisicion.*',
            'users.name as name',
            'area_personal.nombre_area as nombre_area',
            'requisicion_estatus.estatus as requisicion_estatus',
            'requisicion_orden_compra.id as requisicion_orden_compra_id',
            )
            ->where('requisicion.id', 'like', '%' . $searchValue . '%')
            ->where('requisicion.requisicion_estatus_id', 2)
            ->orWhere('requisicion.requisicion_estatus_id', 4)
            ->leftJoin('users', 'requisicion.solicitante', '=', 'users.id')
            ->leftJoin('area_personal', 'requisicion.id_area', '=', 'area_personal.id')
            ->leftJoin('requisicion_estatus', 'requisicion.requisicion_estatus_id', '=', 'requisicion_estatus.id')
            ->leftJoin('requisicion_orden_compra', 'requisicion.id', '=', 'requisicion_orden_compra.requisicion_id')
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
                "solicitante" => $record->name,
                "area" => $record->nombre_area,
                "estatus" => $record->requisicion_estatus,
                "fecha_solicitud" => $record->fecha_solicitud,
                "op_estatus" => $record->requisicion_estatus_id,
                "permisos" => $permiso_array,
                'acciones' => null,
                'requisicion_orden_compra_id' => $record->requisicion_orden_compra_id
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

    public function verRequisicion($id)
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

        return view('licitaciones.requisicion.finanzas.ver-partidas-finanzas', compact('requisicion', 'partidas', 'cadenatipovehiculo'));
    }

    public function backfinanzasRequisicion(Request $request)
    {
        $data = [
            'motivo_finanzas' => $request->motivo,
            'requisicion_estatus_id' => 7,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        Requisicion::where('id', $request->id_requisicion)->update($data);

        session()->flash('success', 'La requisición fue regresada a Dirección Comercial');
        return redirect()->route('finanzas.catalogorequisicion');
    }

    public function ordencompra($id)
    {
        // get cfdi
        $cfdis = RequisicionCfdi::where('id_status_delete', 1)->get();
        $requisicion = Requisicion::find($id);
        $partidas = RequisicionPartida::where('requisicion_id', $id)->where('id_status_delete', 1)->where('orden_estatus', 0)->get();
        if (empty($partidas[0])) {
            $op = 1;
        } else {
            $op = 2;
        }
        $orden_compra = RequisicionOrdenCompra::where('requisicion_id', $id)->first();

        $segmento = Segmento::where('id_status_delete', 1)->get();
        $proveedor = Proveedores::where('id_status_delete', 1)->get();
        $forma_pago = RequisicionFormaPago::where('id_status_delete', 1)->get();
        $metodo_pago = RequisicionMetodoPago::where('id_status_delete', 1)->get();

        $unidades_req = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.requisicion_partida_id')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.requisicion_id', $id)->get();

        $req = Requisicion::where('id', $id)->first();


        return view('licitaciones.requisicion.finanzas.generar-orden-compra', compact('requisicion', 'partidas', 'proveedor', 'id', 'op', 'orden_compra', 'forma_pago', 'metodo_pago', 'cfdis', 'unidades_req', 'req'));
    }

    public function generarOrdencompra(Request $request)
    {

        $sum = 0;
        $tot = 0;
        foreach ($request->cantidad as $cantidad) {
            if ($cantidad == null || $cantidad == 0) {
                $tot = 0;
            } else {
                $tot = 1;
            }
            $sum = $sum + $tot;
        }

        if ($sum == 0) {
            session()->flash('warning', 'La acción no puede realizarse, debes ingresar alguna cantidad');
            return redirect()->route('finanzas.ordencompra', $request->requisicion_id);
        } else {

            $requisicion = Requisicion::find($request->requisicion_id);
            $requisicion->requisicion_estatus_id = 4;
            $requisicion->iduserUpdated = Auth::user()->id;
            $requisicion->save();

            $or_comp = RequisicionOrdenCompra::where('requisicion_id', $request->requisicion_id)->first();
            if ($or_comp == null) {
                $orden_compra = new RequisicionOrdenCompra();
                $orden_compra->requisicion_id = $request->requisicion_id;
                $orden_compra->iduserCreated = Auth::user()->id;
                $orden_compra->iduserUpdated = Auth::user()->id;
                $orden_compra->save();
                $orden_compra = $orden_compra->id;
            } else {
                $orden_compra = $or_comp->id;
            }

            $orden_proveedor = new RequisicionOrdenProveedor();
            $orden_proveedor->orden_compra_id = $orden_compra;
            $orden_proveedor->proveedores_id = $request->proveedor;
            $orden_proveedor->forma_pago_id = $request->forma_pago;
            $orden_proveedor->metodo_pago_id = 1;
            $orden_proveedor->uso_cfdi = $request->cfdi;
            $orden_proveedor->precio_unitario = $request->precio_unitario ? $this->money_format->clearFormat($request->precio_unitario) : null;
            $orden_proveedor->save();
            $orden_proveedor = $orden_proveedor->id;


            $cantidad_op = 0;
            foreach ($request->id_partida as $partida) {
                if ($request->cantidad[$cantidad_op] != null || $request->cantidad[$cantidad_op] != 0) {
                    $data = "restar";
                    $par_info = RequisicionPartida::where('id', $partida)->first();
                    $new_cantidad = $par_info->cantidad_orden - $request->cantidad[$cantidad_op];
                    if ($new_cantidad == 0) {
                        $orden_estatus = 1;
                    } else {
                        $orden_estatus = 0;
                    }

                    $data = [
                        'cantidad_orden' => $new_cantidad,
                        'orden_estatus' => $orden_estatus,
                        'iduserUpdated' => auth()->user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    RequisicionPartida::where('id', $partida)->update($data);

                    $data = [
                        'cantidad' => $request->cantidad[$cantidad_op],
                        'requisicion_partida_id' => $par_info->id,
                        'requisicion_orden_proveedor_id' => $orden_proveedor,
                        'segmentos_id' => $par_info->segmentos_id,
                        'orden_compra_id' => $orden_compra
                    ];
                    RequisicionOrdenPartida::insert($data);
                } else {
                    $data = "nada";
                }

                $cantidad_op = $cantidad_op + 1;
            }

            session()->flash('succes', 'La información se agrego correctamente');
            return redirect()->route('finanzas.ordencompra', $request->requisicion_id);
        }
    }

    public function verordenpendiente($requisicion_id, $orden_id)
    {

        $or_comp = RequisicionOrdenCompra::where('requisicion_id', $requisicion_id)->first();
        $or_prov = RequisicionOrdenProveedor::where('orden_compra_id', $orden_id)->get();
        $or_partidas = RequisicionOrdenPartida::where('orden_compra_id', $orden_id)->get();

        return view('licitaciones.requisicion.finanzas.orden-compra-pendiente', compact('requisicion_id', 'orden_id', 'or_comp', 'or_prov', 'or_partidas'));
    }

    public function eliminarpartidaorden(Request $request)
    {

        $or_partidas = RequisicionOrdenPartida::where('id', $request->id)->first();
        $partidas = RequisicionPartida::where('id', $or_partidas->requisicion_partida_id)->first();
        $proveedor = $or_partidas->requisicion_orden_proveedor_id;
        $new_cantidad = $or_partidas->cantidad + $partidas->cantidad_orden;
        $requisicion = RequisicionPartida::find($or_partidas->requisicion_partida_id);
        $requisicion->orden_estatus = 0;
        $requisicion->cantidad_orden = $new_cantidad;
        $requisicion->iduserUpdated = Auth::user()->id;
        $requisicion->save();

        RequisicionOrdenPartida::where('id', $request->id)->delete();
        // Proceso para eliminar partidas de del proveedor

        $or_proveedor = RequisicionOrdenPartida::where('requisicion_orden_proveedor_id', $or_partidas->requisicion_orden_proveedor_id)->first();
        if ($or_proveedor == null) {
            RequisicionOrdenProveedor::where('id', $proveedor)->delete();
        }
        // Proceso para eliminar proveedor de la orden

        $or_orden = RequisicionOrdenProveedor::where('orden_compra_id', $request->orden)->first();
        if ($or_orden == null) {
            RequisicionOrdenCompra::where('id', $request->orden)->delete();
            $requisicion = Requisicion::find($request->requisicion);
            $requisicion->requisicion_estatus_id = 2;
            $requisicion->iduserUpdated = Auth::user()->id;
            $requisicion->save();

            session()->flash('succes', 'El registro se elimino correctamente');
            return redirect()->route('finanzas.ordencompra', $request->requisicion);
        } else {
            session()->flash('succes', 'El registro se elimino correctamente');
            return redirect()->route('finanzas.verordenpendiente', [$request->requisicion, $request->orden]);
        }
        // Proceso para eliminar orden de la requisicion y cambiar estatus


    }

    public function verPartida($partida, $requisicion)
    {

        $info_partida = RequisicionPartida::where('id', $partida)->where('id_status_delete', 1)->first();
        $equipamientos = RequisicionPartidaEquipamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $aseguramientos = RequisicionPartidaAseguramiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $emplacamientos = RequisicionPartidaEmplacamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $lugares_entrega = RequisicionPartidaLugarEntrega::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();

        return view('licitaciones.requisicion.finanzas.ver-partida', compact('requisicion', 'partida', 'info_partida', 'equipamientos', 'aseguramientos', 'emplacamientos', 'lugares_entrega'));
    }

    public function verordendetalle($requisicion_id, $orden_id, $prov)
    {
        $rs_prov = $prov;
        $or_comp = RequisicionOrdenCompra::where('requisicion_id', $requisicion_id)->first();
        $or_prov = RequisicionOrdenProveedor::where('id', $prov)->get();
        $or_partidas = RequisicionOrdenPartida::where('orden_compra_id', $orden_id)->where('requisicion_orden_proveedor_id', $prov)->get();

        $documentos = RequisicionDocumentosCompras::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $records = Unidad::select(
            'unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa','unidad.transmision','unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status','mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status','pr.id_contrato',
            'pr.id_contrato', 'unidad.estatus_pagado','unidad.forma_compra', 'unidad.op_equipamiento')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->where("unidad.requisicion_id_ordencompra", $requisicion_id)
            ->where("unidad.orden_compra_id", $orden_id)
            ->where("unidad.requisicion_orden_proveedor_id", $prov)
            ->get();

        
            $or_evidencias = RequisicionEvidenciaCompra::where('orden_compra_id', $orden_id)->where('proveedor_id', $prov)->where('requisicion_id', $requisicion_id)->get();
            // dd($or_evidencias );

        return view('licitaciones.requisicion.finanzas.detalle-orden-compra', compact('requisicion_id', 'orden_id', 'or_comp', 'or_prov', 'or_partidas', 'prov', 'cadenaTipoDocumento','records', 'rs_prov', 'or_evidencias'));
    }

    public function agregarevidenciaorden(Request $request)
    {

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('requiciciones/', $archivo, $archivoNombre);
                $data = [
                    'orden_compra_id' => $request->orden_id,
                    'proveedor_id' => $request->prov,
                    'requisicion_id' => $request->requisicion_id,
                    'requisicion_documentos_compras_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                RequisicionEvidenciaCompra::insert($data);
            }
        }

        session()->flash('success', 'El documento se añadió correctamente');
        return redirect()->route('finanzas.verordendetalle', [$request->requisicion_id, $request->orden_id, $request->prov]);

    }

    public function eliminarevidenciaorden(Request $request)
    {

        $doc = RequisicionEvidenciaCompra::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('requiciciones/'.$doc->documento);
            RequisicionEvidenciaCompra::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }


    public function editarunidadfinanzas($requisicion_id, $orden_id, $prov, $unidad)
    {

        $unidad_id = $unidad;
        $unidad = Unidad::find($unidad);
        $complemento_unidad = ComplementoUnidad::where('id_unidad', $unidad->id)->first();
        $complemento_unidad_if = ComplementoUnidad::where('id_unidad', $unidad->id)->first();
        $fotosunidad = FotoUnidad::where('id_unidad', $unidad->id)->get();
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $aseguradoras = AseguradoraUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $op_post = 2;
        $documentos = UnidadDocumento::where('id_unidad', $unidad_id)->get();
        $fotografias = UnidadFotografia::where('unidad_id', $unidad_id)->get();
        $tipovehiculo = UnidadTipoVehiculo::where('id_status_delete', 1)->get();

        $documento = UnidadTipoDocumento::where('id_unidad_tipo_documento_estatus', 1)->get();
        $cadenaTipoDocumento = "";
        foreach ($documento as $doc) {
            $cadenaTipoDocumento .= '"' . $doc->id . '":"' . $doc->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';
        $unid_id = $unidad->id;

        return view('licitaciones.requisicion.finanzas.editar-unidad-finanzas', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'cadenaTipoDocumento', 'fotografias', 'tipovehiculo', 'requisicion_id' , 'orden_id', 'prov', 'unid_id'));

    }

    public function editarunidadfin(Request $request)
    {

        $unidad_data = Unidad::where('id', $request->id)->first();
        // $unidad_movimiento = $this->unidadeditmovimiento($request, $request->id, $unidad_data);

        if ($unidad_data->fecha_vencimiento_poliza == $request->fecha_vencimiento_poliza) {
            $fecha_vencimiento_poliza = $request->fecha_vencimiento_poliza;
        } else {
            $fecha_vencimiento_poliza = $request->fecha_vencimiento_poliza ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_poliza)->format('Y-m-d') : null;
        }

        $data = [
            'id_marca' => $request->id_marca ? $request->id_marca : null,
            'id_modelo' => $request->id_modelo ? $request->id_modelo : null,
            'id_vehiculo_tipo' => 1,
            'estatus_pagado' =>$request->estatus_op,
            'forma_compra' =>$request->forma_compra, 
            'unidad_year' => $request->unidad_year,
            'no_serie' => $request->no_serie,
            'placa' => $request->placa,
            'clave_vehicular' => $request->clave_vehicular,
            'factura_compra' => $request->factura_compra,
            'fecha_factura' => $request->fecha_factura ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura)->format('Y-m-d') : null,
            'numero_economico' => $request->numero_economico,
            'importe_iva' => $request->importe_iva ? $this->money_format->clearFormat($request->importe_iva) : null,
            'transmision' => $request->transmision,
            'no_tarjeta_circulacion' => $request->no_tarjeta_circulacion,
            'no_poliza_seguro' => $request->no_poliza_seguro,
            'id_aseguradora' => $request->id_aseguradora ? $request->id_aseguradora : null,
            'fecha_vencimiento_poliza' => $fecha_vencimiento_poliza,
            'numero_inventario' => $request->numero_inventario,
            'color' => $request->color,
            // 'unidad_asignacion_id' => $request->contrato_op,
            // 'fecha_asignacion' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
            // 'id_tipo_asignacion' => $request->id_tipo_asignacion,
            'id_status' => $request->id_status ? $request->id_status : null,
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if($request->contrato_op == 1){
            $data['proyectos_id'] = $request->id_contrato_asignar;
            $data['id_ubicacion'] = null;
            $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
            $data['licitaciones_id'] = $licitacion->licitacion_id;
        }else{
            $data['id_ubicacion'] = $request->id_ubicacion_asignar;
            $data['proyectos_id'] = null;
            $data['licitaciones_id'] = null;
        }


        Unidad::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        $unidad = Unidad::find($request->id);
        if ($request->hasfile('archivo')) {
            $archivos = $request->file('archivo');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $unidad->id, $archivo, $archivoNombre);
                $data = [
                    'id_unidad' => $unidad->id,
                    'id_unidad_tipo_documento' => $colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];
                UnidadDocumento::insert($data);
            }
        }


        session()->flash('success', 'La información basica de la unidad se modifico correctamente');
        return redirect()->route('finanzas.verordendetalle', [$request->requisicion_id,$request->orden_id,$request->prov]);        

    }

    public function cargamasivaexcel(Request $request)
    {

        Excel::import(new UnidadesImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('finanzas.verordendetalle', [$request->requisicion_id,$request->orden_id,$request->prov]);  
    }

    public function equipamientounidadfinanzas($requisicion_id, $orden_id, $prov, $unidad)
    {
        $fotografias = UnidadFotografia::where('unidad_id', $unidad)->get();
        $unidad_info = Unidad::find($unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad)->first();
        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $equipamiento_completo = UnidadEquipamiento::where('equipamiento_pendiente', 1)->where('unidad_id', $unidad)->get();
        $equipamiento_con_factura = UnidadEquipamiento::where('equipamiento_pendiente', 2)->where('unidad_id', $unidad)->get();
        $alert = count($equipamiento_completo);

        return view('licitaciones.requisicion.finanzas.equipamiento-unidad-finanzas', compact('unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'equipamiento_completo','requisicion_id', 'orden_id', 'prov' ,'equipamiento_con_factura', 'alert'));  
    }

    public function verordenpendientePDF($requisicion_id, $orden_id)
    {

        $or_comp = RequisicionOrdenCompra::where('requisicion_id', $requisicion_id)->first();
        $or_prov = RequisicionOrdenProveedor::where('orden_compra_id', $orden_id)->get();
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
