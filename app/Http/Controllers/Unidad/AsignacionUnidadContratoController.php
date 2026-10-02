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
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\InventarioEntrega;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Licitacion\ProposicionEconomica;
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
use App\Models\Logistica\AsignacionTotalUnidades;

use App\Models\Logistica\AsignacionArea;
use App\Models\Logistica\AsignacionPartida;


use App\Models\Requisicion\Requisicion;
use App\Services\BusquedaService;

class AsignacionUnidadContratoController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function unidsinasignacion()
    {
        $ubicacion_data = Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->where('unidad.id_status_delete', 1)->where('unidad.unidad_asignacion_id', 2)->where('unidad.apartado_asignacion', 0)->get();  
        // dd($ubicacion_data);

        return view('unidades.asignacioncontratos.logistica.unidades-sin-asignacion', compact('ubicacion_data'));        
    }

    public function unidadesasignadas()
    {
        $unidades_seleccionadas= Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico', 'aul.nombre_asignacion')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->leftjoin("asignacion_unidad_log as aul", "aul.id", '=', "atu.id_asignacion")
            
            ->where('unidad.id_status_delete', 1)->where('unidad.unidad_asignacion_id', 2)->where('unidad.apartado_asignacion', 1)->get();
        // dd($unidades_seleccionadas); 

        return view('unidades.asignacioncontratos.logistica.unidades-asignadas', compact('unidades_seleccionadas'));     
    }

    public function asignacioncontratos()
    {
		$asignacionLogistica = AsignacionLogistica::where('id_status_delete', 1)->get();


        return view('unidades.asignacioncontratos.logistica.listado-asignaciones', compact('asignacionLogistica'));
    	// return view('unidades.asignacioncontratos.catalogo-contratos-disponibles', compact('unidad'));
    }

    public function asignaciondatatable(Request $request)
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

    public function unidadescontrato($licitacion)
    {
    	$unidad = Unidad::where('id_status_delete', 1)->get();
    	$ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();


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
            ->where('unidad.licitaciones_id', $licitacion)->where('unidad.unidad_requisicion_estatus_id', 2)->get();


    	return view('unidades.asignacioncontratos.asignar-unidades', compact('unidad', 'ubicacion' , 'licitacion', 'unidades_seleccionadas'));    	
    }

    public function asignarunidadespatio($licitacion, $patio)
    {

        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.inv_entrega', 'unidad.licitaciones_id', 'unidad.op_unidad_nueva')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.id_ubicacion', $patio)->where('unidad.unidad_requisicion_estatus_id', 1)->get();

        $tipoasignacion = TipoAsignacion::where('id_status_delete', 1)->get();

        $usuarios_asignados = ProyectoClientes::where('licitacion_id', $licitacion)->get();

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision'
        )
            ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id", $licitacion)
            ->get();


      	return view('unidades.asignacioncontratos.unidades-patio', compact('ubicacion_data', 'patio' , 'licitacion', 'tipoasignacion', 'usuarios_asignados', 'segmento')); 

    }

    public function asignacionunidadescontrato(Request $request)
    {

    	$proyecto = Proyecto::where('licitacion_id', $request->licitacion)->orderBy('id', 'desc')->first();
        // dd($proyecto);
        // $data = [
        //     'proyectos_id' => null,
        //     'licitaciones_id' => null,
        //     'licitacion_propuesta_economica_id' => null,
        //     'cliente_id' =>null,
        //     'id_ubicacion' => 1,
        //     'unidad_requisicion_estatus_id' => 1
        // ];
        // Unidad::where('id',101)->update($data);
    	$unidad = count($request->unidad);
        
    	$dato = $unidad ;
    	for($i=0; $i <= $dato; $i++){
    		// dd());
    		if(empty($request->segmento[$i]) != true){
    			$op= 0;
                // dd($op);
    			if(empty($request->asignacion[$i]) != true){
    				$op= 0;
    				if($request->fecha_asignacion[$i] != null){
    					$op= 0;
    					if(empty($request->cliente[$i]) != true){
    						$op = 0;
    	    						// data insert
    						$data = [
    							'unidad_asignacion_id' => 1,
    							'id_ubicacion' => null,
    							'licitaciones_id' => $request->licitacion,
    							'proyectos_id' => $proyecto->id,
    							'licitacion_propuesta_economica_id' => $request->segmento[$i],
    							'cliente_id' => $request->cliente[$i],
    							'id_tipo_asignacion' => $request->asignacion[$i],
    							'fecha_asignacion' => $request->fecha_asignacion[$i],
    							'unidad_requisicion_estatus_id' => 2,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'iduserUpdated' => auth()->user()->id
    						];
    						Unidad::where('id',$request->unidad[$i])->update($data);
                            // dd($op);

                            $data_movimiento = [
                                'unidad_id' => $request->unidad[$i],
                                'licitaciones_id' => $request->licitacion,
                                'proyectos_id' => $proyecto->id,
                                'licitacion_proposicion_economica_id' => $request->segmento[$i],
                                'id_tipo_asignacion' => $request->asignacion[$i],
                                'cliente_id' => $request->cliente[$i],
                                'fecha_asignacion' => $request->fecha_asignacion[$i],
                                'op_asignacion' => 0,
                                'ubicacion_id' => $request->patio,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'iduserCreated' => auth()->user()->id,
                                'iduserUpdated' => auth()->user()->id
                            ];
                            AsignacionRegistroUnidad::insert($data_movimiento);

                            
    						//unidad_registro_asignacion
                            // $data_inventario = [
                            //     'proyectos_id' => $proyecto->id,
                            //     'licitaciones_id' => $request->licitacion,
                            //     'updated_at' => date('Y-m-d H:i:s'),
                            //     'iduserUpdated' => auth()->user()->id
                            // ];

                            // InventarioEntrega::where('unidad_id', $request->unidad[$i])->where('licitaciones_id', $request->licitacion)->update($data_inventario);

    					}else{
    						$op = 1;	
    					}
    				}else{
    					$op = 1;
    				}
    			}else{
    				$op = 1;
    			}
    		}else{
    			$op = 1;
    		}
    	}


        session()->flash('success', 'La información se modifico correctamente');
    	return redirect()->route('asignarunidad.asignarunidadespatio', [$request->licitacion, $request->patio]);

    }

    public function inventarioentrega($licitacion, $patio, $unidad)
    {

        $fotografias = UnidadFotografia::where('unidad_id', $unidad)->get();
        $unidad_info = Unidad::find($unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $proyectos= Proyecto::where('licitacion_id', $licitacion)->get();
        $inventarioentrega = InventarioEntrega::where('unidad_id', $unidad)->where('licitaciones_id', $licitacion)->first();
        // dd($inventarioentrega);
       

        return view('unidades.asignacioncontratos.inventario-entrega', compact( 'patio' , 'licitacion', 'unidad', 'fotografias', 'unidad_info', 'marcas', 'modelos', 'ver', 'proyectos', 'inventarioentrega', 'estados')); 
    }

    public function inventarioaddunidad(Request $request)
    {
       
        $proyecto = Proyecto::where('licitacion_id', $request->licitacion_id)->orderBy('id', 'desc')->first();

        $data = [
            'unidad_id' => $request->unidad_id,
            'proyectos_id' => $proyecto->id,
            'licitaciones_id' => $request->licitacion_id,
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
            'entidad_federativa_recoleccion' => $request->entidad_federativa_recoleccion,
            'calle_recoleccion' => $request->calle_recoleccion,
            'colonia_recoleccion' => $request->colonia_recoleccion,
            'numero_int_recoleccion' => $request->numero_int_recoleccion,
            'numero_ext_recoleccion' => $request->numero_ext_recoleccion,
            'codigo_postal_recoleccion' => $request->codigo_postal_recoleccion,
            'requiere_permiso' => $request->requiere_permiso
        ];
        
        // dd($request);
        $info_unidad = Unidad::where('id', $request->unidad_id)->first();
        if($info_unidad->inv_entrega == 0)
        {
            $data['iduserCreated'] = auth()->user()->id;
            $data['iduserUpdated'] = auth()->user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $data_unidad= [
                'inv_entrega'=> 1
            ];
            // dd($data);
            InventarioEntrega::insert($data);
            Unidad::where('id', $request->unidad_id)->update($data_unidad);
        }else{
            $data['iduserUpdated'] = auth()->user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');
            InventarioEntrega::where('unidad_id', $request->unidad_id)->where('licitaciones_id', $request->licitacion_id)->update($data);
        }

        
        session()->flash('success', 'El inventario de entrega de la unidad se agrego correctamente');
        return redirect()->route('asignarunidad.asignarunidadespatio', [$request->licitacion_id, $request->patio_id]);

    }



    public function nuevaasignacion()
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

        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();
        $proyecto = Proyecto::where('id_status_delete', 1)->get();
        // dd($proyecto);

        return view('unidades.asignacioncontratos.logistica.nueva-asignacion', compact('estados', 'municipios','cadenaTipoDocumento', 'ubicacion', 'proyecto'));
    }

    public function addasignacionlog(Request $request)
    {

        
        if($request->tipo_asignacion == 0){
            $id_proyecto = $request->id_proyecto;
            $id_patio = null;
        }else{
            $id_proyecto = null;
            $id_patio = $request->id_patio;
        }

        $data = [
            'tipo_asignacion' => $request->tipo_asignacion,
            'id_patio' => $id_patio,
            'id_proyectos' => $id_proyecto,
            'nombre_asignacion' => $request->nombre_asignacion,
            'direccion' => $request->direccion,
            'sub_direccion' => $request->subdireccion,
            'coordinacion' => $request->coordinacion,
            'area' => $request->area,
            'partida' => $request->partida,
            'calle' => $request->calle,
            'poblacion' => $request->poblacion,
            'id_municipio' => $request->id_municipio,
            'id_estado' => $request->id_estado,
            'cp' => $request->cp,
            'contacto' => $request->contacto,
            'observaciones' => $request->observaciones,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $asignacion_id = AsignacionLogistica::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('asignacionlog/'.$asignacion_id, $archivo, $archivoNombre);
                $data = [
                    'asignacion_id' => $asignacion_id,
                    'id_tipo_documento' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserUpdated' =>auth()->user()->id
                ];
                AsignacionDocumento::insert($data);
            }
        }

        session()->flash('success', 'La asignación se añadió correctamente');
        return redirect()->route('asignarunidad.asignacioncontratos');

    }

    public function editarasignacion($id_asignacion)
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

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();
        $doc_asignacion = AsignacionDocumento::where('asignacion_id', $id_asignacion)->get();

        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();
        $proyecto = Proyecto::where('id_status_delete', 1)->get();

        return view('unidades.asignacioncontratos.logistica.editar-asignacion', compact('estados', 'municipios','cadenaTipoDocumento', 'asignacionLogistica', 'doc_asignacion', 'ubicacion', 'proyecto'));        
    }

    public function editasignacionlog(Request $request)
    {

        if($request->tipo_asignacion == 0){
            $id_proyecto = $request->id_proyecto;
            $id_patio = null;
        }else{
            $id_proyecto = null;
            $id_patio = $request->id_patio;
        }

        $data = [
            'tipo_asignacion' => $request->tipo_asignacion,
            'id_patio' => $id_patio,
            'id_proyectos' => $id_proyecto,
            'nombre_asignacion' => $request->nombre_asignacion,
            'direccion' => $request->direccion,
            'sub_direccion' => $request->subdireccion,
            'coordinacion' => $request->coordinacion,
            'area' => $request->area,
            'partida' => $request->partida,
            'calle' => $request->calle,
            'poblacion' => $request->poblacion,
            'id_municipio' => $request->id_municipio,
            'id_estado' => $request->id_estado,
            'cp' => $request->cp,
            'contacto' => $request->contacto,
            'observaciones' => $request->observaciones,
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        AsignacionLogistica::where('id', $request->id_asignacion)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('asignacionlog/'.$request->id_asignacion, $archivo, $archivoNombre);
                $data = [
                    'asignacion_id' => $request->id_asignacion,
                    'id_tipo_documento' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserUpdated' =>auth()->user()->id
                ];
                AsignacionDocumento::insert($data);
            }
        }

        session()->flash('success', 'La asignación se modifico correctamente');
        return redirect()->route('asignarunidad.asignacioncontratos');        
    }

    public function deleteasignacionlog(Request $request)
    {
        $doc = AsignacionDocumento::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('asignacionlog/'.$doc->id_asignacion.'/'.$doc->documento);
            AsignacionDocumento::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);        
    }

    public function verasignacion($id_asignacion)
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

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();
        $doc_asignacion = AsignacionDocumento::where('asignacion_id', $id_asignacion)->get();

        return view('unidades.asignacioncontratos.logistica.ver-asignacion', compact('estados', 'municipios','cadenaTipoDocumento', 'asignacionLogistica', 'doc_asignacion'));            
    }

    public function patiosasignacion($id_asignacion)
    {
        $unidad = Unidad::where('id_status_delete', 1)->get();
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();

        $unidades_seleccionadas= Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $id_asignacion)->get();
        // dd($unidades_seleccionadas);

        $requisicion = Requisicion::where('id_status_delete', 1)->where('requisicion_estatus_id', 2)->orWhere('requisicion_estatus_id', 4)->get();
        // dd($requisicion);

        return view('unidades.asignacioncontratos.logistica.patios-asignar-unidades', compact('unidad', 'ubicacion', 'id_asignacion', 'asignacionLogistica', 'requisicion', 'unidades_seleccionadas' ));       
    }

    public function unidadespatiolog($id_asignacion, $id_patio)
    {
        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.inv_entrega', 'unidad.licitaciones_id', 'unidad.op_unidad_nueva')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.id_ubicacion', $id_patio)->where('unidad.unidad_requisicion_estatus_id', 1)->where('unidad.apartado_asignacion', 0)->get();

        $tipoasignacion = TipoAsignacion::where('id_status_delete', 1)->get();

        // $usuarios_asignados = ProyectoClientes::where('licitacion_id', $licitacion)->get();

        // $segmento = ProposicionEconomica::select(
        //     'licitacion_proposicion_economica.id',
        //     'licitacion_proposicion_economica.licitacion_id',
        //     'licitacion_proposicion_economica.segmento_id',
        //     'licitacion_proposicion_economica.cantidad',
        //     'licitacion_proposicion_economica.precio_unitario',
        //     'tv.tipo_vehiculo',
        //     'sc.carroceria',
        //     'sm.motor',
        //     'st.transmision'
        // )
        //     ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
        //     ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
        //     ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
        //     ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
        //     ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
        //     ->where("licitacion_proposicion_economica.licitacion_id", $licitacion)
        //     ->get();

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();

        return view('unidades.asignacioncontratos.logistica.unidades-patio-logistica', compact('ubicacion_data', 'tipoasignacion', 'id_asignacion', 'id_patio', 'asignacionLogistica'));         
    }

    public function unidadrequisicionlog($id_asignacion, $id_requisicion)
    {

        
        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.inv_entrega', 'unidad.licitaciones_id', 'unidad.op_unidad_nueva')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->where('unidad.requisicion_id_ordencompra', $id_requisicion)->where('unidad.unidad_requisicion_estatus_id', 1)->where('unidad.apartado_asignacion', 0)->get();

        // dd($ubicacion_data);
        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first(); 

        return view('unidades.asignacioncontratos.logistica.unidades-requisicion-logistica', compact('ubicacion_data', 'id_asignacion', 'id_requisicion', 'asignacionLogistica'));         
    }

    public function addtotalunidades(Request $request)
    {
        // dd($request);
        if ($request->segmento != null) {
            foreach ($request->segmento as $segmento) {
                // dd($segmento);
                    $data = [
                        'op_asignacion' => 0,
                        'id_patio' => $request->patio, 
                        'id_asignacion' => $request->id_asignacion,
                        'unidad_id' => $segmento,
                        'iduserCreated' => auth()->user()->id,
                        'fecha_asignacion' => date('Y-m-d H:i:s'),
                    ];
                    AsignacionTotalUnidades::insert($data);


                    $data_unid = [
                        'apartado_asignacion' => 1,
                    ];

                    Unidad::where('id', $segmento)->update($data_unid);
            }   // Insertar segmentos 


        } else {


        }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('asignarunidad.unidadespatiolog', [$request->id_asignacion, $request->patio] );   

    }

    public function addtotalunidadesreq(Request $request)
    {
        // dd($request);
        if ($request->segmento != null) {
            foreach ($request->segmento as $segmento) {
                // dd($segmento);
                    $data = [
                        'op_asignacion' => 1,
                        'id_requisicion' => $request->requisicion,
                        'id_asignacion' => $request->id_asignacion,
                        'unidad_id' => $segmento,
                        'iduserCreated' => auth()->user()->id,
                        'fecha_asignacion' => date('Y-m-d H:i:s'),
                    ];
                    AsignacionTotalUnidades::insert($data);


                    $data_unid = [
                        'apartado_asignacion' => 1,
                    ];

                    Unidad::where('id', $segmento)->update($data_unid);
            }   // Insertar segmentos 


        } else {


        }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('asignarunidad.unidadrequisicionlog', [$request->id_asignacion, $request->requisicion] );        
    }

    public function deleteunidasig(Request $request)
    {
        if ($request->segmento != null) {
            foreach ($request->segmento as $segmento) {
                // dd($segmento);

                    AsignacionTotalUnidades::where("unidad_id", $segmento)->delete();

                    $data_unid = [
                        'apartado_asignacion' => 0,
                    ];

                    Unidad::where('id', $segmento)->update($data_unid);
            }   // Insertar segmentos 


        } else {


        }

        session()->flash('success', 'Las unidades se quitaron correctamente');
        return redirect()->route('asignarunidad.patiosasignacion', $request->id_asignacion );  
    }

    public function asignacionbusqueda($id_asignacion)
    {

        $unidad = Unidad::where('id_status_delete', 1)->get();
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();

        $unidades_seleccionadas= Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $id_asignacion)->get();
        // dd($unidades_seleccionadas);

        $requisicion = Requisicion::where('id_status_delete', 1)->where('requisicion_estatus_id', 2)->orWhere('requisicion_estatus_id', 4)->get();
        // dd($requisicion);

        return view('unidades.asignacioncontratos.logistica.asignacion-busqueda', compact('unidad', 'ubicacion', 'id_asignacion', 'asignacionLogistica', 'requisicion', 'unidades_seleccionadas' ));  

    }

    public function busquedaasig(Request $request)
    {
        

        $listado = null !== $request->listado ? explode("\r\n", $request->listado) : [];

        $tipo = (int) $request->tipo;
        $bid = $request->bid;
        $consultaResultado = match ($tipo) {
            1 => "unidad.no_serie",
            2 => "unidad.placa",
            3 => "unidad.numero_economico",
            default => null
        };

        $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.inv_entrega', 'unidad.licitaciones_id', 'unidad.op_unidad_nueva', 'unidad.apartado_asignacion', 'atu.id_asignacion', 'aul.nombre_asignacion')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("asignacion_unidad_log as aul", "aul.id", '=', "atu.id_asignacion")
            
            ->whereIn($consultaResultado, $listado)
            // ->where('unidad.id_ubicacion', $id_patio)->where('unidad.unidad_requisicion_estatus_id', 1)->where('unidad.apartado_asignacion', 0)->get();
            ->get();

        $id_asignacion = $request->id_asignacion;
        // dd($listado);

        $asignacionLogistica = AsignacionLogistica::where('id', $id_asignacion)->first();



        return view('unidades.asignacioncontratos.logistica.asignacion-busqueda-resultado', compact('ubicacion_data', 'id_asignacion', 'listado', 'asignacionLogistica' ));
    }

    public function addtotalunidadesbus(Request $request)
    {
        // dd($request);

        if ($request->segmento != null) {
            foreach ($request->segmento as $segmento) {
                
                $asignacionLogistica = AsignacionTotalUnidades::where('unidad_id', $segmento)->first();

                if($asignacionLogistica != null){
                    AsignacionTotalUnidades::where('unidad_id',  $segmento)->delete();
                }

                $unidad = Unidad::where('id', $segmento)->first();
                    // dd($unidad);
                    $data = [
                        'op_asignacion' => 0,
                        'id_patio' => $request->id_ubicacion, 
                        'id_asignacion' => $request->id_asignacion,
                        'unidad_id' => $segmento,
                        'iduserCreated' => auth()->user()->id,
                        'fecha_asignacion' => date('Y-m-d H:i:s'),
                    ];
                    AsignacionTotalUnidades::insert($data);


                    $data_unid = [
                        'apartado_asignacion' => 1,
                    ];

                    Unidad::where('id', $segmento)->update($data_unid);
            }   // Insertar segmentos 


        } else {


        }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('asignarunidad.patiosasignacion', $request->id_asignacion );  

    }

}