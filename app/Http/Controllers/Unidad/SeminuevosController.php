<?php

namespace App\Http\Controllers\Unidad;

use App\Models\User;
use App\Services\Money;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use App\Models\Unidad\Unidad;
use Illuminate\Support\Carbon;
use App\Models\Proyecto\Proyecto;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\TipoPersona;
use App\Models\Unidad\UnidadVenta;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Http\Controllers\Controller;
use App\Models\Taller\TallerSolicitud;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadFotografia;
use Illuminate\Support\Facades\Storage;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\ComplementoUnidad;
use App\Models\Unidad\UnidadMovimientos;
use App\Models\Unidad\InformacionGpsUnidad;
use App\Models\Unidad\SeminuevosDocumentos;
use App\Models\Unidad\InformacionSeguroUnidad;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Unidad\SeminuevosApartado;
use App\Models\Unidad\SeminuevosApartadoFacturacion;
use Illuminate\Support\Facades\File;
use Mpdf\Mpdf;
use Spatie\Permission\Models\Role;

class SeminuevosController extends Controller
{
    protected $money_format;
    public function __construct(Money $money_format)
    {
        //$this->middleware('auth');
        $this->money_format = $money_format;
    }

    public function catalogounidad()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();

        return view('unidades.seminuevos.catalogo-unidades', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos'));
    }

