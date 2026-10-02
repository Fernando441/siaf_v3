<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use App\Models\Proyecto\ProyectoDocumento;
use App\Models\Proyecto\ProyectoTipoDocumento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Models\Cliente\Estado;
use App\Models\Unidad\Unidad;
use App\Models\Unidad\ComplementoUnidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\UnidadMovimientos;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Unidad\InventarioEntrega;
use App\Models\Unidad\InventarioSalida;

use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\Emisor;
use App\Models\Proyecto\FuenteProyecto;
use App\Models\Proyecto\TipoContrato;
use App\Models\Licitacion\TipoContratacion;
use App\Models\Proyecto\PagoProyecto;
use App\Models\Proyecto\DeductivaPago;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Cliente\Cliente;
use App\Models\Licitacion\Licitacion;
use App\Models\Proyecto\PenalizacionesDeducciones;
use App\Models\Proyecto\ProyectoModificacionConvenio;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Services\Folio;
use App\Services\Money;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UnidadesContratoExport;

class ProyectoController extends Controller
{
    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->money_format = $money_format;
        $this->folio = $folio;
    }

    public function listadoproyectos()
    {


    	$emisores = Emisor::where('id_status_delete', 1)->get();
    	$cliente = Cliente::where('id_status_delete', 1)->get();
    	$tipocontrato = TipoContratacion::where('id_status_delete', 1)->get();
    	$fuente = FuenteProyecto::where('id_status_delete', 1)->get();
    	$user = User::orderby('id', 'asc')->get();

        return view('proyectos.listado-proyectos', compact('emisores', 'cliente', 'tipocontrato', 'fuente', 'user'));
    }

    public function proyectodatatable(Request $request)
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
        $totalRecords = Proyecto::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Proyecto::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();

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

        $records = Proyecto::select(
            'proyectos.id as idpro',
            'proyectos.id_emisor',
            'proyectos.id_cliente',
            'proyectos.no_folio',
            'proyectos.id_contrato',
            'proyectos.no_contrato',
            'proyectos.titulo_servicio',
            'proyectos.tipo_contrato',
            'proyectos.nombre_administrativo',
            'proyectos.correo_administrativo',
            'proyectos.telefono_administrativo',
            'proyectos.id_responsable',
            'proyectos.fuente_proyecto',
            'proyectos.firma_contrato',
            'proyectos.firma_inicio_vigencia',
            'proyectos.firma_final_vigencia',
            'proyectos.presupuesto_minimo',
            'proyectos.presupuesto_maximo',
            'proyectos.id_status',
            'proyectos.id_status_delete',
            'emi.razon_social as rsocial',
            'cli.razon_social as rzcliente',
            'tp.tipo_contratacion as namecontrato',
            'proyectos.licitacion_id'
        )
            ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
            ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
            ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
            ->where("proyectos.id_status_delete", 1)
            ->where("proyectos.contrato_complemento", 1)
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

                    $records = Proyecto::select(
                        'proyectos.id as idpro',
                        'proyectos.id_emisor',
                        'proyectos.id_cliente',
                        'proyectos.no_folio',
                        'proyectos.id_contrato',
                        'proyectos.no_contrato',
                        'proyectos.titulo_servicio',
                        'proyectos.tipo_contrato',
                        'proyectos.nombre_administrativo',
                        'proyectos.correo_administrativo',
                        'proyectos.telefono_administrativo',
                        'proyectos.id_responsable',
                        'proyectos.fuente_proyecto',
                        'proyectos.firma_contrato',
                        'proyectos.firma_inicio_vigencia',
                        'proyectos.firma_final_vigencia',
                        'proyectos.presupuesto_minimo',
                        'proyectos.presupuesto_maximo',
                        'proyectos.id_status',
                        'proyectos.id_status_delete',
                        'emi.razon_social as rsocial',
                        'cli.razon_social as rzcliente',
                        'tp.tipo_contratacion as namecontrato',
                        'proyectos.licitacion_id'
                    )
                        ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                        ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                        ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                        ->where("proyectos.id_status_delete", 1)
                        ->where("proyectos.contrato_complemento", 1)
                        ->where("proyectos.no_folio", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'emisor') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Proyecto::select(
                        'proyectos.id as idpro',
                        'proyectos.id_emisor',
                        'proyectos.id_cliente',
                        'proyectos.no_folio',
                        'proyectos.id_contrato',
                        'proyectos.no_contrato',
                        'proyectos.titulo_servicio',
                        'proyectos.tipo_contrato',
                        'proyectos.nombre_administrativo',
                        'proyectos.correo_administrativo',
                        'proyectos.telefono_administrativo',
                        'proyectos.id_responsable',
                        'proyectos.fuente_proyecto',
                        'proyectos.firma_contrato',
                        'proyectos.firma_inicio_vigencia',
                        'proyectos.firma_final_vigencia',
                        'proyectos.presupuesto_minimo',
                        'proyectos.presupuesto_maximo',
                        'proyectos.id_status',
                        'proyectos.id_status_delete',
                        'emi.razon_social as rsocial',
                        'cli.razon_social as rzcliente',
                        'tp.tipo_contratacion as namecontrato',
                        'proyectos.licitacion_id'
                    )
                        ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                        ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                        ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                        ->where("proyectos.id_status_delete", 1)
                        ->where("proyectos.contrato_complemento", 1)
                        ->where("proyectos.id_emisor", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'cliente') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Proyecto::select(
                        'proyectos.id as idpro',
                        'proyectos.id_emisor',
                        'proyectos.id_cliente',
                        'proyectos.no_folio',
                        'proyectos.id_contrato',
                        'proyectos.no_contrato',
                        'proyectos.titulo_servicio',
                        'proyectos.tipo_contrato',
                        'proyectos.nombre_administrativo',
                        'proyectos.correo_administrativo',
                        'proyectos.telefono_administrativo',
                        'proyectos.id_responsable',
                        'proyectos.fuente_proyecto',
                        'proyectos.firma_contrato',
                        'proyectos.firma_inicio_vigencia',
                        'proyectos.firma_final_vigencia',
                        'proyectos.presupuesto_minimo',
                        'proyectos.presupuesto_maximo',
                        'proyectos.id_status',
                        'proyectos.id_status_delete',
                        'emi.razon_social as rsocial',
                        'cli.razon_social as rzcliente',
                        'tp.tipo_contratacion as namecontrato',
                        'proyectos.licitacion_id'
                    )
                        ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                        ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                        ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                        ->where("proyectos.id_status_delete", 1)
                        ->where("proyectos.contrato_complemento", 1)
                        ->where("proyectos.id_cliente", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                    
                }
            }

            if ($columna['data'] == 'titulo_servicio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Proyecto::select(
                        'proyectos.id as idpro',
                        'proyectos.id_emisor',
                        'proyectos.id_cliente',
                        'proyectos.no_folio',
                        'proyectos.id_contrato',
                        'proyectos.no_contrato',
                        'proyectos.titulo_servicio',
                        'proyectos.tipo_contrato',
                        'proyectos.nombre_administrativo',
                        'proyectos.correo_administrativo',
                        'proyectos.telefono_administrativo',
                        'proyectos.id_responsable',
                        'proyectos.fuente_proyecto',
                        'proyectos.firma_contrato',
                        'proyectos.firma_inicio_vigencia',
                        'proyectos.firma_final_vigencia',
                        'proyectos.presupuesto_minimo',
                        'proyectos.presupuesto_maximo',
                        'proyectos.id_status',
                        'proyectos.id_status_delete',
                        'emi.razon_social as rsocial',
                        'cli.razon_social as rzcliente',
                        'tp.tipo_contratacion as namecontrato',
                        'proyectos.licitacion_id'
                    )
                        ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                        ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                        ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                        ->where("proyectos.id_status_delete", 1)
                        ->where("proyectos.contrato_complemento", 1)
                        ->where("proyectos.titulo_servicio", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'tipo_contrato') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Proyecto::select(
                        'proyectos.id as idpro',
                        'proyectos.id_emisor',
                        'proyectos.id_cliente',
                        'proyectos.no_folio',
                        'proyectos.id_contrato',
                        'proyectos.no_contrato',
                        'proyectos.titulo_servicio',
                        'proyectos.tipo_contrato',
                        'proyectos.nombre_administrativo',
                        'proyectos.correo_administrativo',
                        'proyectos.telefono_administrativo',
                        'proyectos.id_responsable',
                        'proyectos.fuente_proyecto',
                        'proyectos.firma_contrato',
                        'proyectos.firma_inicio_vigencia',
                        'proyectos.firma_final_vigencia',
                        'proyectos.presupuesto_minimo',
                        'proyectos.presupuesto_maximo',
                        'proyectos.id_status',
                        'proyectos.id_status_delete',
                        'emi.razon_social as rsocial',
                        'cli.razon_social as rzcliente',
                        'tp.tipo_contratacion as namecontrato',
                        'proyectos.licitacion_id'
                    )
                        ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                        ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                        ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                        ->where("proyectos.id_status_delete", 1)
                        ->where("proyectos.contrato_complemento", 1)
                        ->where("proyectos.tipo_contrato", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
        }

        if ($valor == "No") {
            $records = Proyecto::select(
                'proyectos.id as idpro',
                'proyectos.id_emisor',
                'proyectos.id_cliente',
                'proyectos.no_folio',
                'proyectos.id_contrato',
                'proyectos.no_contrato',
                'proyectos.titulo_servicio',
                'proyectos.tipo_contrato',
                'proyectos.nombre_administrativo',
                'proyectos.correo_administrativo',
                'proyectos.telefono_administrativo',
                'proyectos.id_responsable',
                'proyectos.fuente_proyecto',
                'proyectos.firma_contrato',
                'proyectos.firma_inicio_vigencia',
                'proyectos.firma_final_vigencia',
                'proyectos.presupuesto_minimo',
                'proyectos.presupuesto_maximo',
                'proyectos.id_status',
                'proyectos.id_status_delete',
                'emi.razon_social as rsocial',
                'cli.razon_social as rzcliente',
                'tp.tipo_contratacion as namecontrato',
                'proyectos.licitacion_id'
            )
                ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
                ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
                ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
                ->where("proyectos.id_status_delete", 1)
                ->where("proyectos.contrato_complemento", 1)
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->idpro,
                "no_folio" => $record->no_folio,
                "id_contrato" => $record->id_contrato,
                "no_contrato" => $record->no_contrato,
                "id_emisor" => $record->rsocial,
                "id_cliente" => $record->rzcliente,
                "titulo_servicio" => $record->titulo_servicio,
                "tipo_contrato" => $record->namecontrato,
                "licitacion" => $record->licitacion_id,
                "permisos" => $permiso_array,
                'acciones' => null,
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


    public function agregarproyecto($licitacion_id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $op = 0;
    	$emisores = Emisor::where('id_status_delete', 1)->get();
    	$cliente = Cliente::where('id_status_delete', 1)->get();
    	$tipocontrato = TipoContratacion::where('id_status_delete', 1)->get();
    	$fuente = FuenteProyecto::where('id_status_delete', 1)->get();
    	$user = User::orderby('id', 'asc')->get();
        $licitaciones = Licitacion::where('id_status_delete', 1)->where('id_licitacion_estatus', 1)->get();

        $supervisores = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->where("users.id_status_delete", 1)
            ->get();
        $documentos = ProyectoTipoDocumento::all();
        // dd($documentos);
        $avance_financiero = PagoProyecto::where('id_proyecto', 0)->get();

        $info_licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.junta_aclaraciones',
            'licitaciones.apertura_proposiciones',
            'licitaciones.acto_fallo',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'pl.publicacion_licitacion as publ',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'tc.tipo_contratacion',
            'licitaciones.contratacion',
            'licitaciones.firma_entrega',
            'licitaciones.id_licitacion_estatus',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")->where('licitaciones.id', $licitacion_id)
            ->first();

        if (Proyecto::where('licitacion_id', $info_licitacion->id)->first() == null) {
            return redirect()->route('licitacion.agregarnuevo', [$info_licitacion->id, 1]);
        }


        if ($info_licitacion->id_licitacion_estatus) {
            $inf_pro = Proyecto::where('licitacion_id', $info_licitacion->id)->get();
            $documentos = ProyectoDocumento::where('iduserCreated', 1)->get();
        } else {
            $inf_pro = Proyecto::where('licitacion_id', $info_licitacion->id)->get();
            $documentos = ProyectoDocumento::where('id_proyecto', $inf_pro[0]->id)->get();
        }

        $doc = ProyectoTipoDocumento::where('iduserCreated', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($doc as $documento) {
            $cadenaTipoDocumento .= '"' . $documento->id . '":"' . $documento->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';

        //Avance financiero en formato json
        $cadenaavance = "";
        foreach ($avance_financiero as $av) {
            $cadenaavance .= '"' . $av->id . '":"' . $av->factura . '",';
        }

        $cadenaavance = '{' . rtrim($cadenaavance, ',') . '}';

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
            'uu.ubicacion'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->where('unidad.id_status_delete', 1)
            ->get();

        $penalizacion = PenalizacionesDeducciones::where('id_status_delete', 1)->get();
        $cadenaPenalizacion = "";
        foreach ($penalizacion as $tipo) {
            $cadenaPenalizacion .= '"' . $tipo->id . '":"' . $tipo->penalizacion_deduccion . '",';
        }
        $cadenaPenalizacion = '{' . rtrim($cadenaPenalizacion, ',') . '}';

        $convenio = ProyectoModificacionConvenio::where('id_status_delete', 1)->get();
        // dd($info_licitacion);
        return view('proyectos.agregar-proyecto', compact('cadenaTipoDocumento', 'emisores', 'cliente', 'tipocontrato', 'fuente', 'user', 'licitaciones', 'op', 'supervisores', 'cadenaavance', 'unidades', 'info_licitacion', 'inf_pro', 'documentos', 'cadenaPenalizacion', 'convenio', 'permiso_array'));
    }

    public function agregarproyectonuevo($licitacion_id, $op_new)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $op = 0;
        $emisores = Emisor::where('id_status_delete', 1)->get();
        $cliente = Cliente::where('id_status_delete', 1)->get();
        $tipocontrato = TipoContratacion::where('id_status_delete', 1)->get();
        $fuente = FuenteProyecto::where('id_status_delete', 1)->get();

        $user = User::orderby('id', 'asc')->get();
        $licitaciones = Licitacion::where('id_status_delete', 1)->where('id_licitacion_estatus', 1)->get();
        $supervisores = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->where("users.id_status_delete", 1)
            ->get();
        $documentos = ProyectoTipoDocumento::all();
        $avance_financiero = PagoProyecto::where('id_proyecto', 0)->get();

        $info_licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.junta_aclaraciones',
            'licitaciones.apertura_proposiciones',
            'licitaciones.acto_fallo',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'pl.publicacion_licitacion as publ',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'tc.tipo_contratacion',
            'licitaciones.contratacion',
            'licitaciones.firma_entrega',
            'licitaciones.id_licitacion_estatus',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")->where('licitaciones.id', $licitacion_id)
            ->first();

        if ($info_licitacion->id_licitacion_estatus) {
            $inf_pro = Proyecto::where('licitacion_id', $info_licitacion->id)->get();
        } else {
            $inf_pro = Proyecto::where('licitacion_id', $info_licitacion->id)->get();
        }

        $documentos = ProyectoTipoDocumento::where('iduserCreated', 1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($documentos as $documento) {
            $cadenaTipoDocumento .= '"' . $documento->id . '":"' . $documento->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';

        //Avance financiero en formato json
        $cadenaavance = "";
        foreach ($avance_financiero as $av) {
            $cadenaavance .= '"' . $av->id . '":"' . $av->factura . '",';
        }
        $cadenaavance = '{' . rtrim($cadenaavance, ',') . '}';

        $cont_pro = Proyecto::where('licitacion_id', $info_licitacion->id)->get();
        $count_inf_contrato = count($cont_pro);

        if($count_inf_contrato == 0){
            $id_li_no = 0;
        }else{
            $id_li_no = Proyecto::where('licitacion_id', $info_licitacion->id)->first();
        }

        $convenio = ProyectoModificacionConvenio::where('id_status_delete', 1)->get();
        // dd($id_li_no);
        return view('proyectos.agregar-proyecto-nuevo', compact('cadenaTipoDocumento', 'emisores', 'cliente', 'tipocontrato', 'fuente', 'user', 'licitaciones', 'op', 'supervisores', 'cadenaavance', 'info_licitacion', 'inf_pro', 'documentos', 'op_new', 'count_inf_contrato', 'id_li_no', 'convenio', 'permiso_array'));
    }



    public function guardarproyecto(Request $request)
    {
        // dd($request);
        $lic = Licitacion::where('id', $request->licitacion)->first();
        $data = [
            'id_emisor' => $request->id_emisor,
            'id_cliente' => $request->id_cliente,
            'no_folio' => $this->folio->getFolioProyecto(),
            'id_contrato' => $request->id_contrato,
            'no_contrato' => $request->no_contrato,
            'titulo_servicio' => $request->titulo_servicio,
            'tipo_contrato' => $request->id_contratacion,
            'nombre_administrativo' => $request->contacto_administrativo,
            'correo_administrativo' => $request->corre_administrativo,
            'telefono_administrativo' => $request->telefono_administrativo,
            'id_responsable' => $request->id_responsable,
            'supervisor_proyecto' => 0,
            'fuente_proyecto' => 1,
            'firma_contrato' => $request->firma_contrato ? Carbon::createFromFormat('d/m/Y', $request->firma_contrato)->format('Y-m-d') : null,
            'firma_inicio_vigencia' => $request->fecha_inicio_vigencia ? Carbon::createFromFormat('d/m/Y', $request->fecha_inicio_vigencia)->format('Y-m-d') : null,
            'firma_final_vigencia' => $request->fecha_final_vigencia ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_vigencia)->format('Y-m-d') : null,
            'contrato_op' => $request->contrato_op,
            'presupuesto_minimo' => $request->presuuesto_minimo ? $this->money_format->clearFormat($request->presuuesto_minimo) : null,
            'presupuesto_maximo' => $request->presuuesto_maximo ? $this->money_format->clearFormat($request->presuuesto_maximo) : null,
            'importe_general' => $request->importe_general ? $this->money_format->clearFormat($request->importe_general) : null,
            'iva' => $request->iva ? $this->money_format->clearFormat($request->iva) : null,
            'nombre_administrativo' => $request->contacto_administrativo,
            'correo_administrativo' => $request->correo_administrativo,
            'telefono_administrativo' => $request->telefono_administrativo,
            'licitacion_id' => $request->licitacion,
            'convenio_op' => $request->convenio_op,
            'no_convenio' => $request->no_convenio,
            'modificacion_id' => $request->modificacion_id,
            'id_status_delete' => 1,
            'op_sustituto' => 0,
            'observaciones' => $request->observaciones,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $proyecto_existe = Proyecto::where('licitacion_id', $request->licitacion)->first();
        if ($proyecto_existe == null) {
            $data['contrato_complemento'] = 1;
        } else {
            $data['contrato_complemento'] = 2;
        }

        $id_pro = Proyecto::insertGetId($data);

        $licitacion = [
            'id_licitacion_estatus' => 2,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Licitacion::where('id', $request->licitacion)->update($licitacion);


        //inicio recepción de archivos
        $colIdDocumento = $request->id_documento;
        if ($request->hasfile('archivo')) {
            $archivos = $request->file('archivo');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('proyecto/' . $id_pro, $archivo, $archivoNombre);
                $data = [
                    'id_proyecto' => $id_pro,
                    'id_proyecto_tipo_documento' => $colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'licitacion_id' => $request->licitacion,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];
                ProyectoDocumento::insert($data);
            }
        }


        session()->flash('success', 'El contrato se creo correctamente');
        return redirect()->route('licitacion.agregar',$request->licitacion);
    }


    public function guardarproyectocomplemento(Request $request)
    {
        
        $proyecto_existe = Proyecto::where('licitacion_id', $request->licitacion)->get();
        foreach ($proyecto_existe as $pro) {
            $file = "id_documento_" . $pro->id;

            for ($i = 0; $i < count($request->id_contrato); $i++) {
                $opcion = "contrato_op" . $request->id_proyecto[$i];
                // dd($request->observaciones[$i]);
                $data = [
                    // 'id_emisor' => $request->id_emisor[$i],
                    'id_contrato' => $request->id_contrato[$i],
                    'no_contrato' => $request->no_contrato[$i],
                    'fuente_proyecto' => 1,
                    'firma_inicio_vigencia' => $request->fecha_inicio_vigencia[$i] ? Carbon::createFromFormat('d/m/Y', $request->fecha_inicio_vigencia[$i])->format('Y-m-d') : null,
                    'firma_final_vigencia' => $request->fecha_final_vigencia[$i] ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_vigencia[$i])->format('Y-m-d') : null,
                    'firma_contrato' => $request->firma_contrato ? Carbon::createFromFormat('d/m/Y', $request->firma_contrato)->format('Y-m-d') : null,
                    'contrato_op' => $request[$opcion],
                    'presupuesto_minimo' => $request->presuuesto_minimo[$i] ? $this->money_format->clearFormat($request->presuuesto_minimo[$i]) : null,
                    'presupuesto_maximo' => $request->presuuesto_maximo[$i] ? $this->money_format->clearFormat($request->presuuesto_maximo[$i]) : null,
                    'importe_general' => $request->importe_general[$i] ? $this->money_format->clearFormat($request->importe_general[$i]) : null,
                    'iva' => $request->iva[$i] ? $this->money_format->clearFormat($request->iva[$i]) : null,
                    'nombre_administrativo' => $request->contacto_administrativo[$i],
                    'correo_administrativo' => $request->correo_administrativo[$i],
                    'telefono_administrativo' => $request->telefono_administrativo[$i],
                    'modificacion_id' => $request->modificacion_id[$i],
                    'observaciones' => $request->observaciones[$i],
                    'op_sustituto' => 0,
                    // 'supervisor_proyecto' => $request->supervisor_proyecto[$i],
                    // 'id_responsable'=> $request->id_responsable[$i],                    
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                Proyecto::where('id', $request->id_proyecto[$i])->update($data);
            }
            //inicio recepción de archivos
            if ($request[$file] != null) {
                $colIdDocumento = $request[$file];
                if ($request->hasfile('archivo')) {
                    $archivos = $request->file('archivo');
                    foreach ($archivos as $indice => $archivo) {
                        $archivoNombre = $archivo->hashName();
                        $mimeType = $archivo->getMimeType();
                        Storage::putFileAs('proyecto/' . $pro->id, $archivo, $archivoNombre);
                        $data = [
                            'id_proyecto' => $pro->id,
                            'id_proyecto_tipo_documento' => $colIdDocumento[$indice],
                            'documento' => $archivoNombre,
                            'mime_type' => $mimeType,
                            'licitacion_id' => $request->licitacion,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'iduserCreated' => auth()->user()->id,
                            'iduserUpdated' => auth()->user()->id
                        ];
                        ProyectoDocumento::insert($data);
                    }
                }
            }
        }

        session()->flash('success', 'El contrato se creo correctamente');
        return redirect()->route('licitacion.agregar',$request->licitacion);
    }


    public function editarproyecto($licitacion)
    {

        // $data = [
        //     'unidad_asignacion_id' => 2,
        //     'id_ubicacion' => 1,
        //     'licitaciones_id' => null,
        //     'proyectos_id' => null,
        //     'licitacion_propuesta_economica_id' => null,
        //     'cliente_id' => null,
        //     'inv_entrega' => 0,
        //     'fecha_asignacion'=> null,
        //     'unidad_requisicion_estatus_id' => 1,
            
        //     'updated_at' => date('Y-m-d H:i:s'),
        //     'iduserUpdated' => auth()->user()->id
        // ];
        // Unidad::where('id',87)->update($data);

        // dd($licitacion);
    	$info_proyecto = Proyecto::where('id', $licitacion)->get();
    	$emisores = Emisor::where('id_status_delete', 1)->get();
    	$cliente = Cliente::where('id_status_delete', 1)->get();
    	$tipocontrato = TipoContratacion::where('id_status_delete', 1)->get();
    	$fuente = FuenteProyecto::where('id_status_delete', 1)->get();
    	$user = User::orderby('id', 'asc')->get();
        $unidad = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status','unidad.proyectos_id')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.licitaciones_id', $licitacion)->get();

        $unidad_movimiento = AsignacionRegistroUnidad::select('unidad_registro_asignacion.id', 'unidad_registro_asignacion.unidad_id', 'mu.nombre_marca', 'un.folio', 'mou.nombre_modelo','un.unidad_year','un.no_serie','un.placa', 'unidad_registro_asignacion.proyectos_id', 'unidad_registro_asignacion.op_asignacion', 'unidad_registro_asignacion.fecha_asignacion', 'uta.tipo_asignacion', 'use.name', "unidad_registro_asignacion.licitaciones_id")
            ->leftjoin("unidad as un", "un.id", "unidad_registro_asignacion.unidad_id")
            ->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad_registro_asignacion.id_tipo_asignacion")
            ->leftjoin("users as use", "use.id", "unidad_registro_asignacion.cliente_id")
            ->where('unidad_registro_asignacion.licitaciones_id', $licitacion)->get();
       

        $pagos = PagoProyecto::where('licitacion_id', $licitacion)->get(); // fer

        $licitaciones = Licitacion::where('id_status_delete', 1)->get();

        $info_licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.junta_aclaraciones',
            'licitaciones.apertura_proposiciones',
            'licitaciones.acto_fallo',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'pl.publicacion_licitacion as publ',
            'licitaciones.cliente',
            'cli.razon_social',
            'tc.tipo_contratacion',
            'licitaciones.contratacion',
            'licitaciones.id_licitacion_prioridad'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
            ->where('licitaciones.id', $licitacion)
            ->get();

        // $op = $info_proyecto[0]->licitacion_id;
        $supervisores = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->where("users.id_status_delete", 1)
            ->get();
        $documentos = ProyectoDocumento::where('licitacion_id', $licitacion)->get();

        $tipoDocumento = ProyectoTipoDocumento::all();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($tipoDocumento as $tipo) {
            $cadenaTipoDocumento .= '"' . $tipo->id . '":"' . $tipo->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';

        //Avance financiero en formato json
        $avance_financiero = PagoProyecto::where('licitacion_id', $licitacion)->get();


        $cadenaavance = "";
        foreach ($avance_financiero as $av) {
            $cadenaavance .= '"' . $av->id . '":"' . "Fecha de pago: " . $av->fecha_pago . "- Monto:$" . $av->monto . '",';
        }
        $cadenaavance = '{' . rtrim($cadenaavance, ',') . '}';

        $deductivapago = DeductivaPago::select(
            'proyecto_deductiva_pago.id',
            'proyecto_deductiva_pago.fecha_deductiva',
            'proyecto_deductiva_pago.proyecto_id',
            'proyecto_deductiva_pago.monto_deductiva',
            'pp.id as pagoid',
            'pp.fecha_pago',
            'pp.monto',
            'proyecto_deductiva_pago.deductiva_pago',
            'pen.penalizacion_deduccion'
        )
            ->leftjoin("pago_proyecto as pp", "pp.id", "proyecto_deductiva_pago.pago_proyecto_id")
            ->leftjoin("proyecto_penalizaciones as pen", "pen.id", "proyecto_deductiva_pago.proyecto_penalizaciones_id")
            ->where('proyecto_deductiva_pago.licitacion_id', $licitacion)
            ->get();

        $penalizacion = PenalizacionesDeducciones::where('id_status_delete', 1)->get();
        $cadenaPenalizacion = "";
        foreach ($penalizacion as $tipo) {
            $cadenaPenalizacion .= '"' . $tipo->id . '":"' . $tipo->penalizacion_deduccion . '",';
        }
        $cadenaPenalizacion = '{' . rtrim($cadenaPenalizacion, ',') . '}';


        $inf_pro = Proyecto::where('licitacion_id', $licitacion)->get();
        // dd($inf_pro);

        $usuarios_clientes = User::where('tipo_usuario_id', 1)->where('id_status_delete', 1)->get();
        $clientes_contrato = ProyectoClientes::where('licitacion_id', $licitacion)->get();
        $data = array();
        foreach ($clientes_contrato as $key => $value) {
            $data[] = $value->cliente_id;
        }
        // $unidad_contrato = Unidad::where('proyectos_id')

        return view('proyectos.editar-proyecto', compact('cadenaTipoDocumento', 'documentos', 'info_proyecto', 'emisores', 'cliente', 'tipocontrato', 'fuente', 'user', 'pagos',  'licitaciones', 'info_licitacion', 'supervisores', 'cadenaavance', 'deductivapago', 'inf_pro', 'cadenaPenalizacion', 'unidad', 'usuarios_clientes', 'clientes_contrato', 'data', 'unidad_movimiento'));
    }

    public function editarproyectouno(Request $request)
    {
        dd($request);
        // dd($request);
        // for ($i = 0; $i < count($request->id_proyecto); $i++) {
        //     $cliente_id = "cliente_" . $request->id_proyecto[$i];     
        //     if($request[$cliente_id] != null){
        //         ProyectoClientes::where('proyecto_id', $request->id_proyecto[$i])->delete();
        //         $var = "Existe";
        //         for ($f = 0; $f < count($request[$cliente_id]); $f++) {
        //             $data = [
        //                 'proyecto_id' => $request->id_proyecto[$i],
        //                 'licitacion_id' => $request->licitacion,
        //                 'cliente_id' => $request[$cliente_id][$f],
        //                 'iduserCreated' => auth()->user()->id,
        //                 'iduserUpdated' => auth()->user()->id,
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'created_at' => date('Y-m-d H:i:s')
        //             ];
        //             ProyectoClientes::insert($data);
        //         }

        //     }else{
        //         $var = "No Existe";
        //     }
        // }
        // C L I E N T E S   C O N T R A T O


        $proyecto_existe = Proyecto::where('licitacion_id', $request->licitacion)->get();
        // $licitacion = [
        //     'id_licitacion_estatus' => 2,
        //     'iduserUpdated' =>auth()->user()->id,
        //     'updated_at' =>date('Y-m-d H:i:s')
        // ];
        // Licitacion::where('id', $request->licitacion)->update($licitacion);
        foreach ($proyecto_existe as $pro) {
            $file = "id_documento_" . $pro->id;  //documento
            $fecha = "fecha_" . $pro->id;        //Avance Financiero
            $monto = "monto_" . $pro->id;        //Avance Financiero
            $fechadp = "fechadp_" . $pro->id;   //Deductiva Pago
            $montodp = "montodp_" . $pro->id;   //Deductiva Pago
            $id_avance = "id_avance_" . $pro->id; //Deductiva Pago
            $id_penalizacion = "id_penalizacion_" . $pro->id; //Deductiva Pago

            for ($i = 0; $i < count($request->id_responsable); $i++) {
                $data = [
                    'id_responsable' => $request->id_responsable[$i],
                    'supervisor_proyecto' => $request->supervisor_proyecto[$i],
                    'op_sustituto' => $request->op_sustituto[$i],
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];+
                Proyecto::where('id', $request->id_proyecto[$i])->update($data);
            }

            if ($request[$file] != null) {
                $colIdDocumento = $request[$file];
                if ($request->hasfile('archivo')) {
                    $archivos = $request->file('archivo');
                    foreach ($archivos as $indice => $archivo) {
                        $archivoNombre = $archivo->hashName();
                        $mimeType = $archivo->getMimeType();
                        Storage::putFileAs('proyecto/' . $pro->id, $archivo, $archivoNombre);
                        $data = [
                            'id_proyecto' => $pro->id,
                            'id_proyecto_tipo_documento' => $colIdDocumento[$indice],
                            'documento' => $archivoNombre,
                            'mime_type' => $mimeType,
                            'licitacion_id' => $request->licitacion,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'iduserCreated' => auth()->user()->id,
                            'iduserUpdated' => auth()->user()->id
                        ];
                        ProyectoDocumento::insert($data);
                    }
                }
            }
            // END file Documentos

            if ($request[$fecha] != null) {
                $colIdFecha = $request[$fecha];
                $colIdMonto = $request[$monto];
                if ($request->hasfile('pago')) {
                    $archivos = $request->file('pago');
                    foreach ($archivos as $indice => $archivo) {
                        $archivoNombre = $archivo->hashName();
                        $mimeType = $archivo->getMimeType();
                        Storage::putFileAs('proyecto/' . $pro->id . '/AvanceFinanciero/', $archivo, $archivoNombre);

                        $data = [
                            'id_proyecto' => $pro->id,
                            'fecha_pago' => $colIdFecha[$indice] ? Carbon::createFromFormat('d/m/Y', $colIdFecha[$indice])->format('Y-m-d') : null,
                            'monto' => $this->money_format->clearFormat($colIdMonto[$indice]),
                            'factura' => $archivoNombre,
                            'licitacion_id' => $request->licitacion,
                            'iduserCreated' => auth()->user()->id,
                            'iduserUpdated' => auth()->user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];

                        PagoProyecto::insert($data);
                    }
                }
            }
            // END file Avance
            if ($request[$fechadp] != null) {
                $colIdFechaDp = $request[$fechadp];
                $colIdMontoDp = $request[$montodp];
                $colIdAvenceF = $request[$id_avance];
                $colIdPenalizacionF = $request[$id_penalizacion];
                if ($request->hasfile('deductiva')) {
                    $archivos = $request->file('deductiva');
                    foreach ($archivos as $indice => $archivo) {

                        $archivoNombre = $archivo->hashName();
                        $mimeType = $archivo->getMimeType();
                        Storage::putFileAs('proyecto/' . $pro->id . '/DeductivaPago/', $archivo, $archivoNombre);

                        $data = [
                            'pago_proyecto_id' => $colIdAvenceF[$indice],
                            'proyecto_id' => $pro->id,
                            'fecha_deductiva' => $colIdFechaDp[$indice] ? Carbon::createFromFormat('d/m/Y', $colIdFechaDp[$indice])->format('Y-m-d') : null,
                            'monto_deductiva' => $this->money_format->clearFormat($colIdMontoDp[$indice]),
                            'deductiva_pago' => $archivoNombre,
                            'licitacion_id' => $request->licitacion,
                            'status_delete' => 0,
                            'proyecto_penalizaciones_id' => $colIdPenalizacionF[$indice],
                            'iduserCreated' => auth()->user()->id,
                            'iduserUpdated' => auth()->user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        DeductivaPago::insert($data);
                    }
                }
            }
            //END file Deductiva

        }
        // END Foreach proyectos


        session()->flash('success', 'El contrato se modifico correctamente');
        return redirect()->route('proyecto.listadoproyectos');
    }

    public function desactivarproyecto(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo_desactivar' => $request->motivo,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Proyecto::where('id', $request->id)->update($data);

        session()->flash('success', 'El contrato se desactivo correctamente');
        return redirect()->route('proyecto.listadoproyectos');
    }

    public function listadoproyectosinactivos()
    {
        $info_proyecto = Proyecto::select(
            'proyectos.id as idpro',
            'proyectos.id_emisor',
            'proyectos.id_cliente',
            'proyectos.no_folio',
            'proyectos.titulo_servicio',
            'proyectos.tipo_contrato',
            'proyectos.nombre_administrativo',
            'proyectos.correo_administrativo',
            'proyectos.telefono_administrativo',
            'proyectos.id_responsable',
            'proyectos.fuente_proyecto',
            'proyectos.firma_contrato',
            'proyectos.firma_inicio_vigencia',
            'proyectos.firma_final_vigencia',
            'proyectos.presupuesto_minimo',
            'proyectos.presupuesto_maximo',
            'proyectos.id_status',
            'proyectos.id_status_delete',
            'emi.razon_social as rsocial',
            'cli.razon_social as rzcliente',
            'tp.tipo_contratacion as namecontrato',
            'proyectos.licitacion_id',
            'proyectos.motivo_desactivar'
        )
            ->leftjoin("emisores as emi", "emi.id", "proyectos.id_emisor")
            ->leftjoin("client as cli", "cli.id_cliente", "proyectos.id_cliente")
            ->leftjoin("tipo_contratacion as tp", "tp.id", "proyectos.tipo_contrato")
            ->where("proyectos.id_status_delete", 2)
            ->get();

        return view('proyectos.listado-proyectos-inactivos', compact('info_proyecto'));
    }

    public function activarproyecto(Request $request)
    {
        $data = [

            'id_status_delete' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')

        ];
        Proyecto::where('id', $request->id)->update($data);

        session()->flash('success', 'El contrato se activo correctamente');
        return redirect()->route('proyecto.listadoproyectosinactivos');
    }


    public function verProyecto($licitacion)
    {
        $info_proyecto = Proyecto::where('id', $licitacion)->get();

        $emisores = Emisor::where('id_status_delete', 1)->get();
        $cliente = Cliente::where('id_status_delete', 1)->get();
        $tipocontrato = TipoContratacion::where('id_status_delete', 1)->get();
        $fuente = FuenteProyecto::where('id_status_delete', 1)->get();

        $user = User::orderby('id', 'asc')->get();
        $unidad = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.proyectos_id')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.licitaciones_id', $licitacion)->get();

        $unidad_movimiento = AsignacionRegistroUnidad::select('unidad_registro_asignacion.id', 'unidad_registro_asignacion.unidad_id', 'mu.nombre_marca', 'un.folio', 'mou.nombre_modelo','un.unidad_year','un.no_serie','un.placa', 'unidad_registro_asignacion.proyectos_id', 'unidad_registro_asignacion.op_asignacion', 'unidad_registro_asignacion.fecha_asignacion', 'uta.tipo_asignacion', 'use.name', "unidad_registro_asignacion.licitaciones_id")
            ->leftjoin("unidad as un", "un.id", "unidad_registro_asignacion.unidad_id", "unidad_registro_asignacion.licitaciones_id")
            ->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad_registro_asignacion.id_tipo_asignacion")
            ->leftjoin("users as use", "use.id", "unidad_registro_asignacion.cliente_id")
            ->where('unidad_registro_asignacion.licitaciones_id', $licitacion)->get();


        $pagos = PagoProyecto::where('licitacion_id', $licitacion)->get();

        $licitaciones = Licitacion::where('id_status_delete', 1)->get();

        $info_licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.junta_aclaraciones',
            'licitaciones.apertura_proposiciones',
            'licitaciones.acto_fallo',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'pl.publicacion_licitacion as publ',
            'licitaciones.cliente',
            'cli.razon_social',
            'tc.tipo_contratacion',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
            ->where('licitaciones.id', $licitacion)
            ->get();

        // $op = $info_proyecto[0]->licitacion_id;
        $supervisores = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->where("users.id_status_delete", 1)
            ->get();
        $documentos = ProyectoDocumento::where('licitacion_id', $licitacion)->get();

        $tipoDocumento = ProyectoTipoDocumento::all();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($tipoDocumento as $tipo) {
            $cadenaTipoDocumento .= '"' . $tipo->id . '":"' . $tipo->tipo . '",';
        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';

        //Avance financiero en formato json
        $avance_financiero = PagoProyecto::where('licitacion_id', $licitacion)->get();


        $cadenaavance = "";
        foreach ($avance_financiero as $av) {
            $cadenaavance .= '"' . $av->id . '":"' . "Fecha de pago: " . $av->fecha_pago . "- Monto:$" . $av->monto . '",';
        }
        $cadenaavance = '{' . rtrim($cadenaavance, ',') . '}';

        $deductivapago = DeductivaPago::select(
            'proyecto_deductiva_pago.id',
            'proyecto_deductiva_pago.fecha_deductiva',
            'proyecto_deductiva_pago.proyecto_id',
            'proyecto_deductiva_pago.monto_deductiva',
            'pp.id as pagoid',
            'pp.fecha_pago',
            'pp.monto',
            'proyecto_deductiva_pago.deductiva_pago'
        )
            ->leftjoin("pago_proyecto as pp", "pp.id", "proyecto_deductiva_pago.pago_proyecto_id")
            ->where('proyecto_deductiva_pago.licitacion_id', $licitacion)
            ->get();

        $inf_pro = Proyecto::where('licitacion_id', $licitacion)->get();

        return view('proyectos.ver-proyecto', compact('cadenaTipoDocumento', 'documentos', 'info_proyecto', 'emisores', 'cliente', 'tipocontrato', 'fuente', 'user', 'pagos',  'licitaciones', 'info_licitacion', 'supervisores', 'cadenaavance', 'deductivapago', 'inf_pro', 'unidad', 'unidad_movimiento'));
    }

    public function eliminarDocumento(Request $request)
    {

        $doc = ProyectoDocumento::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            $proyecto = Proyecto::find($doc->id_proyecto);
            ProyectoDocumento::find($request->id)->delete();
            Storage::delete('proyecto/' . $proyecto->id . '/' . $doc->documento);
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function eliminarpago(Request $request)
    {

        $doc = PagoProyecto::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('proyecto/' . $doc->id_proyecto . '/AvanceFinanciero/' . $doc->factura);
            PagoProyecto::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function eliminardeductiva(Request $request)
    {
        $doc = DeductivaPago::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('proyecto/' . $doc->id_proyecto . '/DeductivaPago/' . $doc->factura);
            DeductivaPago::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function verProyectouni($id,$unidad)
    {
        $proyecto_id_back = $id;
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

        return view('proyectos.unidadcontrato.ver-unidad-proyecto', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'fotografias', 'ver', 'bitacora_unidad','proyecto_id_back'));

    }

    public function asignarclientes($licitacion)
    {
        $usuarios_clientes = User::where('tipo_usuario_id', 1)->where('id_status_delete', 1)->where('estatus_asignacion',1)->get();
        $clientes_contrato = ProyectoClientes::where('licitacion_id', $licitacion)->get();
       
        $usuarios_asignados = ProyectoClientes::where('licitacion_id', $licitacion)->get();

        return view('proyectos.asignar-cliente-proyecto', compact('usuarios_clientes', 'clientes_contrato', 'licitacion' ,'usuarios_asignados'));

    }


    public function asclientecontrato(Request $request)
    {
        if($request->cliente == null){
            
            session()->flash('warning', 'Para continuar es necesario agregar un cliente');
            return redirect()->route('proyecto.asignarclientes', $request->licitacion);
        }

        $inf_pro = Proyecto::where('licitacion_id', $request->licitacion)->first();

       
        foreach ($request->cliente as $key => $value) {

            $data = [
                'cliente_id' => $value,
                'proyecto_id' => $inf_pro->id,
                'licitacion_id' => $request->licitacion,
                'iduserCreated' => auth()->user()->id,
                'iduserUpdated' => auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            ProyectoClientes::insert($data);

            $data_us = [
                'estatus_asignacion' => 2,
                'updated_at' =>date('Y-m-d H:i:s')
            ];
            User::where('id', $value)->update($data_us);
        }

            session()->flash('success', 'Los datos se guardaron correctamente');
            return redirect()->route('proyecto.asignarclientes', $request->licitacion);

    }

    public function eliminarclientecontrato(Request $request)
    {

        $data_us = [
            'estatus_asignacion' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        User::where('id', $request->id)->update($data_us);

        ProyectoClientes::where('cliente_id', $request->id)->delete();

        session()->flash('success', 'Los datos se guardaron correctamente');
        return redirect()->route('proyecto.asignarclientes', $request->id_licitacion);

    }

    public function informacioncliente($licitacion, $cliente)
    {

        $info_cliente = User::where('id', $cliente)->get();

        $unidades_seleccionadas= Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'usr.name', 'pro.segmento_id', 'seg.tipo_vehiculo_id', 'tv.tipo_vehiculo',
            'sc.carroceria', 'sm.motor', 'str.transmision', 'uta.tipo_asignacion')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("users as usr", "usr.id", '=', "unidad.cliente_id")
            ->leftjoin("licitacion_proposicion_economica as pro", "pro.id", '=', "unidad.licitacion_propuesta_economica_id")  
            ->leftjoin("segmentos as seg", "seg.id", '=', "pro.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "seg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "seg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "seg.motor_id")
            ->leftjoin("segmento_transmision as str", "str.id", "seg.transmision_id")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad.id_tipo_asignacion")
            ->where('unidad.cliente_id', $cliente)->where('unidad.unidad_requisicion_estatus_id', 2)->get();
      
        // dd($unidades_seleccionadas);

      return view('proyectos.asi-informacion-cliente', compact( 'licitacion' ,'cliente', 'unidades_seleccionadas', 'info_cliente'));
    }

    public function verinventarioentrega($unidad, $licitacion, $op)
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

        $proyectos= Proyecto::where('licitacion_id', $licitacion)->get();
        $inventarioentrega = InventarioEntrega::where('unidad_id', $unidad)->where('licitaciones_id', $licitacion)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        return view('proyectos.inventario-entrega-contrato', compact( 'licitacion', 'unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'proyectos', 'inventarioentrega', 'licitacion', 'op', 'estados')); 
    }

    public function verinventariosalida($unidad, $licitacion, $op)
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

        $proyectos= Proyecto::where('licitacion_id', $licitacion)->get();
        $inventarioentrega = InventarioSalida::where('unidad_id', $unidad)->where('licitaciones_id', $licitacion)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        return view('proyectos.inventario-salida-contrato', compact( 'licitacion', 'unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'proyectos', 'inventarioentrega', 'licitacion', 'op' , 'estados')); 
    }

    public function unidadesasignadasproyecto($licitacion)
    {
        
        // $unidad_movimiento = AsignacionRegistroUnidad::select('unidad_registro_asignacion.id', 'unidad_registro_asignacion.unidad_id', 'mu.nombre_marca', 'un.folio', 'mou.nombre_modelo','un.unidad_year','un.no_serie','un.placa', 'un.proyectos_id', 'unidad_registro_asignacion.op_asignacion', 'unidad_registro_asignacion.fecha_asignacion', 'uta.tipo_asignacion', 'use.name', "unidad_registro_asignacion.licitaciones_id")
        //     ->leftjoin("unidad as un", "un.id", "unidad_registro_asignacion.unidad_id")
        //     ->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca")
        //     ->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo")
        //     ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad_registro_asignacion.id_tipo_asignacion")
        //     ->leftjoin("users as use", "use.id", "unidad_registro_asignacion.cliente_id")
        //     ->where('unidad_registro_asignacion.licitaciones_id', $licitacion)->get();

        $unidad_movimiento = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status','unidad.proyectos_id', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'use.name', 'uta.tipo_asignacion')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("users as use", "use.id", "unidad.cliente_id")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad.id_tipo_asignacion")
            ->where('unidad.licitaciones_id', $licitacion)->get();



        return view('proyectos.unidades-asignadas-proyecto', compact('unidad_movimiento', 'licitacion'));
    }

    public function retunidadesasignadasproyecto($unidad, $licitacion)
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
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        $inventarioentrega = InventarioSalida::where('unidad_id', $unidad)->where('licitaciones_id', $licitacion)->first();
        // dd($inventarioentrega);
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        return view('proyectos.retirar-unidad-contrato', compact( 'licitacion', 'unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'ubicacion', 'inventarioentrega', 'estados'));
    }

    public function retirarunidadupd(Request $request)
    {
        
        $proyecto = Proyecto::where('licitacion_id', $request->licitacion_id)->orderBy('id', 'desc')->first();

        $data = [
            'unidad_id' => $request->unidad_id,
            'proyectos_id' => $proyecto->id,
            'licitaciones_id' => $request->licitacion_id,
            'ubicacion_unidad_id' => $request->id_ubicacion,
            'fecha_retiro' => $request->fecha_retiro ? Carbon::createFromFormat('d/m/Y', $request->fecha_retiro)->format('Y-m-d') : null,
            'poliza_seguro' => $request->poliza_seguro ? $request->poliza_seguro:0,
            'manual' => $request->manual ? $request->manual:0,
            'lugar' => $request->lugar ? $request->lugar:0,
            'no_tarjeta_circulacion' => $request->tarjeta_circulacion ? $request->tarjeta_circulacion:0,
            'verificacion_ambiental' => $request->verificacion_ambiental ? $request->verificacion_ambiental:0,
            'kilometraje' => $request->kilometraje ? $request->kilometraje:0,
            'tenencia' => $request->tenencia ? $request->tenencia:0,
            'poliza_de_garantia' => $request->poliza_garantia ? $request->poliza_garantia:0,
            'aire_acondicionado' => $request->aire_acondicionado ? $request->aire_acondicionado:0,
            'llanta_refaccion' => $request->llanta_refaccion ? $request->llanta_refaccion:0,
            'tapon_aceite' => $request->tapon_aceite ? $request->tapon_aceite:0,
            'calefaccion' => $request->calefaccion ? $request->calefaccion:0,
            'gato' => $request->gato ? $request->gato:0,
            'tapon_agua' => $request->tapon_agua ? $request->tapon_agua:0,
            'radio' => $request->radio ? $request->radio:0,
            'llave_auxiliar' => $request->llave_auxiliar ? $request->llave_auxiliar:0,
            'tapon_gasolina' => $request->tapon_gasolina ? $request->tapon_gasolina:0,
            'antena' => $request->antena ? $request->antena:0,
            'herramienta' => $request->herramienta ? $request->herramienta:0,
            'defensa_lateral' => $request->defensa_lateral ? $request->defensa_lateral:0,
            'encendedor' => $request->encendedor ? $request->encendedor:0,
            'extinguidor' => $request->extinguidor ? $request->extinguidor:0,
            'defensa_trasera' => $request->defensa_trasera ? $request->defensa_trasera:0,
            'ceniceros' => $request->ceniceros ? $request->ceniceros:0,
            'calaveras' => $request->calaveras ? $request->calaveras:0,
            'tapetes' => $request->tapetes ? $request->tapetes:0,
            'manijas' => $request->manijas ? $request->manijas:0,
            'parabrisas' => $request->parabrisas ? $request->parabrisas:0,
            'viceras'  => $request->viceras ? $request->viceras:0,
            'elevadores' => $request->elevadores ? $request->elevadores:0,
            'medallon' => $request->medallon ? $request->medallon:0,
            'biseles' => $request->biseles ? $request->biseles:0,
            'espejo_retrovisor' => $request->espejo_retrovisor ? $request->espejo_retrovisor:0,
            'brazos_limpiadores' => $request->brazos_limpiadores ? $request->brazos_limpiadores:0,
            'cuartos' => $request->cuartos ? $request->cuartos:0,
            'claxon' => $request->claxon ? $request->claxon:0,
            'espejos_laterales' => $request->espejos_laterales ? $request->espejos_laterales:0,
            'stop' => $request->stop ? $request->stop:0,
            'tapones_llantas' => $request->tapones_llantas ? $request->tapones_llantas:0,
            'senales_carretera' => $request->senales_carretera ? $request->senales_carretera:0,
            'duplicado_llaves' => $request->duplicado_llaves ? $request->duplicado_llaves:0,
            'reflejantes' => $request->reflejantes ? $request->reflejantes:0,
            'cables_corriente' => $request->cables_corriente ? $request->cables_corriente:0,
            'acumulador'  => $request->acumulador ? $request->acumulador:0,
            'marca_llantas' => $request->marca_llantas,
            'llanta_delantera_derecha' => $request->llanta_delantera_derecha ? $request->llanta_delantera_derecha:0,
            'llanta_delantera_izquierda' => $request->llanta_delantera_izquierda ? $request->llanta_delantera_izquierda:0,
            'llanta_trasera_derecha' => $request->llanta_trasera_derecha ? $request->llanta_trasera_derecha:0,
            'llanta_trasera_izquierda' => $request->llanta_trasera_izquierda ? $request->llanta_trasera_izquierda:0,
            'llantar_refaccion' => $request->llantar_refaccion ? $request->llantar_refaccion:0,
            'nivel_combustible' => $request->nivel_combustible,
            'observaciones' => $request->observaciones,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'nombre_jetvan' => $request->nombre_jetvan,
            'fecha_jetvan' => $request->fecha_jetvan,
            'personal' => $request->personal,
            'nombre_entrega' => $request->nombre_entrega,
            'fecha_entrega' => $request->fecha_entrega,
            'nombre_cliente' => $request->nombre_cliente,
            'fecha_recepcion' => $request->fecha_recepcion,
            'tipo_translado' => $request->tipo_translado,
            'entidad_federativa' => $request->entidad_federativa,
            'calle' => $request->calle,
            'colonia' => $request->colonia,
            'numero_int' => $request->numero_int,
            'numero_ext' => $request->numero_ext,
            'codigo_postal' => $request->codigo_postal,
        ];
        
        InventarioSalida::insert($data);

        $active = Unidad::where('id', $request->unidad_id)->first();
        
        $data_movimiento = [
            'unidad_id' => $request->unidad_id,
            'licitaciones_id' => $request->licitacion_id,
            'proyectos_id' => $proyecto->id,
            'licitacion_proposicion_economica_id' => $active->licitacion_propuesta_economica_id,
            'id_tipo_asignacion' => $active->id_tipo_asignacion,
            'cliente_id' => $active->cliente_id,
            'fecha_asignacion' => $request->fecha_retiro ? Carbon::createFromFormat('d/m/Y', $request->fecha_retiro)->format('Y-m-d') : null,
            'op_asignacion' => 1,
            'ubicacion_id' => $request->id_ubicacion,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id
        ];
        AsignacionRegistroUnidad::insert($data_movimiento);
        

        $data = [
            'unidad_asignacion_id' => 2,
            'id_ubicacion' => $request->id_ubicacion,
            'licitaciones_id' => null,
            'proyectos_id' => null,
            'licitacion_propuesta_economica_id' => null,
            'cliente_id' => null,
            'inv_entrega' => 0,
            'fecha_asignacion'=> null,
            'unidad_requisicion_estatus_id' => 1,
            
            'updated_at' => date('Y-m-d H:i:s'),
            'iduserUpdated' => auth()->user()->id
        ];
        Unidad::where('id',$request->unidad_id)->update($data);

        // dd($request);
        
        session()->flash('success', 'La unidad se retiro correctamente');
        return redirect()->route('proyecto.unidadesasignadasproyecto', $request->licitacion_id);
    }

    public function descargaunidadescontrato(Request $request)
    {
        // dd($request);

        return Excel::download(new UnidadesContratoExport($request),"Unidades asignadas a contrato - Fecha de descarga".date('d-m-Y').".xlsx");
    }

    public function estimaciones($licitacion)
    {
        $unidad_movimiento = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status','unidad.proyectos_id', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'use.name', 'uta.tipo_asignacion')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("users as use", "use.id", "unidad.cliente_id")
            ->leftjoin("unidad_tipo_asignacion as uta", "uta.id", "unidad.id_tipo_asignacion")
            ->where('unidad.licitaciones_id', $licitacion)->get();


        return view('proyectos.estimaciones', compact('unidad_movimiento', 'licitacion'));       
    }

}
