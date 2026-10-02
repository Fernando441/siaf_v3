<?php

namespace App\Http\Controllers\Solicitud;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use App\Models\Unidad\Unidad;
use App\Models\Proyecto\Proyecto;
use App\Models\Unidad\MarcaUnidad;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Taured\CommonLibs\StringUtils;
use App\Models\Solicitud\Solicitud;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Http\Controllers\Controller;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Solicitud\SolicitudTipo;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use App\Models\Solicitud\ActividadUnidad;
use App\Models\Solicitud\SolicitudUnidad;
use App\Models\Solicitud\SolicitudTecnico;
use App\Models\Solicitud\SolicitudBitacora;
use App\Models\Solicitud\SolicitudDocumento;
use App\Models\Solicitud\SolicitudEjecucion;
use App\Models\Solicitud\SolicitudValidacion;

class SolicitudController extends Controller
{

	public function listado()
	{
		return view('solicitud.solicitud', []);
	}

	public function nuevo()
	{
		$solicitudTipo = SolicitudTipo::where('activo', 1)->get();
		$ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
		$marcas = MarcaUnidad::where('id_status_delete', 1)->get();
		$modelos = ModeloUnidad::where('id_status_delete', 1)->get();
		$estatus = StatusUnidad::where('id_status_delete', 1)->get();
		$contratos = Proyecto::where('id_status_delete', 1)->get();

		return view('solicitud.nuevo', compact('solicitudTipo', 'ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos'));
	}

	public function guardar(Request $request)
	{
		$solicitud = new Solicitud();
		$solicitud->solicitud_tipo_id = $request->solicitud_tipo;
		$solicitud->solicitud_estatus_id = 1;
		$solicitud->activo = 1;
		$solicitud->fecha = date('Y-m-d H:i:s');
		$solicitud->nombre = $request->nombre_contacto;
		$solicitud->direccion = $request->direccion_contacto;
		$solicitud->telefono = $request->telefono_contacto;
		$solicitud->comentarios = $request->comentario;
		$solicitud->user_updated_id = auth()->user()->id;
		$solicitud->user_created_id = auth()->user()->id;
		$solicitud->save();

		$vehiculos = $request->vehiculos;
		foreach ($vehiculos as $key => $vehiculo) {
			$solicitudUnidad =  new SolicitudUnidad();
			$solicitudUnidad->solicitud_id = $solicitud->id;
			$solicitudUnidad->unidad_id = $vehiculo;
			$solicitudUnidad->save();
		}

		$solicitudBitacora = new SolicitudBitacora();
		$solicitudBitacora->bitacora = "Se envía a revisión";
		$solicitudBitacora->solicitud_id = $solicitud->id;
		$solicitudBitacora->solicitud_estatus_id = 1;
		$solicitudBitacora->activo = 1;
		$solicitudBitacora->save();

		session()->flash('success', 'La solicitud con #ID ' . $solicitud->id . ' de GPS se creo correctamente');
		return redirect()->route('solicitud.listado');
	}

	public function datosListado(Request $request)
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
		$totalRecords = Solicitud::select('count(*) as allcount')->count();
		$totalRecordswithFilter = Solicitud::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();

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
		$records = Solicitud::select(
			'solicitud.*'
			)
			->with('solicitudUnidades')
			->where("solicitud.activo", 1)
			->orderBy($order_column_name, $order_column_dir)
			->skip($start)
			->take($rowperpage)
			->get();


		$totalRecords = count($records);
		$totalRecordswithFilter = count($records);