    public function unidaddatatable(Request $request)
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
        $totalRecords = Unidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Unidad::select('count(*) as allcount')->where('folio', 'like', '%' . $searchValue . '%')->count();

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
        $records = Unidad::select(
            'unidad.id',
            'unidad.folio',
            'unidad.id_ubicacion',
            'unidad.fecha',
            'unidad.id_marca',
            'unidad.id_modelo',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.transmision',
            'unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro',
            'unidad.fecha_vencimiento_poliza',
            'unidad.numero_inventario',
            'unidad.color',
            'unidad.id_status',
            'unidad.unidad_asignacion_id',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'uv.id as id_unidad_venta',
            'uv.politicas as politicas',
            'uv.vendido',
            'unidad.numero_economico',
            'unidad.clave_vehicular',
            'unidad.no_tarjeta_circulacion'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
            ->whereIn("unidad.id_status_delete", [1,2])
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'folio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.folio", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_ubicacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'

                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_ubicacion", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_marca') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_marca", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_modelo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_modelo", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'placa') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.placa", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'no_serie') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.no_serie", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_status') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_status", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'contrato') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.proyectos_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'unidad_year') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.unidad_year", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'numero_economico') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.numero_economico", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'clave_vehicular') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.clave_vehicular", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'no_tarjeta_circulacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.no_tarjeta_circulacion", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'no_poliza_seguro') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido',
                        'unidad.numero_economico',
                        'unidad.clave_vehicular',
                        'unidad.no_tarjeta_circulacion'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.no_poliza_seguro", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }


        }

        if ($valor == "No") {
            $records = Unidad::select(
                'unidad.id',
                'unidad.folio',
                'unidad.id_ubicacion',
                'unidad.fecha',
                'unidad.id_marca',
                'unidad.id_modelo',
                'unidad.unidad_year',
                'unidad.no_serie',
                'unidad.placa',
                'unidad.transmision',
                'unidad.no_tarjeta_circulacion',
                'unidad.no_poliza_seguro',
                'unidad.fecha_vencimiento_poliza',
                'unidad.numero_inventario',
                'unidad.color',
                'unidad.id_status',
                'unidad.unidad_asignacion_id',
                'mu.nombre_marca',
                'mou.nombre_modelo',
                'uu.ubicacion',
                'st.nombre_status',
                'pr.id_contrato',
                'uv.id as id_unidad_venta',
                'uv.politicas as politicas',
                'uv.id_status_delete',
                'uv.vendido',
                'unidad.numero_economico',
                'unidad.clave_vehicular',
                'unidad.no_tarjeta_circulacion'
            )
                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                ->whereIn("unidad.id_status_delete", [1,2])
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $img = "<a class='example-image-link' href='/img/frontier-2022-2.jpg' data-lightbox='example-1'><img class='example-image' src='/img/frontier-2022-2.jpg' id='camara_div' alt='image-1'  width='90' /></a>";

        foreach ($records as $record) {
            $data_arr[] = array(
                "check" => '',
                "id" => $record->id,
                "folio" => $record->folio,
                "id_ubicacion" => $record->ubicacion,
                "id_marca" => $record->nombre_marca,
                "id_modelo" => $record->nombre_modelo,
                "no_serie" => $record->no_serie,
                "placa" => $record->placa,
                "unidad_year" => $record->unidad_year,
                "id_status" => $record->nombre_status,
                "contrato" => $record->id_contrato,
                "permisos" => $permiso_array,
                'acciones' => null,
                "id_unidad_asignacion" => $record->unidad_asignacion_id,
                "id_unidad_venta" => $record->id_unidad_venta,
                "politicas" => $record->politicas,
                "id_status_delete" => $record->id_status_delete,
                "vendido" => $record->vendido,
                "numero_economico" => $record->numero_economico,
                "clave_vehicular" => $record->clave_vehicular,
                "no_tarjeta_circulacion" => $record->no_tarjeta_circulacion,
                "no_poliza_seguro" => $record->no_poliza_seguro,
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

    public function verUnidad($unidad)
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
        $active = UnidadFotografia::where('unidad_id', $unidad_id)->first();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $bitacora_unidad = UnidadMovimientos::select('unidad_movimientos.id', 'unidad_movimientos.fecha_asignacion', 'unidad_movimientos.fecha_salida', 'as.asignacion', 'pr.no_folio', 'pr.id_contrato', 'pr.titulo_servicio', 'uu.ubicacion','uts.tipo_asignacion', 'unidad_movimientos.asignacion_id')
            ->leftjoin("unidad_asignacion as as", "as.id", "unidad_movimientos.asignacion_id")
            ->leftjoin("proyectos as pr", "pr.id", "unidad_movimientos.proyectos_id")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", "unidad_movimientos.ubicacion_id")
            ->leftjoin("unidad_tipo_asignacion as uts", "uts.id", "unidad_movimientos.tipo_asignacion_id")
            ->where('unidad_movimientos.unidad_id', $unidad_id)
            ->orderBy('id', 'desc')
            ->get();


        $unidad_movimiento = AsignacionRegistroUnidad::select('unidad_registro_asignacion.id', 'unidad_registro_asignacion.unidad_id', 'mu.nombre_marca', 'un.folio', 'mou.nombre_modelo','un.unidad_year','un.no_serie','un.placa', 'unidad_registro_asignacion.proyectos_id', 'unidad_registro_asignacion.op_asignacion', 'unidad_registro_asignacion.fecha_asignacion', 'uta.tipo_asignacion', 'use.name', "unidad_registro_asignacion.licitaciones_id", 'pro.titulo_servicio', 'pro.no_folio', 'uu.ubicacion')
            ->leftjoin("unidad as un", "un.id", "unidad_registro_asignacion.unidad_id")
            ->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad_registro_asignacion.id_tipo_asignacion")
            ->leftjoin("users as use", "use.id", "unidad_registro_asignacion.cliente_id")
            ->leftjoin("proyectos as pro", "pro.id", "unidad_registro_asignacion.proyectos_id")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", "unidad_registro_asignacion.ubicacion_id")
            ->where('unidad_registro_asignacion.unidad_id', $unidad_id)->get();


        $solicitudes = TallerSolicitud::where('unidad_id', $unidad_id)->get();
        $info_seguros = InformacionSeguroUnidad::where('unidad_id', $unidad_id)->get();
        $info_gps = InformacionGpsUnidad::where('unidad_id', $unidad_id)->get();


        return view('unidades.seminuevos.ver-unidad', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'fotografias', 'ver', 'bitacora_unidad', 'solicitudes', 'info_seguros', 'info_gps', 'unidad_movimiento'));
    }

    public function catalogoUnidadVenta()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();
        $usuariosVentas = $this->getUsuariosVentas();

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $records = Unidad::select(
            'unidad.id',
            'unidad.folio',
            'unidad.id_ubicacion',
            'unidad.fecha',
            'unidad.id_marca',
            'unidad.id_modelo',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.transmision',
            'unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro',
            'unidad.fecha_vencimiento_poliza',
            'unidad.numero_inventario',
            'unidad.color',
            'unidad.id_status',
            'unidad.unidad_asignacion_id',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'uv.id as id_unidad_venta',
            'uv.politicas as politicas',
            'uv.vendido'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
            ->whereIn("unidad.id_status_delete", [1,2])
            ->where("uv.id_status_delete", 1)
            ->orderBy("unidad.folio", "asc")
            ->get();

        $dataArr = [];

        foreach ($records as $record) {
            $seminuevosApartado = SeminuevosApartado::where('id_unidad_venta', $record->id_unidad_venta)
                ->where('dias_apartado', '>', 0)
                ->where('activo', 1)
                ->first();
            if (!$seminuevosApartado) {
                $dataArr[] = array(
                    "id" => $record->id,
                    "folio" => $record->folio,
                    "id_ubicacion" => $record->ubicacion,
                    "id_marca" => $record->nombre_marca,
                    "id_modelo" => $record->nombre_modelo,
                    "no_serie" => $record->no_serie,
                    "placa" => $record->placa,
                    "unidad_year" => $record->unidad_year,
                    "id_status" => $record->nombre_status,
                    "permisos" => $permiso_array,
                    "id_unidad_asignacion" => $record->unidad_asignacion_id,
                    "id_unidad_venta" => $record->id_unidad_venta,
                    "politicas" => $record->politicas,
                    "vendido" => $record->vendido,
                );
            }
        }

        return view('unidades.seminuevos.catalogo-unidades-venta', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos', 'dataArr', 'usuariosVentas'));
    }

    public function unidadVentaDatatable(Request $request)
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
        $totalRecords = Unidad::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Unidad::select('count(*) as allcount')->where('folio', 'like', '%' . $searchValue . '%')->count();

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
        $records = Unidad::select(
            'unidad.id',
            'unidad.folio',
            'unidad.id_ubicacion',
            'unidad.fecha',
            'unidad.id_marca',
            'unidad.id_modelo',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.transmision',
            'unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro',
            'unidad.fecha_vencimiento_poliza',
            'unidad.numero_inventario',
            'unidad.color',
            'unidad.id_status',
            'unidad.unidad_asignacion_id',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'uv.id as id_unidad_venta',
            'uv.politicas as politicas',
            'uv.vendido'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
            ->whereIn("unidad.id_status_delete", [1,2])
            ->where("uv.id_status_delete", 1)
            ->whereIn("uv.vendido", [0,1])
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'folio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.folio", '=', $valor)
                        ->whereIn("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_ubicacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_ubicacion", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_marca') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_marca", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_modelo') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_modelo", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'placa') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.placa", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'no_serie') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
                        // ->where("unidad.no_serie", '=', $valor)
                        ->where('unidad.no_serie', 'like', '%' . $valor . '%')
                        ->whereIn("uv.id_status_delete", [1,2])
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'id_status') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.id_status", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'contrato') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Unidad::select(
                        'unidad.id',
                        'unidad.folio',
                        'unidad.id_ubicacion',
                        'unidad.fecha',
                        'unidad.id_marca',
                        'unidad.id_modelo',
                        'unidad.unidad_year',
                        'unidad.no_serie',
                        'unidad.placa',
                        'unidad.transmision',
                        'unidad.no_tarjeta_circulacion',
                        'unidad.no_poliza_seguro',
                        'unidad.fecha_vencimiento_poliza',
                        'unidad.numero_inventario',
                        'unidad.color',
                        'unidad.id_status',
                        'unidad.unidad_asignacion_id',
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'uv.id as id_unidad_venta',
                        'uv.politicas as politicas',
                        'uv.vendido'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->whereIn("unidad.id_status_delete", [1,2])
                        ->where("unidad.proyectos_id", '=', $valor)
                        ->where("uv.id_status_delete", 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }


        }

        if ($valor == "No") {
            $records = Unidad::select(
                'unidad.id',
                'unidad.folio',
                'unidad.id_ubicacion',
                'unidad.fecha',
                'unidad.id_marca',
                'unidad.id_modelo',
                'unidad.unidad_year',
                'unidad.no_serie',
                'unidad.placa',
                'unidad.transmision',
                'unidad.no_tarjeta_circulacion',
                'unidad.no_poliza_seguro',
                'unidad.fecha_vencimiento_poliza',
                'unidad.numero_inventario',
                'unidad.color',
                'unidad.id_status',
                'unidad.unidad_asignacion_id',
                'mu.nombre_marca',
                'mou.nombre_modelo',
                'uu.ubicacion',
                'st.nombre_status',
                'pr.id_contrato',
                'uv.id as id_unidad_venta',
                'uv.politicas as politicas',
                'uv.vendido'
            )
                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                ->join("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                ->whereIn("unidad.id_status_delete", [1,2])
                ->where("uv.id_status_delete", 1)
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $img = "<a class='example-image-link' href='/img/frontier-2022-2.jpg' data-lightbox='example-1'><img class='example-image' src='/img/frontier-2022-2.jpg' id='camara_div' alt='image-1'  width='90' /></a>";

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "folio" => $record->folio,
                "id_ubicacion" => $record->ubicacion,
                "id_marca" => $record->nombre_marca,
                "id_modelo" => $record->nombre_modelo,
                "no_serie" => $record->no_serie,
                "placa" => $record->placa,
                "unidad_year" => $record->unidad_year,
                "id_status" => $record->nombre_status,
                "permisos" => $permiso_array,
                'acciones' => null,
                "id_unidad_asignacion" => $record->unidad_asignacion_id,
                "id_unidad_venta" => $record->id_unidad_venta,
                "politicas" => $record->politicas,
                "vendido" => $record->vendido,
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

    public function ventaFinalVer($unidad)
    {
        $unidad = Unidad::find($unidad);
        $complemento_unidad = ComplementoUnidad::where('id_unidad', $unidad->id)->first();
        $unidadVenta = UnidadVenta::where('id_unidad', $unidad->id)->first();
        $seminuevosApartado = null;
        $apartadoFacturacion = null;
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $tipoPersona = TipoPersona::All();
        $seminuevosDocumentos = null;
        if ($unidadVenta) {
            $seminuevosDocumentos = SeminuevosDocumentos::where('id_unidad_venta', $unidadVenta->id)->get();
            $seminuevosApartado = SeminuevosApartado::where('id_unidad_venta', $unidadVenta->id)
                ->where('activo', 1)
                ->first();
            if ($seminuevosApartado) {
                $apartadoFacturacion = SeminuevosApartadoFacturacion::where('id_seminuevos_apartado', $seminuevosApartado->id)->first();
            }
        }

        return view('unidades.seminuevos.vender-ver-unidad-final', compact('unidad', 'marcas', 'modelos', 'estatus', 'complemento_unidad', 'unidadVenta', 'tipoPersona', 'seminuevosDocumentos', 'seminuevosApartado', 'apartadoFacturacion'));
    }

    public function ventaDocumentoPDF($unidad)
    {
        $unidadInfo = Unidad::select(
            'unidad.id',
            'unidad.folio',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.numero_economico',
            'unidad.color',
            'uu.ubicacion as patio',
            'mu.nombre_marca',
            'mou.nombre_modelo'
        )
            ->leftJoin('ubicacion_unidad as uu', 'uu.id', '=', 'unidad.id_ubicacion')
            ->leftJoin('marca_unidad as mu', 'mu.id', '=', 'unidad.id_marca')
            ->leftJoin('modelo_unidad as mou', 'mou.id', '=', 'unidad.id_modelo')
            ->where('unidad.id', $unidad)
            ->firstOrFail();

        $unidadVenta = UnidadVenta::where('id_unidad', $unidad)
            ->where('id_status_delete', 1)
            ->where('vendido', 1)
            ->firstOrFail();

        $pedidoData = SeminuevosApartado::select(
            'saf.nombre_cliente',
            'saf.rfc',
            'saf.correo_electronico',
            'saf.numero_telefono',
            'saf.direccion_completa'
        )
            ->leftJoin('seminuevos_apartado_facturacion as saf', 'saf.id_seminuevos_apartado', '=', 'seminuevos_apartado.id')
            ->where('seminuevos_apartado.id_unidad_venta', $unidadVenta->id)
            ->where('seminuevos_apartado.activo', 1)
            ->first();

        $folioDocumento = str_pad((string) $unidadVenta->id, 6, '0', STR_PAD_LEFT);

        $pdfData = [
            'unidadInfo' => $unidadInfo,
            'unidadVenta' => $unidadVenta,
            'folioDocumento' => $folioDocumento,
            'pedidoData' => $pedidoData,
        ];

        $header = view('unidades.seminuevos.pdf.documento-pdf-header', $pdfData)->render();
        $body = view('unidades.seminuevos.pdf.documento-pdf-body', $pdfData)->render();
        $footer = view('unidades.seminuevos.pdf.documento-pdf-footer', $pdfData)->render();

        $pathLogo = public_path() . '/theme/assets/media/logos/logojetvan-pdf.jpg';

        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($body);

        if (File::exists($pathLogo)) {
            $mpdf->imageVars['logo'] = File::get($pathLogo);
        }

        $mpdf->Output('documento-seminuevos-' . $folioDocumento . '.pdf', 'I');
    }

    public function ventaFinalCancelar(Request $request)
    {
        $unidadId = $request->unidad_id;
        $unidad = Unidad::find($unidadId);
        $unidadVenta = UnidadVenta::where('id_unidad', $unidadId)->first();
        if ($unidad && $unidadVenta) {
            $unidadVenta->delete();

            session()->flash('success', 'La venta de la unidad se cancelo correctamente');
        }


        return redirect()->route('unidad.catalogoUnidadVenta');
    }

    public function ventaFinal($unidad)
    {
        $unidad = Unidad::find($unidad);
        $complemento_unidad = ComplementoUnidad::where('id_unidad', $unidad->id)->first();
        $unidadVenta = UnidadVenta::where('id_unidad', $unidad->id)->first();
        $seminuevosApartado = null;
        $apartadoFacturacion = null;
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $tipoPersona = TipoPersona::All();
        $seminuevosDocumentos = null;
        if ($unidadVenta) {
            $seminuevosDocumentos = SeminuevosDocumentos::where('id_unidad_venta', $unidadVenta->id)->get();
            $seminuevosApartado = SeminuevosApartado::where('id_unidad_venta', $unidadVenta->id)
                ->where('activo', 1)
                ->first();
            if ($seminuevosApartado) {
                $apartadoFacturacion = SeminuevosApartadoFacturacion::where('id_seminuevos_apartado', $seminuevosApartado->id)->first();
            }
        }

        return view('unidades.seminuevos.vender-unidad-final', compact('unidad', 'marcas', 'modelos', 'estatus', 'complemento_unidad', 'unidadVenta', 'tipoPersona', 'seminuevosDocumentos', 'seminuevosApartado', 'apartadoFacturacion'));
    }

    public function ventaFinalGuardar(Request $request)
    {
        $unidadId = $request->unidad_id;
        $placas = $request->placas;
        $gps = $request->gps;
        $apartado = $request->apartado;
        $confirmacion = $request->confirmacion;
        $comentarios = $request->comentarios;
        $opcionGuardar = $request->opcion_guardar;
        $cedulaFiscal = $request->cedula_fiscal;
        $ineVigente = $request->ine_vigente;
        $comprobantePago = $request->comprobante_pago;
        $pedidoApartadoId = $request->pedido_id_seminuevos_apartado;

        $unidad = Unidad::find($unidadId);
        $unidadVenta = UnidadVenta::where('id_unidad', $unidadId)->first();
        if ($unidad && $unidadVenta) {
            $unidadVenta->retiro_placas = $placas;
            $unidadVenta->retiro_gps = $gps;
            $unidadVenta->apartado_politicas = $apartado;
            $unidadVenta->confirmacion_directiva = $confirmacion;
            $unidadVenta->cedula_fiscal = $cedulaFiscal;
            $unidadVenta->ine_vigente = $ineVigente;
            $unidadVenta->comprobante_pago = $comprobantePago;
            $unidadVenta->confirmacion_comentarios = $comentarios;
            $unidadVenta->precio_mercado = $request->precio_mercado;
            $unidadVenta->precio_venta = $request->precio_venta;
            $unidadVenta->fecha_entrega = isset($request->fecha_entrega) ? Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d') : null;
            $unidadVenta->fecha_pago = isset($request->fecha_pago) ? Carbon::createFromFormat('d/m/Y', $request->fecha_pago)->format('Y-m-d') : null;
            $unidadVenta->fecha_registro_venta = isset($request->fecha_registro_venta) ? Carbon::createFromFormat('d/m/Y', $request->fecha_registro_venta)->format('Y-m-d') : null;
            $unidadVenta->fecha_venta = isset($request->fecha_venta) ? Carbon::createFromFormat('d/m/Y', $request->fecha_venta)->format('Y-m-d') : null;
            $unidadVenta->numero_factura = $request->numero_factura;
            $unidadVenta->vendedor_unidad = $request->vendedor_unidad;
            $unidadVenta->nombre_cliente = $request->nombre_cliente;
            $unidadVenta->direccion_cliente = $request->direccion_cliente;
            $unidadVenta->identificacion_cliente = $request->identificacion_cliente;
            $unidadVenta->rfc = $request->rfc;
            $unidadVenta->id_tipo_persona = $request->tipo_persona;
            $unidadVenta->iduserUpdated = auth()->user()->id;
            $unidadVenta->compra = $request->compra;
            $unidadVenta->media = $request->media;
            $unidadVenta->ajustes_sobre_valor = $request->ajustes_sobre_valor;
            $unidadVenta->autometrica = $request->autometrica;
            $unidadVenta->ajustes_conversion = $request->ajustes_conversion;
            $unidadVenta->conversion = $request->conversion;
            $unidadVenta->conversion_ajuste = $request->conversion_ajuste;
            $unidadVenta->venta_final = $request->venta_final;
            if ($opcionGuardar == 2) {
                $unidadVenta->vendido = 1;
                $unidad->id_status_delete = 2;
                $unidad->motivo_desactivar = 'Venta de unidad';
                $unidad->iduserUpdated = auth()->user()->id;
                $unidad->updated_at = date('Y-m-d H:i:s');
                $unidad->save();
            } else {
                $unidadVenta->vendido = 0;
            }

            $unidadVenta->save();

            if ($pedidoApartadoId) {
                $pedidoData = [
                    'fecha' => $request->pedido_fecha,
                    'nombre_asesor' => $request->pedido_nombre_asesor,
                    'nombre_cliente' => $request->pedido_nombre_cliente,
                    'rfc' => $request->pedido_rfc,
                    'correo_electronico' => $request->pedido_correo_electronico,
                    'numero_telefono' => $request->pedido_numero_telefono,
                    'direccion_completa' => $request->pedido_direccion_completa,
                    'forma_pago' => $request->pedido_forma_pago,
                    'uso_cfdi' => $request->pedido_uso_cfdi,
                    'unidad_medida' => $request->pedido_unidad_medida,
                    'clave_producto' => $request->pedido_clave_producto,
                    'importe_facturar' => $request->pedido_importe_facturar,
                ];

                $pedidoConDatos = collect($pedidoData)
                    ->filter(function ($value) {
                        return $value !== null && $value !== '';
                    })
                    ->isNotEmpty();

                if ($pedidoConDatos) {
                    $request->validate([
                        'pedido_fecha' => 'required',
                        'pedido_nombre_asesor' => 'required|string|max:200',
                        'pedido_nombre_cliente' => 'required|string|max:200',
                        'pedido_rfc' => 'required|string|max:20',
                        'pedido_correo_electronico' => 'required|email|max:255',
                        'pedido_numero_telefono' => 'required|string|max:20',
                        'pedido_direccion_completa' => 'required|string|max:500',
                        'pedido_forma_pago' => 'required|string|max:100',
                        'pedido_uso_cfdi' => 'required|string|max:100',
                        'pedido_unidad_medida' => 'required|string|max:100',
                        'pedido_clave_producto' => 'required|string|max:100',
                        'pedido_importe_facturar' => 'required|numeric|min:0',
                    ]);

                    SeminuevosApartadoFacturacion::updateOrCreate(
                        ['id_seminuevos_apartado' => $pedidoApartadoId],
                        [
                            'fecha' => Carbon::createFromFormat('d/m/Y', $request->pedido_fecha)->format('Y-m-d'),
                            'nombre_asesor' => $request->pedido_nombre_asesor,
                            'nombre_cliente' => $request->pedido_nombre_cliente,
                            'rfc' => $request->pedido_rfc,
                            'correo_electronico' => $request->pedido_correo_electronico,
                            'numero_telefono' => $request->pedido_numero_telefono,
                            'direccion_completa' => $request->pedido_direccion_completa,
                            'forma_pago' => $request->pedido_forma_pago,
                            'uso_cfdi' => $request->pedido_uso_cfdi,
                            'unidad_medida' => $request->pedido_unidad_medida,
                            'clave_producto' => $request->pedido_clave_producto,
                            'importe_facturar' => $request->pedido_importe_facturar,
                            'iduserCreated' => auth()->user()->id,
                        ]
                    );
                }
            }


            if ($request->hasfile('archivo')) {
                $archivos = $request->file('archivo');
                $archivoDescripcion = $request->archivo_descripcion;
                foreach ($archivos as $indice => $archivo) {
                    $archivoNombre = $archivo->hashName();
                    $mimeType = $archivo->getMimeType();
                    Storage::putFileAs('seminuevos/' . $unidadVenta->id, $archivo, $archivoNombre);
                    $data = [
                        'id_unidad_venta' => $unidadVenta->id,
                        'documento' => $archivoNombre,
                        'mime_type' => $mimeType,
                        'descripcion' => $archivoDescripcion[$indice],
                        'iduserCreated' => auth()->user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    SeminuevosDocumentos::insert($data);
                }
            }
        }
        if ($opcionGuardar == 2) {
            session()->flash('success', 'La unidad se cambio a estatus vendido');
        } else {
            session()->flash('success', 'La unidad se guardo correctamente');
        }

        return redirect()->route('seminuevos.catalogoUnidadVenta');
    }

    public function eliminarDocumento(Request $request)
    {
        $doc = SeminuevosDocumentos::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('seminuevos/' . $doc->id_unidad_venta . '/' . $doc->documento);
            SeminuevosDocumentos::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function listadoApartados()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();
        $usuariosVentas = $this->getUsuariosVentas();

        return view('unidades.seminuevos.catalogo-unidades-venta', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos', 'usuariosVentas'));
    }

    private function getUsuariosVentas()
    {
        $rolVentas = Role::whereRaw('LOWER(name) = ?', ['ventas'])->first();

        if (!$rolVentas) {
            return collect();
        }

        return User::where('id_status_delete', 1)
            ->where('role', $rolVentas->id)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);
    }

    public function apartar(Request $request)
    {
        $unidadesIds = $request->unidades_id;
        $vendedorUserId = $request->vendedor_user_id;
        $numeroDias = $request->numero_dias;

        $vendedorUsuario = User::where('id', $vendedorUserId)
            ->where('id_status_delete', 1)
            ->first();

        if (!$vendedorUsuario) {
            session()->flash('error', 'Debe seleccionar un vendedor válido');
            return redirect()->route('seminuevos.catalogoUnidadVenta');
        }

        $unidadesIdsColls = explode(',', $unidadesIds);
        foreach ($unidadesIdsColls as $unidadIdVenta) {
            $seminuevosApartado = new SeminuevosApartado();
            $seminuevosApartado->id_unidad_venta = $unidadIdVenta;
            $seminuevosApartado->iduserCreated = auth()->user()->id;
            $seminuevosApartado->vendedor_user_id = $vendedorUsuario->id;
            $seminuevosApartado->dias_apartado = $numeroDias;
            $seminuevosApartado->activo = 1;
            $seminuevosApartado->save();
        }

        session()->flash('success', 'El apartado se guardó correctamente');
        return redirect()->route('seminuevos.catalogoUnidadVentaApartado');
    }

    public function catalogoUnidadVentaApartado()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();
        $usuariosVentas = $this->getUsuariosVentas();

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $rolUsuario = Role::where('id', $user->role)->first();
        $esUsuarioVentas = $rolUsuario && strtolower($rolUsuario->name) === 'ventas';

        $recordsQuery = SeminuevosApartado::select(
            'unidad.id',
            'unidad.folio',
            'unidad.id_ubicacion',
            'unidad.fecha',
            'unidad.id_marca',
            'unidad.id_modelo',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.transmision',
            'unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro',
            'unidad.fecha_vencimiento_poliza',
            'unidad.numero_inventario',
            'unidad.color',
            'unidad.id_status',
            'unidad.unidad_asignacion_id',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'uv.id as id_unidad_venta',
            'uv.politicas as politicas',
            'uv.vendido',
            'seminuevos_apartado.dias_apartado',
            'seminuevos_apartado.id as id_seminuevos_apartado',
            'uvend.name as vendedor_nombre',
            'saf.fecha as facturacion_fecha',
            'saf.nombre_asesor',
            'saf.nombre_cliente',
            'saf.rfc',
            'saf.correo_electronico',
            'saf.numero_telefono',
            'saf.direccion_completa',
            'saf.forma_pago',
            'saf.uso_cfdi',
            'saf.unidad_medida',
            'saf.clave_producto',
            'saf.importe_facturar'
        )
            ->join("unidad_venta as uv", "uv.id", '=', "seminuevos_apartado.id_unidad_venta")
            ->leftjoin("unidad", "unidad.id", "uv.id_unidad")
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->leftjoin("users as uvend", "uvend.id", '=', "seminuevos_apartado.vendedor_user_id")
            ->leftjoin("seminuevos_apartado_facturacion as saf", "saf.id_seminuevos_apartado", '=', "seminuevos_apartado.id")
            ->whereIn("unidad.id_status_delete", [1,2])
            ->where("uv.id_status_delete", 1)
            ->where("seminuevos_apartado.dias_apartado", '>', 0)
            ->where("seminuevos_apartado.activo", 1)
            ->orderBy("unidad.folio", "asc");

        if ($esUsuarioVentas) {
            $recordsQuery->where('seminuevos_apartado.vendedor_user_id', $user->id);
        }

        $records = $recordsQuery->get();

        $dataArr = [];

        foreach ($records as $record) {
            $dataArr[] = array(
                "id" => $record->id,
                "folio" => $record->folio,
                "id_ubicacion" => $record->ubicacion,
                "id_marca" => $record->nombre_marca,
                "id_modelo" => $record->nombre_modelo,
                "no_serie" => $record->no_serie,
                "placa" => $record->placa,
                "unidad_year" => $record->unidad_year,
                "id_status" => $record->nombre_status,
                "permisos" => $permiso_array,
                "id_unidad_asignacion" => $record->unidad_asignacion_id,
                "id_unidad_venta" => $record->id_unidad_venta,
                "politicas" => $record->politicas,
                "vendido" => $record->vendido,
                "dias_apartado" => $record->dias_apartado,
                "id_seminuevos_apartado" => $record->id_seminuevos_apartado,
                "vendedor" => $record->vendedor_nombre,
                "facturacion_fecha" => $record->facturacion_fecha ? Carbon::parse($record->facturacion_fecha)->format('d/m/Y') : '',
                "facturacion_nombre_asesor" => $record->nombre_asesor,
                "facturacion_nombre_cliente" => $record->nombre_cliente,
                "facturacion_rfc" => $record->rfc,
                "facturacion_correo_electronico" => $record->correo_electronico,
                "facturacion_numero_telefono" => $record->numero_telefono,
                "facturacion_direccion_completa" => $record->direccion_completa,
                "facturacion_forma_pago" => $record->forma_pago,
                "facturacion_uso_cfdi" => $record->uso_cfdi,
                "facturacion_unidad_medida" => $record->unidad_medida,
                "facturacion_clave_producto" => $record->clave_producto,
                "facturacion_importe_facturar" => $record->importe_facturar,
            );
        }

        return view('unidades.seminuevos.catalogo-unidades-venta-apartados', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos', 'dataArr', 'usuariosVentas'));
    }

    public function apartadoEditar($unidad)
    {
        $apartados = SeminuevosApartado::select('seminuevos_apartado.*', 'uvend.name as vendedor_nombre')
            ->leftjoin('users as uvend', 'uvend.id', '=', 'seminuevos_apartado.vendedor_user_id')
            ->where('seminuevos_apartado.id', $unidad)
            ->first();

        return view('unidades.seminuevos.catalogo-unidades-apartado-editar', compact( 'apartados'));
    }

    public function apartadoGuardar(Request $request)
    {
        $apartadoId = $request->id_seminuevos_apartado;
        $numeroDias = $request->dias_apartado;

        $apartado = SeminuevosApartado::find($apartadoId);

        if ($apartado) {
            $apartado->dias_apartado = $numeroDias;
            $apartado->updated_at = date('Y-m-d H:i:s');
            $apartado->save();

            session()->flash('success', 'Los días apartados se actualizó correctamente');
        } else {
            session()->flash('error', 'No se encontró el apartado');
        }
        return redirect()->route('seminuevos.catalogoUnidadVentaApartado');
    }

    public function apartadoFacturacionGuardar(Request $request)
    {
        $validated = $request->validate([
            'id_seminuevos_apartado' => 'required|integer|exists:seminuevos_apartado,id',
            'fecha' => 'required',
            'nombre_asesor' => 'required|string|max:200',
            'nombre_cliente' => 'required|string|max:200',
            'rfc' => 'required|string|max:20',
            'correo_electronico' => 'required|email|max:255',
            'numero_telefono' => 'required|string|max:20',
            'direccion_completa' => 'required|string|max:500',
            'forma_pago' => 'required|string|max:100',
            'uso_cfdi' => 'required|string|max:100',
            'unidad_medida' => 'required|string|max:100',
            'clave_producto' => 'required|string|max:100',
            'importe_facturar' => 'required|numeric|min:0',
        ]);

        SeminuevosApartadoFacturacion::updateOrCreate(
            ['id_seminuevos_apartado' => $validated['id_seminuevos_apartado']],
            [
                'fecha' => Carbon::createFromFormat('d/m/Y', $validated['fecha'])->format('Y-m-d'),
                'nombre_asesor' => $validated['nombre_asesor'],
                'nombre_cliente' => $validated['nombre_cliente'],
                'rfc' => $validated['rfc'],
                'correo_electronico' => $validated['correo_electronico'],
                'numero_telefono' => $validated['numero_telefono'],
                'direccion_completa' => $validated['direccion_completa'],
                'forma_pago' => $validated['forma_pago'],
                'uso_cfdi' => $validated['uso_cfdi'],
                'unidad_medida' => $validated['unidad_medida'],
                'clave_producto' => $validated['clave_producto'],
                'importe_facturar' => $validated['importe_facturar'],
                'iduserCreated' => auth()->user()->id,
            ]
        );

        session()->flash('success', 'La información del pedido se guardó correctamente');
        return redirect()->route('seminuevos.catalogoUnidadVentaApartado');
    }
}
