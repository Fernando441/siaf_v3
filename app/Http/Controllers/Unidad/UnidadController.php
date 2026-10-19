<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Unidad\Unidad;
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
use App\Models\Unidad\UnidadEquipamiento;

use App\Models\Taller\TallerSolicitud;
use App\Models\Taller\TallerTipoSolicitud;

use App\Models\Unidad\TramiteEmplacamientoRequisito;
use App\Models\Unidad\TramiteEmplacamientoEvidencia;
use App\Models\Unidad\TramiteVerificacionRequisito;
use App\Models\Unidad\TramiteVerificacionEvidencia;
use App\Models\Unidad\TramiteTenenciaRequisito;
use App\Models\Unidad\TramiteTenenciaEvidencia;
use App\Models\Unidad\TramiteReemplacamientoRequisito;
use App\Models\Unidad\TramiteReemplacamientoEvidencia;
use App\Models\Unidad\TramiteCambioPropietarioRequisito;
use App\Models\Unidad\TramiteCambioPropietarioEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroRequisito;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoRoboRequisito;
use App\Models\Unidad\TramiteBajaVehiculoRoboEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoRequisito;  //venta
use App\Models\Unidad\TramiteBajaVehiculoEvidencia;
use App\Models\Unidad\TramiteAseguramientoRequisito;
use App\Models\Unidad\TramiteAseguramientoEvidencia;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Unidad\TramiteGpsRequisito;