		$data_arr = array();
		foreach ($records as $record) {

			$data_arr[] = array(
				"id" => $record->id,
				"solicitud_tipo" => $record->solicitudTipo->tipo,
				"solicitud_tipo_id" => $record->solicitud_tipo_id,
				"solicitud_estatus" => $record->solicitudEstatus->estatus,
				"solicitud_estatus_id" => $record->solicitud_estatus_id,
				"vehiculos" => !empty($record->solicitudUnidades) ? count($record->solicitudUnidades) : "",
				"fecha" => date_format(new DateTime($record->fecha), 'Y-m-d'),
				"nombre" => $record->nombre,
				"direccion" => $record->direccion,
				"telefono" => $record->telefono,
				"permisos" => $permiso_array,
				"acciones" => '',
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

	public function ver(Request $request)
	{

		$solicitudId = $request->id;
		$solicitudes = Solicitud::select(
			'solicitud.*'
		)
		->with('solicitudUnidades','solicitudBitacoras','solicitudValidaciones')
		->where('solicitud.activo',1)
		->where('solicitud.id', $solicitudId)
		->get()->first();

        $solicitudEjecucion = SolicitudEjecucion::where('solicitud_id', $solicitudId)
        ->where('activo', 1)->orderBy('created_at', 'desc')->get()->first();

		$solicitudValidacion = SolicitudValidacion::where('solicitud_id', $solicitudId)
        ->where('activo', 1)->orderBy('created_at', 'desc')->get()->first();

		$solicitudBitacora = SolicitudBitacora::where('solicitud_id', $solicitudId)
		->where('activo', 1)->orderBy('created_at', 'asc')->get();

		return view('solicitud.ver', compact('solicitudes', 'solicitudEjecucion', 'solicitudValidacion', 'solicitudBitacora'));
	}

	public function unidadDatos(Request $request)
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
			'so.activo as solicitud_activo'
		)
			->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
			->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
			->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
			->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
			->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
			->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
			->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
			->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
			->where("unidad.id_status_delete", 1)
			->where("uv.id_status_delete", 1)
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'

					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
					$series = preg_split('/[\s,]+/', $valor, -1, PREG_SPLIT_NO_EMPTY);
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
						->where("unidad.id_status_delete", 1)
						->whereIn("unidad.no_serie", $series)
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
						'so.activo as solicitud_activo'
					)
						->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
						->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
						->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
						->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
						->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
						->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
						->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
						->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
				'so.activo as solicitud_activo'
			)
				->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
				->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
				->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
				->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
				->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
				->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
				->leftjoin("solicitud_unidad as su", "su.unidad_id", '=', "unidad.id")
				->leftjoin("solicitud as so", "so.id", '=', "su.solicitud_id")
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
				"solicitud_activo" => $record->solicitud_activo ?? 0
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

	public function listadoValidacion()
	{
		return view('solicitud.solicitudRevision', []);
	}

	public function validacion(Request $request)
	{

		$solicitudId = $request->id;
		$solicitudes = Solicitud::select(
			'solicitud.*'
		)
		->with('solicitudUnidades','solicitudBitacoras','solicitudValidaciones')
		->where('solicitud.activo',1)
		->where('solicitud.id', $solicitudId)
		->get()->first();

		return view('solicitud.validacion', compact('solicitudes'));
	}
	
	public function guardarValidacion(Request $request)
	{
		$solicitudId = $request->solicitud_id;
		$opcion = (int) $request->opcion_guardar;
		$solciitudEstatus = match ($opcion) {
			1 => 2,
			2 => 6
		};
		$solicitudValidacion = new SolicitudValidacion();
		$solicitudValidacion->solicitud_id = $solicitudId;
		$solicitudValidacion->solicitud_estatus_id = $solciitudEstatus;
		$solicitudValidacion->activo = 1;
		$solicitudValidacion->comentarios = $request->comentarios;
		$solicitudValidacion->save();

		$solicitud = Solicitud::where('id', $solicitudId)
		->where('solicitud_estatus_id', 1)->get()->first();
		$solicitud->solicitud_estatus_id = $solciitudEstatus;
		$solicitud->save();

		$solcitudEstatusMensaje = match ($opcion) {
			1 => 'Se valida y se envía a proveedor',
			2 => 'Solicitud rechazada, y devuelta a solicitante'
		};
		$solicitudBitacora = new SolicitudBitacora();
		$solicitudBitacora->bitacora = $solcitudEstatusMensaje;
		$solicitudBitacora->solicitud_id = $solicitud->id;
		$solicitudBitacora->solicitud_estatus_id = $solciitudEstatus;
		$solicitudBitacora->activo = 1;
		$solicitudBitacora->save();

		session()->flash('success', 'La solicitud con #ID ' . $solicitud->id . ', '.$solcitudEstatusMensaje);
		return redirect()->route('solicitud.listadoValidacion');
	}

	public function listadoProveedor(Request $request)
	{
		return view('solicitud.solicitudProveedor');
	}

	public function programarActividad(Request $request)
	{

		$solicitudId = $request->id;
		$solicitudes = Solicitud::select(
			'solicitud.*'
		)
		->with('solicitudUnidades','solicitudBitacoras','solicitudValidaciones')
		->where('solicitud.activo',1)
		->where('solicitud.id', $solicitudId)
		->get()->first();

		return view('solicitud.programar-actividad', compact('solicitudes', 'solicitudId'));
	}

	public function datosListadoProveedor(Request $request)
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
		$totalRecords = Solicitud::select('count(*) as allcount')->count();
		$totalRecordswithFilter = Solicitud::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();

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
		$records = Solicitud::select(
			'solicitud.*'
			)
			->with('solicitudUnidades')
			->where("solicitud.activo", 1)
			->whereIn("solicitud.solicitud_estatus_id", [2, 6])
			->orderBy($order_column_name, $order_column_dir)
			->skip($start)
			->take($rowperpage)
			->get();

		$totalRecords = count($records);
		$totalRecordswithFilter = count($records);

		$data_arr = array();
		foreach ($records as $record) {
			$solicitudEjecucion = SolicitudEjecucion::where('solicitud_id', $record->id)->get()->first();
			$data_arr[] = array(
				"id" => $record->id,
				"solicitud_tipo" => $record->solicitudTipo->tipo,
				"solicitud_tipo_id" => $record->solicitud_tipo_id,
				"solicitud_estatus" => $record->solicitudEstatus->estatus,
				"solicitud_estatus_id" => $record->solicitud_estatus_id,
				"vehiculos" => !empty($record->solicitudUnidades) ? count($record->solicitudUnidades) : "",
				"fecha" => date_format(new DateTime($record->fecha), 'Y-m-d'),
				"nombre" => $record->nombre,
				"direccion" => $record->direccion,
				"telefono" => $record->telefono,
				"permisos" => $permiso_array,
				"acciones" => '',
				"solicitud_ejecucion_id" => isset($solicitudEjecucion) ? $solicitudEjecucion->id : null,
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

	public function unidadDatosSolicitud(Request $request)
	{

		$user = User::where('id', auth()->user()->id)->first();
		$permisos = RolPermiso::where('role_id', $user->role)->get();
		$permiso_array = array();
		foreach ($permisos as $key => $value) {
			$permiso_array[] = $value->permission_id;
		}

		$solcitudId = $request->solicitud_id;
		$solicitudEjecucionId = $request->solicitud_ejecucion_id;
		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page

		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$search_arr = $request->get('search');
		$searchValue = $search_arr['value']; // Search value

		// Total records
		$totalRecords = SolicitudUnidad::select('count(*) as allcount')->where('solicitud_id', $solcitudId)->count();
		$totalRecordswithFilter = SolicitudUnidad::select('count(*) as allcount')->where('unidad_id', 'like', '%' . $searchValue . '%')->count();

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
		 $records = SolicitudUnidad::select(
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
			'unidad.numero_economico',
			'unidad.clave_vehicular',
			'unidad.no_tarjeta_circulacion',
			'solicitud_id'
			)
			->with('solicitud')
			->join('unidad', 'solicitud_unidad.unidad_id', '=', 'unidad.id')
			->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
			->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
			->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
			->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
			->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
			->where("unidad.id_status_delete", 1)
			->where('solicitud_unidad.solicitud_id', $solcitudId)
			->orderBy($order_column_name, $order_column_dir)
			->skip($start)
			->take($rowperpage)
			->get();

		$totalRecords = count($records);
		$totalRecordswithFilter = count($records);

		// dd($records);
		$data_arr = array();
		foreach ($records as $record) {

            $actividadUnidad = ActividadUnidad::where('solicitud_ejecucion_id', $solicitudEjecucionId)->where('unidad_id', $record->id)->get()->first();

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
				"actividad_unidad_id" => isset($actividadUnidad) ? $actividadUnidad->id : '',
				"actividad_unidad_idgps" => isset($actividadUnidad) ? $actividadUnidad->idgps : '',
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

	public function guardarDetalle(Request $request)
	{
		$solicitudId = $request->solicitud_id;
		$unidadId = $request->unidad_id;
		$idgps = $request->idgps;
		$comentarios = $request->comentarios;
		$solicitudEjecucion = SolicitudEjecucion::where('solicitud_id', $solicitudId)
		->where('activo', 1)->get()->first();
		$fechaActividad = $request->fecha_actividad;
		$nombreTecnico = $request->nombre_tecnico;
		$fecha = Carbon::createFromDate($fechaActividad);

		if (is_null($solicitudEjecucion)) {
			$solicitudEjecucion = new SolicitudEjecucion();
			$solicitudEjecucion->solicitud_id = $solicitudId;
			$solicitudEjecucion->fecha_actividad = $fecha;
			$solicitudEjecucion->nombre_tecnico = $nombreTecnico;
			$solicitudEjecucion->fecha_elaboracion = date('Y-m-d H:i:s');
			$solicitudEjecucion->activo = 1;
			$solicitudEjecucion->save();
		}

		$actividadUnidad = ActividadUnidad::where('solicitud_ejecucion_id', $solicitudEjecucion->id)
		->where('unidad_id', $unidadId)->get()->first();

		if (is_null($actividadUnidad)) {
			$actividadUnidad =  new ActividadUnidad();
			$actividadUnidad->solicitud_ejecucion_id = $solicitudEjecucion->id;
			$actividadUnidad->unidad_id = $unidadId;
			$actividadUnidad->idgps = $idgps;
			$actividadUnidad->comentarios = $comentarios;
			$actividadUnidad->save();
		} else {
			$actividadUnidad->idgps = $idgps;
			$actividadUnidad->comentarios = $comentarios;
			$actividadUnidad->save();
		}

		$response = array(
			"estatus" => true,
			"actividad_unidad_id" => $actividadUnidad->id,
			"solicitud_ejecucion_id" => $solicitudEjecucion->id,
		);

		return response()->json($response);
	}

	public function detalleActividad(Request $request)
	{
		$actividadUnidadId = $request->actividad_unidad_id;
		$actividadUnidad = ActividadUnidad::where('id', $actividadUnidadId)->get()->first();
		$solicitudDocumento = SolicitudDocumento::where('actividad_unidad_id', $actividadUnidadId)
		->where('activo', 1)->get();
		return response()->json([
			"estatus" => true,
			"idgps" => $actividadUnidad->idgps,
			"comentarios" => $actividadUnidad->comentarios,
			"solicitud_documentos" => $solicitudDocumento
		]);
	}

	public function guardarActividad(Request $request)
	{
		$solicitudEjecucionId = $request->solicitud_ejecucion_id;
		$opcionGuardar = $request->opcion_guardar;
		$solicitudId = $request->solicitud_id;
		$nombreTecnico = $request->nombre_tecnico;
		$fechaActividad = $request->fecha_actividad;
        $fecha = DateTime::createFromFormat('d/m/Y h:i A', $fechaActividad)->format('Y-m-d H:i:s');

		$solicitudEjecucion = SolicitudEjecucion::where('id', $solicitudEjecucionId)
		->where('activo', 1)->get()->first();

		if (is_null($solicitudEjecucion)) {
			$solicitudEjecucion = new SolicitudEjecucion();
			$solicitudEjecucion->solicitud_id = $solicitudId;
			$solicitudEjecucion->fecha_actividad = $fecha;
			$solicitudEjecucion->nombre_tecnico = $nombreTecnico;
			$solicitudEjecucion->fecha_elaboracion = date('Y-m-d H:i:s');
			$solicitudEjecucion->activo = 1;
			$solicitudEjecucion->save();
		} else {
			$solicitudEjecucion->fecha_actividad = $fecha;
			$solicitudEjecucion->nombre_tecnico = $nombreTecnico;
			$solicitudEjecucion->fecha_elaboracion = date('Y-m-d H:i:s');
			$solicitudEjecucion->save();
		}

        if ($opcionGuardar == 1) {
            $solicitud = Solicitud::where('activo', 1)->find($solicitudId);
            $solicitud->solicitud_estatus_id = 5; // 5 = Enviado para su validación
            $solicitud->save();

            $solicitudBitacora = new SolicitudBitacora();
            $solicitudBitacora->solicitud_id = $solicitudId;
            $solicitudBitacora->solicitud_estatus_id = 5;
            $solicitudBitacora->activo = 1;
            $solicitudBitacora->bitacora = 'Se envio para su validación';
            $solicitudBitacora->save();
        }

		session()->flash('success', 'La solicitud con #ID ' . $solicitudId . ' de GPS se guardo correctamente');
		return redirect()->route('solicitud.listadoProveedor');
	}

	public function editarDetalleActividad(Request $request)
	{
		$solicitudId = $request->id;
		$solicitudEjecucion = SolicitudEjecucion::where('activo', 1)->where('solicitud_id', $solicitudId)->orderBy('created_at', 'desc')->firstOrFail();
		$solicitudes = Solicitud::select(
			'solicitud.*'
		)
		->with('solicitudUnidades','solicitudBitacoras','solicitudValidaciones')
		->where('solicitud.activo',1)
		->where('solicitud.id', $solicitudId)
		->get()->first();

		return view('solicitud.programar-actividad', compact('solicitudes', 'solicitudId', 'solicitudEjecucion'));
	}

    public function checkActividad(Request $request)
    {
        $solcitudId = $request->id;
		$solicitudEjecucion = SolicitudEjecucion::where('solicitud_id', $solcitudId)->get()->first();
        $solicitudUnidad = SolicitudUnidad::where('solicitud_id', $solcitudId)->get()->count();
        if ($solicitudEjecucion) {
            $actividadUnidad = ActividadUnidad::where('solicitud_ejecucion_id', $solicitudEjecucion->id)
            ->get();

            if (empty($actividadUnidad)) {
                return response()->json([
                    "estatus" => false
                ]);
            } else {

                $actividadCount = 0;
                foreach ($actividadUnidad as $key => $actividad) {
                    $actividadCount++;
                    if (empty($actividad->idgps)) {
                        return response()->json([
                            "estatus" => false
                        ]);
                    }
                }
                if ($actividadCount !== $solicitudUnidad) {
                    return response()->json([
                        "estatus" => false
                    ]);
                }
                return response()->json([
                    "estatus" => true
                ]);
            }
        }
		return response()->json([
			"estatus" => false
		]);        
    }
    
    public function validacionActividad(Request $request)
    {
        $solicitudId = $request->id;
        $solicitud = Solicitud::where('id', $solicitudId)->get()->first();
        $solicitudEjecucion = SolicitudEjecucion::where('solicitud_id', $solicitudId)
        ->where('activo', 1)->orderBy('id', 'desc')->get()->first();

        return view('solicitud.validacion-actividad', compact('solicitud', 'solicitudEjecucion'));
    }

    public function validacionArchivo(Request $request)
    {
        $actividadUnidadId = $request->actividad_unidad_id;

        if ($request->hasfile('file')) {
            $archivo = $request->file('file');
            $archivoNombre = $archivo->hashName();
            $mimeType = $archivo->getMimeType();
            $nombreReal = $archivo->getClientOriginalName();
            $nombreReal = (new StringUtils())->sanitizeString($nombreReal);
            Storage::putFileAs('solicitud/' . $actividadUnidadId , $archivo, $archivoNombre);
            $solicitudDocumento = new SolicitudDocumento();
            $solicitudDocumento->actividad_unidad_id = $actividadUnidadId;
            $solicitudDocumento->documento = $nombreReal;
            $solicitudDocumento->hash_name = $archivoNombre;
            $solicitudDocumento->mime_type = $mimeType;
            $solicitudDocumento->size = $archivo->getSize();
            $solicitudDocumento->activo = 1;
            $solicitudDocumento->save();
            return response()->json([
                "estatus" => true,
                "solicitud_documento_id" => $solicitudDocumento->id
            ]);
        }
        
        
    }
    
    public function validacionArchivoEliminar(Request $request)
    {
        $solicitudDocumento = SolicitudDocumento::findOrFail($request->id);
        Storage::delete('solicitud/' . $solicitudDocumento->actividad_unidad_id . '/' . $solicitudDocumento->hash_name);
        $solicitudDocumento->delete();

        return response()->json([
            "estatus" => true
        ]);
    }   

    public function validacionArchivoListar(Request $request)
    {
        $actividadUnidadId = $request->id;
        $archivos = SolicitudDocumento::where('actividad_unidad_id', $actividadUnidadId)->get();
        return response()->json($archivos);
    }

    public function validacionArchivoVer(Request $request) {

        $user = auth()->user();
        $id = $request->id;
        $solicitudDocumento = SolicitudDocumento::where('id', $id)->get()->first();
        if ($solicitudDocumento) {
            $existeArchivo = Storage::exists('solicitud/'.$solicitudDocumento->actividad_unidad_id.'/'.$solicitudDocumento->hash_name);
            logger('solicitud/'.$solicitudDocumento->actividad_unidad_id);
            if($user && $solicitudDocumento && $existeArchivo) {
                logger('existeArchivo');
                return Storage::download('solicitud/'.$solicitudDocumento->actividad_unidad_id.'/'.$solicitudDocumento->hash_name, $solicitudDocumento->documento, [
                    'Content-Disposition'=>'inline; filename="'.$solicitudDocumento->documento.'"',
                    'Content-Type' => $solicitudDocumento->mime_type,
                    'Content-Length' => $solicitudDocumento->size
                ]);
            }else{
                logger('no existeArchivo');
                return abort('403');
            }
        }else{
            logger('no existeArchivo');
            return abort('403');
        }
    }

    public function guardarValidacionActividad(Request $request)
	{
		$solicitudId = $request->solicitud_id;
        $solicitudEjecucionId = $request->solicitud_ejecucion_id;
		$opcion = (int) $request->opcion_guardar;
		$solicitudEstatus = match ($opcion) {
			1 => 3, // 3 = Finalizada
			2 => 6  // 6 = Rechazada
		};

		$solicitud = Solicitud::where('id', $solicitudId)
		->get()->first();
		$solicitud->solicitud_estatus_id = $solicitudEstatus;
        if ($solicitudEstatus == 3) {
            $solicitud->comentarios_finalizacion = $request->comentarios;
        }
		$solicitud->save();

        //Rechazar solicitud
        if ($solicitudEstatus == 6) {
            $solicitudValidacion = SolicitudValidacion::where('solicitud_id', $solicitudId)
            ->where('activo', 1)->get()->first();
            if ($solicitudValidacion) {
                $solicitudValidacion->solicitud_estatus_id = $solicitudEstatus;
                $solicitudValidacion->comentarios = $request->comentarios;
                $solicitudValidacion->save();
            }
        }

		$solicitudEstatusMensaje = match ($opcion) {
			1 => 'La Solicitud se ha finalizado correctamente',
			2 => 'Solicitud rechazada, y devuelta al proveedor para su atención.'
		};
		$solicitudBitacora = new SolicitudBitacora();
		$solicitudBitacora->bitacora = !empty($request->comentarios) ? $request->comentarios : $solicitudEstatusMensaje;
		$solicitudBitacora->solicitud_id = $solicitud->id;
        $solicitudBitacora->solicitud_estatus_id = $solicitudEstatus;
		$solicitudBitacora->activo = 1;
		$solicitudBitacora->save();

		session()->flash('success', '#ID ' . $solicitud->id . ', '.$solicitudEstatusMensaje);
		return redirect()->route('solicitud.listadoValidacion');
	}

}