use App\Imports\UnidadesImport;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use App\Models\Unidad\UnidadVenta;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UnidadController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
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
            'unidad.no_tarjeta_circulacion',
            'cp.kilometraje'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
            ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
            ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                        'unidad.no_tarjeta_circulacion',
                        'cp.kilometraje'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                        ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                        ->where("unidad.id_status_delete", 1)
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
                'unidad.no_tarjeta_circulacion',
                'cp.kilometraje'
            )
                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
                ->leftjoin("complemento_unidad as cp", "cp.id_unidad", '=', "unidad.id")
                ->where("unidad.id_status_delete", 1)
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
                "kilometraje" => $record->kilometraje,
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

    public function catalogounidad()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();

        return view('unidades.catalogo-unidades', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos'));
    }

    public function cargamasiva()
    {
        $clientes = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
            'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
            'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","client.id_estado")
            ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
            ->where('client.id_status_delete',1)
            ->get();

        $contratos = Proyecto::where('id_status_delete', 1)->get();

      return view('unidades.agregar-carga-masiva', compact('clientes', 'contratos'));  
    }

    public function agregarunidad()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $aseguradoras = AseguradoraUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $tipovehiculo = UnidadTipoVehiculo::where('id_status_delete', 1)->get();
        $complemento_unidad_if = null;
        $op_post = 1;

        $documentos = UnidadTipoDocumento::where('id_unidad_tipo_documento_estatus', 1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($documentos as $documento) {
            $cadenaTipoDocumento .= '"' . $documento->id . '":"' . $documento->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';

        $contratos = Proyecto::where('id_status_delete', 1)->get();
        $tipoasignacion = TipoAsignacion::where('id_status_delete', 1)->get();

        return view('unidades.agregar-unidad', compact('cadenaTipoDocumento', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad_if', 'op_post', 'contratos','tipoasignacion', 'tipovehiculo'));
    }

    public function guardarunidad(Request $request)
    {
        $no_serie = Unidad::where('no_serie', $request->no_serie)->first();
        if ($no_serie == null) {
            $op = 1;
            $id_unidad = $this->agregarinformacionbasica($request, $op);
            $complementounidad = $this->agregarcomplemento($request, $id_unidad);
            $movimiento = 1;
            $unidad_movimiento = $this->unidadmovimiento($request, $id_unidad, $movimiento);
            //inicio recepción de archivos
            $colIdDocumento = $request->id_documento;
            $unidad = Unidad::find($id_unidad);
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


            $colIdDocumento = $request->id_documento;
            $unidad = Unidad::find($id_unidad);
            if ($request->hasfile('foto')) {
                $archivos = $request->file('foto');
                foreach ($archivos as $indice => $archivo) {
                    $archivoNombre = $archivo->hashName();
                    $mimeType = $archivo->getMimeType();
                    Storage::putFileAs('unidad/' . $unidad->id, $archivo, $archivoNombre);
                    $data = [
                        'unidad_id' => $unidad->id,
                        'fotografia' => $archivoNombre,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'iduserCreated' => auth()->user()->id,
                        'iduserUpdated' => auth()->user()->id
                    ];
                    UnidadFotografia::insert($data);
                }
            }
            //fin recepción de fotografia


            session()->flash('success', 'La unidad se creo correctamente');
            return redirect()->route('unidad.catalogounidad');
        } else {
            session()->flash('Danger', 'El numero de serie ingresado ya existe');
            return redirect()->route('unidad.agregarunidad');
        }
    }

    public function agregarinformacionbasica($request, $op)
    {

        $data = [
            'folio' => $this->folio->getFolioUnidad(),
            'id_marca' => $request->id_marca ? $request->id_marca : null,
            'id_modelo' => $request->id_modelo ? $request->id_modelo : null,
            'id_vehiculo_tipo' => 1,
            'unidad_year' => $request->unidad_year,
            'no_serie' => $request->no_serie,
            'placa' => $request->placa,
            'factura_compra' => $request->factura_compra,
            'fecha_factura' => $request->fecha_factura ? Carbon::createFromFormat('d/m/Y', $request->fecha_factura)->format('Y-m-d') : null,
            'numero_economico' => $request->numero_economico,
            'importe_iva' => $request->importe_iva ? $this->money_format->clearFormat($request->importe_iva) : null,
            'clave_vehicular' => $request->clave_vehicular,
            'transmision' => $request->transmision,
            'no_tarjeta_circulacion' => $request->no_tarjeta_circulacion,
            'no_poliza_seguro' => $request->no_poliza_seguro,
            'id_aseguradora' => $request->id_aseguradora ? $request->id_aseguradora : null,
            'fecha_vencimiento_poliza' => $request->fecha_vencimiento_poliza ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_poliza)->format('Y-m-d') : null,
            'numero_inventario' => $request->numero_inventario,
            'color' => $request->color,
            'id_status' => $request->id_status ? $request->id_status : null,
            'unidad_asignacion_id' => $request->contrato_op,
            'fecha_asignacion' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
            'id_tipo_asignacion' => $request->id_tipo_asignacion,
            'id_status_delete' => 1,
            'unidad_requisicion_estatus_id' => 1,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if($request->contrato_op == 1){
            $data['proyectos_id'] = $request->id_contrato_asignar;
            $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
            $data['licitaciones_id'] = $licitacion->licitacion_id;
        }else{
            $data['id_ubicacion'] = $request->id_ubicacion_asignar;
        }

        return Unidad::insertGetId($data);
    }

    public function agregarcomplemento($request, $id_unidad)
    {

        $data = [
            'id_unidad' => $id_unidad,
            'num_gps' => $request->num_gps,
            'kilometraje' => $request->kilometraje,
            'marca_bateria' => $request->marca_bateria,
            'marca_llantas' => $request->marca_llantas,
            'rin' => $request->rin,
            'motor' => $request->motor,
            'vestiduras' => $request->vestiduras,
            'llantas' => $request->llantas,
            'pintura' => $request->pintura,
            'llanta_refaccion' => $request->llanta_refaccion,
            'gato' => $request->gato,
            'herramientas' => $request->herramientas,
            'espejo_retrovisor' => $request->espejo_retrovisor,
            'funciona_motor' => $request->funciona_motor,
            'llaves_vehiculo' => $request->llaves_vehiculo,
            'radio' => $request->radio,
            'bocinas' => $request->bocinas,
            'aire_acondicionado' => $request->aire_acondicionado,
            'birlos' => $request->birlos,
            'tapetes' => $request->tapetes,
            'senalizaciones' => $request->senalizaciones,
            'elaboro' => auth()->user()->name,
            'observaciones' => $request->observaciones,
            'conteo_niv' => $request->conteo_niv,
            'conteo_year' => $request->conteo_year,
            'rango_km' => $request->rango_km,
            'registro_repuve' => $request->registro_repuve,
            'fecha_ingreso' => $request->fecha_ingreso ? Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso)->format('Y-m-d') : null,
            'fecha_salida' => $request->fecha_salida ? Carbon::createFromFormat('d/m/Y', $request->fecha_salida)->format('Y-m-d') : null,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        ComplementoUnidad::insert($data);
    }

    public function unidadmovimiento($request, $id_unidad, $movimiento)
    {
        $data = [
            'unidad_id'=> $id_unidad,
            'asignacion_id' =>$request->contrato_op,
            'fecha_asignacion' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
            'tipo_asignacion_id' => $request->id_tipo_asignacion,
            'updated_at' => date('Y-m-d H:i:s'),
            'iduserUpdated' => auth()->user()->id,
            'iduserCreated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if($request->contrato_op == 1){
            $data['proyectos_id'] = $request->id_contrato_asignar;
            $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
            $data['licitacion_id'] = $licitacion->licitacion_id;
            
        }else{
            $data['ubicacion_id'] = $request->id_ubicacion_asignar;
        }

        if($movimiento == 1){
            UnidadMovimientos::insert($data);
        }
    }

    public function unidadeditmovimiento($request, $id_unidad, $unidad_data)
    {

        $registro_unidad = UnidadMovimientos::where('unidad_id',$id_unidad)->latest()->first();

        if($registro_unidad == null){
            $movimiento = 1;
            $unidad_movimiento = $this->unidadmovimiento($request, $id_unidad, $movimiento);
        }else{
            $data = [
                'unidad_id'=> $request->id,
                'asignacion_id' =>$request->contrato_op,
                'fecha_asignacion' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
                'tipo_asignacion_id' => $request->id_tipo_asignacion,
                'updated_at' => date('Y-m-d H:i:s'),
                'iduserUpdated' => auth()->user()->id,
                'iduserCreated' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $move= [
                'fecha_salida' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
                'updated_at' => date('Y-m-d H:i:s'),
                'iduserUpdated' => auth()->user()->id,
            ];

            if($unidad_data->unidad_asignacion_id != $request->contrato_op){
                if($request->contrato_op == 1){
                    if($unidad_data->proyectos_id != $request->id_contrato_asignar){
                        $data['proyectos_id'] = $request->id_contrato_asignar;
                        $data['ubicacion_id'] = null;
                        $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
                        $data['licitacion_id'] = $licitacion->licitacion_id;
                        UnidadMovimientos::where('unidad_id',$id_unidad)->latest()->update($move);
                        UnidadMovimientos::insert($data);
                    }
                }else{
                    if($unidad_data->ubicacion_id != $request->id_ubicacion_asignar){
                        $data['ubicacion_id'] = $request->id_ubicacion_asignar;
                        $data['proyectos_id'] = null;
                        $data['licitacion_id'] = null;
                        UnidadMovimientos::where('unidad_id',$id_unidad)->latest()->update($move);
                        UnidadMovimientos::insert($data);
                    }
                }
            }else{
                if($request->contrato_op == 1){
                    if($registro_unidad->proyectos_id != $request->id_contrato_asignar){
                        $data['proyectos_id'] = $request->id_contrato_asignar;
                        $data['ubicacion_id'] = null;
                        $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
                        $data['licitacion_id'] = $licitacion->licitacion_id;
                        UnidadMovimientos::where('unidad_id',$id_unidad)->latest()->update($move);
                        UnidadMovimientos::insert($data);
                    }
                }else{
                    if($registro_unidad->ubicacion_id != $request->id_ubicacion_asignar){
                        $data['ubicacion_id'] = $request->id_ubicacion_asignar;
                        $data['proyectos_id'] = null;
                        $data['licitacion_id'] = null;
                        UnidadMovimientos::where('unidad_id',$id_unidad)->latest()->update($move);
                        UnidadMovimientos::insert($data);
                    }
                }
            }            
        }

    }

    public function editarunidad($unidad)
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

        $contratos = Proyecto::where('id_status_delete', 1)->get();
        $tipoasignacion = TipoAsignacion::where('id_status_delete', 1)->get();

        return view('unidades.editar-unidad', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'cadenaTipoDocumento', 'fotografias', 'contratos', 'tipoasignacion', 'tipovehiculo'));
    }

    public function editarinfobasica(Request $request)
    {
        // dd($request);
        $unidad_data = Unidad::where('id', $request->id)->first();
        // $unidad_movimiento = $this->unidadeditmovimiento($request, $request->id, $unidad_data);

        if ($unidad_data->fecha_vencimiento_poliza == $request->fecha_vencimiento_poliza) {
            $fecha_vencimiento_poliza = $request->fecha_vencimiento_poliza;
        } else {
            $fecha_vencimiento_poliza = $request->fecha_vencimiento_poliza ? Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento_poliza)->format('Y-m-d') : null;
        }

        $data = [

            'placa' => $request->placa,
            'clave_vehicular' => $request->clave_vehicular,
            'numero_economico' => $request->numero_economico,
            'transmision' => $request->transmision,
            'no_tarjeta_circulacion' => $request->no_tarjeta_circulacion,
            // 'no_poliza_seguro' => $request->no_poliza_seguro,
            // 'id_aseguradora' => $request->id_aseguradora ? $request->id_aseguradora : null,
            // 'fecha_vencimiento_poliza' => $fecha_vencimiento_poliza,
            // 'unidad_asignacion_id' => $request->contrato_op,
            // 'fecha_asignacion' => $request->fecha_asignacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_asignacion)->format('Y-m-d') : null,
            // 'id_tipo_asignacion' => $request->id_tipo_asignacion,
            // 'id_status' => $request->id_status ? $request->id_status : null,
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // if($request->contrato_op == 1){
        //     $data['proyectos_id'] = $request->id_contrato_asignar;
        //     $data['id_ubicacion'] = null;
        //     $licitacion = Proyecto::where('id', $request->id_contrato_asignar)->first();
        //     $data['licitaciones_id'] = $licitacion->licitacion_id;
        // }else{
        //     $data['id_ubicacion'] = $request->id_ubicacion_asignar;
        //     $data['proyectos_id'] = null;
        //     $data['licitaciones_id'] = null;
        // }


        Unidad::where('id', $request->id)->update($data);

        $unidad_info = ComplementoUnidad::where('id_unidad', $request->id)->first();

        if ($request->fecha_ingreso == null) {
            $fecha_ingreso = null;
        } else {
            if ($unidad_info->fecha_ingreso == $request->fecha_ingreso) {
                $fecha_ingreso = $request->fecha_ingreso;
            } else {
                $fecha_ingreso = $request->fecha_ingreso ? Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso)->format('Y-m-d') : null;
            }
        }

        if ($request->fecha_salida == null) {
            $fecha_salida = null;
        } else {
            if ($unidad_info->fecha_salida == $request->fecha_salida) {
                $fecha_salida = $request->fecha_salida;
            } else {
                $fecha_salida = $request->fecha_salida ? Carbon::createFromFormat('d/m/Y', $request->fecha_salida)->format('Y-m-d') : null;
            }
        }

        $data = [
            'id_unidad' => $request->id,
            'num_gps' => $request->num_gps,
            'kilometraje' => $request->kilometraje,
            'marca_bateria' => $request->marca_bateria,
            'marca_llantas' => $request->marca_llantas,
            'rin' => $request->rin,
            'motor' => $request->motor,
            'vestiduras' => $request->vestiduras,
            'llantas' => $request->llantas,
            'pintura' => $request->pintura,
            'llanta_refaccion' => $request->llanta_refaccion,
            'gato' => $request->gato,
            'herramientas' => $request->herramientas,
            'espejo_retrovisor' => $request->espejo_retrovisor,
            'funciona_motor' => $request->funciona_motor,
            'llaves_vehiculo' => $request->llaves_vehiculo,
            'radio' => $request->radio,
            'bocinas' => $request->bocinas,
            'aire_acondicionado' => $request->aire_acondicionado,
            'birlos' => $request->birlos,
            'tapetes' => $request->tapetes,
            'senalizaciones' => $request->senalizaciones,
            'elaboro' => auth()->user()->name,
            'observaciones' => $request->observaciones,
            'conteo_niv' => $request->conteo_niv,
            'conteo_year' => $request->conteo_year,
            'rango_km' => $request->rango_km,
            'registro_repuve' => $request->registro_repuve,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_salida' => $fecha_salida,
            'iduserUpdated' => auth()->user()->id,
            'iduserCreated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $complemento_info = ComplementoUnidad::where('id_unidad', $request->id)->first();

        if ($complemento_info == null) {
            ComplementoUnidad::insert($data);
        } else {
            ComplementoUnidad::where('id_unidad', $request->id)->update($data);
        }



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

        $colIdDocumento = $request->id_documento;
        $unidad = Unidad::find($request->id);
        if ($request->hasfile('foto')) {
            $archivos = $request->file('foto');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('unidad/' . $unidad->id, $archivo, $archivoNombre);
                $data = [
                    'unidad_id' => $unidad->id,
                    'fotografia' => $archivoNombre,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];
                UnidadFotografia::insert($data);
            }
        }




        session()->flash('success', 'La información basica de la unidad se modifico correctamente');
        return redirect()->route('unidad.catalogounidad', $request->id);
    }

    public function eliminardocumento(Request $request)
    {
        $doc = UnidadDocumento::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('unidad/' . $doc->id_unidad . '/' . $doc->documento);
            UnidadDocumento::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function eliminarfotografia(Request $request)
    {
        $doc = UnidadFotografia::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('unidad/' . $doc->unidad_id . '/' . $doc->fotografia);
            UnidadFotografia::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }


    public function editarinfocomplemento(Request $request)
    {

        session()->flash('success', 'La informacón general se modifico correctamente');
        return redirect()->route('unidad.editarunidad', $request->id);
    }

    public function guardarfotounidad(Request $request)
    {
        $info_unidad = Unidad::where('id', $request->id_unidad)->first();
        $no_serie = $info_unidad->no_serie;
        dd(Storage::disk('public')->put('unidad/' . $no_serie . '/', $request->file('foto_unidad')));
        $path = Storage::disk('public')->put('unidad/' . $no_serie . '/', $request->file('foto_unidad'));
        $archivo_cer = $rest = substr($path, 10);
        dd($archivo_cer);
        $subido_cer = Storage::disk('public')->move('unidad/' . $no_serie . '/' . $archivo_cer, 'unidad/' . $no_serie . '/' . $request->nombre . ".txt");
    }

    public function informacionunidad($unidad)
    {

        $unidad_id = $unidad;
        $info_unidad = Unidad::select(
            'un.id',
            'un.folio',
            'un.id_ubicacion',
            'un.fecha',
            'un.id_marca',
            'un.id_modelo',
            'un.unidad_year',
            'un.no_serie',
            'un.placa',
            'un.transmision',
            'un.no_tarjeta_circulacion',
            'un.no_poliza_seguro',
            'un.fecha_vencimiento_poliza',
            'un.numero_inventario',
            'un.color',
            'un.id_status',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'asu.nombre_aseguradora'
        )
            ->from("unidad as un")
            ->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "un.id_ubicacion")
            ->leftjoin("aseguradora_unidad as asu", "asu.id", '=', 'un.id_aseguradora')
            ->where('un.id', $unidad_id)
            ->get();
        $complemento_unidad = ComplementoUnidad::where('id_unidad', $unidad)->get();
        $complemento_unidad_if = ComplementoUnidad::where('id_unidad', $unidad)->first();

        return view('unidades.informacion-unidad', compact('info_unidad', 'complemento_unidad', 'complemento_unidad_if'));
    }

    public function estadisticas()
    {
        return view('unidades.estadisticas-unidades');
    }


    public function catalogounidaddesinactivas()
    {
        $unidades = Unidad::select(
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
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'unidad.motivo_desactivar'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where("unidad.id_status_delete", 2)
            ->get();

        return view('unidades.catalogo-unidades-inactivas', compact('unidades'));
    }

    public function eliminarunidad(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo_desactivar' => $request->motivo,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Unidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La unidad se desactivo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

    public function activarunidad(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Unidad::where('id', $request->id)->update($data);

        session()->flash('success', 'La unidad se activo correctamente');
        return redirect()->route('unidad.catalogounidaddesinactivas');
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


        return view('unidades.ver-unidad', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'fotografias', 'ver', 'bitacora_unidad', 'solicitudes', 'info_seguros', 'info_gps', 'unidad_movimiento'));
    }

    public function cargamasivaexcel(Request $request)
    {

        Excel::import(new UnidadesImport,request()->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('unidad.catalogounidad');
    }

    public function informacionseguro($unidad)
    {
        $tipo_cobertura = TipoCobertura::where('id_status_delete', 1)->get();

        $info_seguro_unidad = InformacionSeguroUnidad::where('unidad_id', $unidad)->first();
        if($info_seguro_unidad == null)
        {
            return view('unidades.agregar-info-seguros', compact('tipo_cobertura', 'unidad'));
        }else{
            
            return view('unidades.editar-info-seguros', compact('tipo_cobertura', 'unidad', 'info_seguro_unidad'));
        }
    }

    public function guardarinfoseguro(Request $request)
    {

        $data = [
            'unidad_id' => $request->unidad_id,
            'nombre_titular' => $request->nombre_titular,
            'direccion_titular' => $request->direccion_titular,
            'numero_poliza' => $request->numero_poliza,
            'fecha_cobertura' => $request->fecha_cobertura ? Carbon::createFromFormat('d/m/Y', $request->fecha_cobertura)->format('Y-m-d'):null,
            'fecha_final_cobertura' => $request->fecha_final_cobertura ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_cobertura)->format('Y-m-d'):null,
            'unidad_tipo_cobertura_id' => $request->tipo_cobertura,
            'limites_cobertura' => $request->limites_cobertura,
            'email_titutlar' => $request->email_titutlar,
            'telefono_titular' => $request->telefono_titular,
            'nombre_compania' => $request->nombre_compania,
            'telefono_compania' => $request->telefono_compania,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        
        $id = InformacionSeguroUnidad::insert($data);


        session()->flash('success', 'La información del seguro se creo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

    public function editarinfoseguro(Request $request)
    {

        $data = [
            'unidad_id' => $request->unidad_id,
            'nombre_titular' => $request->nombre_titular,
            'direccion_titular' => $request->direccion_titular,
            'numero_poliza' => $request->numero_poliza,
            'fecha_cobertura' => $request->fecha_cobertura ? Carbon::createFromFormat('d/m/Y', $request->fecha_cobertura)->format('Y-m-d'):null,
            'fecha_final_cobertura' => $request->fecha_final_cobertura ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_cobertura)->format('Y-m-d'):null,
            'unidad_tipo_cobertura_id' => $request->tipo_cobertura,
            'limites_cobertura' => $request->limites_cobertura,
            'email_titutlar' => $request->email_titutlar,
            'telefono_titular' => $request->telefono_titular,
            'nombre_compania' => $request->nombre_compania,
            'telefono_compania' => $request->telefono_compania,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];
     
        InformacionSeguroUnidad::where('unidad_id', $request->unidad_id)->update($data);   

        session()->flash('success', 'La información del seguro se modifico correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

    public function informaciongps($unidad)
    {
        $info_gps_unidad = InformacionGpsUnidad::where('unidad_id', $unidad)->first();
        if($info_gps_unidad == null)
        {
            return view('unidades.agregar-info-gps', compact( 'unidad'));
        }else{
            
            return view('unidades.editar-info-gps', compact('unidad', 'info_gps_unidad'));
        }
    }

    public function guardarinfogps(Request $request)
    {

        $data = [
            'unidad_id' => $request->unidad_id,
            'numero_gps' => $request->numero_gps,
            'marca_gps' => $request->marca_gps,
            'modelo_gps' => $request->modelo_gps,
            'fecha_instalacion' => $request->fecha_instalacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion)->format('Y-m-d'):null,
            'info_proveedor' => $request->info_proveedor,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')

        ];
        $id = InformacionGpsUnidad::insert($data);


        session()->flash('success', 'La información del gps se creo correctamente');
        return redirect()->route('unidad.catalogounidad');

    }

    public function editarinfogps(Request $request)
    {

        $data = [
            'unidad_id' => $request->unidad_id,
            'numero_gps' => $request->numero_gps,
            'marca_gps' => $request->marca_gps,
            'modelo_gps' => $request->modelo_gps,
            'fecha_instalacion' => $request->fecha_instalacion ? Carbon::createFromFormat('d/m/Y', $request->fecha_instalacion)->format('Y-m-d'):null,
            'info_proveedor' => $request->info_proveedor,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')

        ];

        InformacionGpsUnidad::where('unidad_id', $request->unidad_id)->update($data);   

        session()->flash('success', 'La información del gps se modifico correctamente');
        return redirect()->route('unidad.catalogounidad');      
    }

    public function tramitesvehiculares($unidad)
    {
        $req_emplacamiento = TramiteEmplacamientoRequisito::where('id_status_delete', 1)->get();
        $req_tenencia = TramiteTenenciaRequisito::where('id_status_delete', 1)->get();
        $req_verificacion = TramiteVerificacionRequisito::where('id_status_delete', 1)->get();
        $req_aseguramiento = TramiteAseguramientoRequisito::where('id_status_delete', 1)->get();
        $req_reemplacamiento = TramiteReemplacamientoRequisito::where('id_status_delete', 1)->get();
        $req_bajav_venta = TramiteBajaVehiculoRequisito::where('id_status_delete', 1)->get();
        $req_bajav_robo = TramiteBajaVehiculoRoboRequisito::where('id_status_delete', 1)->get();
        $req_bajav_siniestro = TramiteBajaVehiculoSiniestroRequisito::where('id_status_delete', 1)->get();
        $req_cambio_propietario = TramiteCambioPropietarioRequisito::where('id_status_delete', 1)->get();
        $req_gps = TramiteGpsRequisito::where('id_status_delete', 1)->get();

       return view('unidades.agregar-tramites-vehiculares', compact( 'unidad', 'req_emplacamiento', 'req_tenencia', 'req_verificacion', 'req_aseguramiento', 'req_reemplacamiento', 'req_bajav_venta', 'req_bajav_robo', 'req_bajav_siniestro', 'req_cambio_propietario', 'req_gps')); 
    }

    public function equipamientounidad($unidad)
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
        $equipamiento_pendiente = UnidadEquipamiento::where('equipamiento_pendiente', 0)->where('unidad_id', $unidad)->get();
        $alert = count($equipamiento_pendiente);


        return view('unidades.agregar-equipamiento-unidad', compact(  'unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'equipamiento_completo','equipamiento_pendiente', 'alert'));    
    }

    public function venta($unidad)
    {
        $unidad = Unidad::find($unidad);
        $complemento_unidad = ComplementoUnidad::where('id_unidad', $unidad->id)->first();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();

        return view('unidades.vender-unidad', compact('unidad', 'marcas', 'modelos', 'estatus', 'complemento_unidad'));
    }

    public function ventaGuardar(Request $request)
    {
        $unidadId = $request->unidad_id;
        $politicas = $request->politicas;
        $comentarios = $request->comentarios;
        $unidad = Unidad::find($unidadId);
        if ($unidad) {
            $unidadVenta = new UnidadVenta();
            $unidadVenta->id_unidad = $unidadId;
            $unidadVenta->politicas = $politicas;
            $unidadVenta->politicas_comentarios = $comentarios;
            $unidadVenta->iduserCreated = auth()->user()->id;
            $unidadVenta->id_status_delete = 1;
            $unidadVenta->vendido = 0;
            $unidadVenta->save();
        }

        session()->flash('success', 'La unidad se enviò al catàlogo de unidades para venta');
        return redirect()->route('unidad.catalogounidad');
    }
    
}
