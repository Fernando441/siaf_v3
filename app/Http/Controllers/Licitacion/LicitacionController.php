<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use App\Models\Licitacion\LicitacionPrioridad;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion\TipoDocumentoLicitacion;
use App\Models\Licitacion\Licitacion;
use App\Models\Licitacion\DocumentoLicitacion;
use App\Models\Proyecto\Emisor;
use App\Models\Licitacion\PublicacionLicitacion;
use App\Models\Licitacion\TipoContratacion;
use App\Models\Licitacion\LicitacionSegmento;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Cliente\Cliente;
use App\Models\Proyecto\Proyecto;

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
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UnidadMovimientos;
use App\Models\Unidad\UnidadDocumento;

use App\Models\Licitacion\Afianzadora;
use App\Models\Licitacion\LicitacionTipoFianza;
use App\Models\Licitacion\LicitacionFianza;
use App\Models\Licitacion\LicitacionSeguroRC;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Notificaciones\Notificaciones;
use Mpdf\Mpdf;

class LicitacionController extends Controller
{
    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function listadolicitaciones()
    {

    	$documento = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();
    	$cliente = Cliente::where('id_status_delete', 1)->get();
    	$tipo_contratacion = TipoContratacion::where('id_status_delete', 1)->get();

        $licitacion_prioridad = LicitacionPrioridad::where('id_licitacion_prioridad_estatus', 1)->get();

        return view('licitaciones.listado-licitaciones', compact('licitacion_prioridad', 'documento', 'cliente', 'tipo_contratacion'));
    }

    public function licitaciondatatable(Request $request)
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
        $totalRecords = Licitacion::select('count(*) as allcount')->count();

        $totalRecordswithFilter = Licitacion::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();

        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $records = Licitacion::select(
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
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
            ->where("licitaciones.id_status_delete", 1)
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

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.folio", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'titulo_servicio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.titulo_servicio", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'cliente') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.cliente", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'publicacion_licitacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.publicacion_licitacion", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'fecha_visita') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.fecha_visita", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if ($columna['data'] == 'tipo_contratacion') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.contratacion", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }


            if ($columna['data'] == 'id_licitacion_prioridad') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Licitacion::select(
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
                        'licitaciones.tipo_contrato'
                    )
                        ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                        ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                        ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                        ->where("licitaciones.id_status_delete", 1)
                        ->where("licitaciones.id_licitacion_prioridad", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
        }

        if ($valor == "No") {
            $records = Licitacion::select(
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
                'licitaciones.tipo_contrato'
            )
                ->leftjoin("publicacion_licitacion as pl", "pl.id", "licitaciones.publicacion_licitacion")
                ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
                ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
                ->where("licitaciones.id_status_delete", 1)
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro = "";
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "folio" => $record->folio,
                "no_licitacion" => $record->no_licitacion,
                "cliente" => $record->razon_social,
                "titulo_servicio" => $record->titulo_servicio,
                "id_licitacion_prioridad" => $record->id_licitacion_prioridad,
                "publicacion_licitacion" => $record->publ,
                "fecha_visita" => $record->fecha_visita,
                "tipo_contratacion" => $record->tipo_contratacion,
                "permisos" => $permiso_array,
                "acto_fallo" => $record->acto_fallo,
                "tipo_contrato" => $record->tipo_contrato,
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


    public function agregarlicitacion()
    {

    	$documentos = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();
    	$emisores = Emisor::where('id_status_delete', 1)->get();
    	$publicacion = PublicacionLicitacion::where('status_delete', 0)->get();
    	$cliente = Cliente::where('id_status_delete', 1)->get();
    	$tipo_contratacion = TipoContratacion::where('id_status_delete', 1)->get();
    	$licitacion_prioridad = LicitacionPrioridad::where('id_licitacion_prioridad_estatus', 1)->get();

    	//tipo de documentos en formato json
    	$cadenaTipoDocumento = "";
    	foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->documento_licitacion.'",';

        }
        $cadenaTipoDocumento = '{' . rtrim($cadenaTipoDocumento, ',') . '}';


        $permiso = RolPermiso::where('permission_id', 141)->get();
        foreach ($permiso as $key => $value) {
           $users = User::select('users.id', 'users.name', 'users.email', 'users.id_status_delete', 
            'rol.name as name_role', 'users.role', 'users.rfc', 'users.telefono', 'users.ubicacion', 'users.avatar')
            ->leftjoin("roles as rol","rol.id","users.role")->where('role', $value->role_id)->get();
        }   

        return view('licitaciones.agregar-licitacion', compact('licitacion_prioridad', 'cadenaTipoDocumento', 'emisores', 'publicacion', 'cliente', 'tipo_contratacion', 'users'));
    }

    public function guardarlicitacion(Request $request)
    {

        $data = [
            'id_licitacion_estatus' => 1,
            'folio' => $this->folio->getFolioLicitacion(),
            'titulo_servicio' => $request->titulo_servicio,
            'observaciones' => $request->observaciones,
            'cliente' => $request->cliente,
            'id_licitacion_prioridad' => $request->prioridad,
            'contratacion' => $request->tipo_contratacion,
            'no_licitacion' => $request->no_licitacion,
            'fecha_visita_aplica' => $request->fecha_visita_aplica,
            'fecha_visita' => $request->fecha_visita ? Carbon::now():null,
            'junta_aclaraciones' => $request->junta_aclaraciones ? Carbon::now():null,
            'fecha_preguntas' => $request->fecha_preguntas ? Carbon::now():null,
            'apertura_proposiciones' => $request->apertura_proposiciones ? Carbon::createFromFormat('d/m/Y', $request->apertura_proposiciones)->format('Y-m-d'):null,
            'acto_fallo' => $request->acto_fallo ? Carbon::createFromFormat('d/m/Y', $request->acto_fallo)->format('Y-m-d'):null,
            'acto_fallo_info' => $request->acto_fallo_info ? Carbon::createFromFormat('d/m/Y', $request->acto_fallo_info)->format('Y-m-d'):null,
            'publicacion_licitacion' =>$request->publicacion_licitacion,
            'fecha_apertura_tecnica' => $request->fecha_apertura_tecnica ? Carbon::createFromFormat('d/m/Y', $request->fecha_apertura_tecnica)->format('Y-m-d'):null,
            'fecha_apertura_economica' => $request->fecha_apertura_economica ? Carbon::createFromFormat('d/m/Y', $request->fecha_apertura_economica)->format('Y-m-d'):null,
            'fecha_subasta_aplica' => $request->fecha_subasta_aplica,
            'fecha_subasta' => $request->fecha_subasta ? Carbon::createFromFormat('d/m/Y', $request->fecha_subasta)->format('Y-m-d'):null,
            'firma_entrega' =>$request->firma_entrega ? Carbon::createFromFormat('d/m/Y', $request->firma_entrega)->format('Y-m-d'):null,
            'fecha_entrega' =>$request->fecha_entrega ? Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d'):null,
            'fecha_cierre' =>$request->fecha_cierre ? Carbon::createFromFormat('d/m/Y', $request->fecha_cierre)->format('Y-m-d'):null,
            'monto_fianza_liberada' => $request->monto_fianza_liberada ? $this->money_format->clearFormat($request->monto_fianza_liberada):null,
            'modalidad' => $request->modalidad,
            'fecha_compra_bases' =>  $request->fecha_compra_bases ? Carbon::createFromFormat('d/m/Y', $request->fecha_compra_bases)->format('Y-m-d'):null,
            'fecha_entrega_propuestas' => $request->fecha_entrega_propuestas ? Carbon::now():null,
            'fecha_repreguntas_aplica' => $request->fecha_repreguntas_aplica,
            'fecha_repreguntas' => $request->fecha_repreguntas ? Carbon::createFromFormat('d/m/Y', $request->fecha_repreguntas)->format('Y-m-d'):null,
            'id_status_delete' => 1,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'sector'=>$request->sector,
            'tipo_partida'=>$request->tipo_partida,
            'fecha_final_servicios' =>$request->fecha_final_servicios ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_servicios)->format('Y-m-d'):null,
            'numero_vehiculos'=>$request->numero_vehiculos,
            'tipo_contrato'=>$request->tipo_contrato,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')

        ];

        $id = Licitacion::insertGetId($data);

        if($request->acto_fallo != null || $request->acto_fallo != "")
        {
            if (in_array("141", Session::get('permisos'))){
                $this->notificacionconcursoganado($id, 1);
            }
        }


        //inicio recepción de archivos
        $colIdDocumento = $request->id_documento;
        $licitacion = Licitacion::find($id);
        if ($request->hasfile('archivo')) {
            $archivos = $request->file('archivo');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('licitacion/' . $licitacion->folio, $archivo, $archivoNombre);
                $data = [
                    'id_licitacion' => $licitacion->id,
                    'documento' => $archivoNombre,
                    'tipo_documento' => $colIdDocumento[$indice],
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                DocumentoLicitacion::insert($data);
            }
        }
        //fin recepción de archivos

        session()->flash('success', 'La licitación se creo correctamente');
        return redirect()->route('licitacion.listadolicitaciones');
    }

    public function notificacionconcursoganado($id_licitacion, $tipo)
    {
        $info = Licitacion::where('id', $id_licitacion)->first();
        if($tipo == 1){
            $notificacion ="El concurso No.".$info->no_licitacion." fue creado";
        }
        if($tipo == 2){
            $notificacion ="El concurso No".$info->no_licitacion." fue creado";    
        }


        $permiso = RolPermiso::where('permission_id', 141)->get();
        foreach ($permiso as $key => $value) {
           $users = User::where('role', $value->role_id)->get();
            foreach ($users as $user => $us) {
               $data = [
                'notificacion' => $notificacion,
                'fecha_notificacion' =>date('Y-m-d H:i:s'),
                'users_modifico' => auth()->user()->id,
                'modulo_id' => 2,
                'notificaciones_tipo_id' => $tipo,
                'notificacion_estatus' => 2,
                'users_permiso' => $us->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'licitaciones_id'=> $info->id
                ];
               $id_not =  Notificaciones::insert($data);
            }
        }
    }

    public function editarlicitacion($licitacion)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $info = Licitacion::find($licitacion);
        $documentos = DocumentoLicitacion::where('id_licitacion', $licitacion)->get();
        $publicacion = PublicacionLicitacion::where('status_delete', 0)->get();

        $tipo_documento = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();
        $cliente = Cliente::where('id_status_delete', 1)->get();
        $tipo_contratacion = TipoContratacion::where('id_status_delete', 1)->get();
        $licitacion_prioridad = LicitacionPrioridad::where('id_licitacion_prioridad_estatus', 1)->get();


        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach ($tipo_documento as $documento) {
            $cadenaTipoDocumento .= '"' . $documento->id . '":"' . $documento->documento_licitacion . '",';
        }

        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $permiso = RolPermiso::where('permission_id', 141)->get();
        foreach ($permiso as $key => $value) {
           $users = User::select('users.id', 'users.name', 'users.email', 'users.id_status_delete', 
            'rol.name as name_role', 'users.role', 'users.rfc', 'users.telefono', 'users.ubicacion',  'users.avatar')
            ->leftjoin("roles as rol","rol.id","users.role")->where('role', $value->role_id)->get();

        }   


   		return view('licitaciones.editar-licitaciones', compact('licitacion_prioridad','cadenaTipoDocumento','licitacion', 'info', 'tipo_documento', 'documentos', 'publicacion','cliente', 'tipo_contratacion', 'users', 'permiso_array'));
   	}

   	public function modificarlicitacion(Request $request)
   	{
        // dd($request);
	    $data = [
	        'titulo_servicio' => $request->titulo_servicio,
	        'observaciones' =>$request->observaciones,
	        'cliente' => $request->cliente,
	        'id_licitacion_prioridad' => $request->prioridad,
	        'contratacion' => $request->tipo_contratacion,
	        'no_licitacion' => $request->no_licitacion,
            'fecha_visita_aplica' => $request->fecha_visita_aplica,
            'fecha_visita' => $request->fecha_visita ? Carbon::now():null,
	        'junta_aclaraciones' => $request->junta_aclaraciones ? Carbon::now():null,
            'fecha_preguntas' => $request->fecha_preguntas ? Carbon::now():null,
	        'apertura_proposiciones' => $request->apertura_proposiciones ? Carbon::createFromFormat('d/m/Y', $request->apertura_proposiciones)->format('Y-m-d'):null,
	        'acto_fallo' => $request->acto_fallo ? Carbon::createFromFormat('d/m/Y', $request->acto_fallo)->format('Y-m-d'):null,
            'acto_fallo_info' => $request->acto_fallo_info ? Carbon::createFromFormat('d/m/Y', $request->acto_fallo_info)->format('Y-m-d'):null,
	        'participacion_conjunta' =>$request->participacion_conjunta,
	        'publicacion_licitacion' =>$request->publicacion_licitacion,
            'fecha_apertura_tecnica' => $request->fecha_apertura_tecnica ? Carbon::createFromFormat('d/m/Y', $request->fecha_apertura_tecnica)->format('Y-m-d'):null,
            'fecha_apertura_economica' => $request->fecha_apertura_economica ? Carbon::createFromFormat('d/m/Y', $request->fecha_apertura_economica)->format('Y-m-d'):null,
            'fecha_subasta_aplica' => $request->fecha_subasta_aplica,
            'fecha_subasta' => $request->fecha_subasta ? Carbon::createFromFormat('d/m/Y', $request->fecha_subasta)->format('Y-m-d'):null,
	        'firma_entrega' => $request->firma_entrega ? Carbon::createFromFormat('d/m/Y', $request->firma_entrega)->format('Y-m-d'):null,
            'fecha_entrega' => $request->fecha_entrega ? Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d'):null,
            'fecha_cierre' => $request->fecha_cierre ? Carbon::createFromFormat('d/m/Y', $request->fecha_cierre)->format('Y-m-d'):null,
            'modalidad' => $request->modalidad,
            'fecha_compra_bases' =>  $request->fecha_compra_bases ? Carbon::createFromFormat('d/m/Y', $request->fecha_compra_bases)->format('Y-m-d'):null,
            'fecha_entrega_propuestas' => $request->fecha_entrega_propuestas ? Carbon::now():null,
            'fecha_repreguntas_aplica' => $request->fecha_repreguntas_aplica,
            'fecha_repreguntas' => $request->fecha_repreguntas ? Carbon::createFromFormat('d/m/Y', $request->fecha_repreguntas)->format('Y-m-d'):null,
            'id_status_delete' => 1,
            'sector'=>$request->sector,
            'tipo_partida'=>$request->tipo_partida,
            'fecha_final_servicios' => $request->fecha_final_servicios ? Carbon::createFromFormat('d/m/Y', $request->fecha_final_servicios)->format('Y-m-d'):null,
            'numero_vehiculos'=>$request->numero_vehiculos,
            'tipo_contrato'=>$request->tipo_contrato,
	        'iduserUpdated' =>auth()->user()->id,
	        'updated_at' =>date('Y-m-d H:i:s')
	    ];

	    Licitacion::where('id', $request->id)->update($data);

        if($request->acto_fallo != null || $request->acto_fallo != "")
        {
            if (in_array("141", Session::get('permisos'))){
                $this->notificacionconcursoganado($request->id, 2);
            }
        }


        //inicio recepción de archivos
        $colIdDocumento = $request->id_documento;
        $licitacion = Licitacion::find($request->id);
        if ($request->hasfile('archivo')) {
            $archivos = $request->file('archivo');
            foreach ($archivos as $indice => $archivo) {
                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('licitacion/' . $licitacion->folio, $archivo, $archivoNombre);
                $data = [
                    'id_licitacion' => $licitacion->id,
                    'documento' => $archivoNombre,
                    'tipo_documento' => $colIdDocumento[$indice],
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                DocumentoLicitacion::insert($data);
            }
        }
        //fin recepción de archivos

        session()->flash('success', 'La licitación se modifico correctamente');
        return redirect()->route('licitacion.editarlicitacion', $request->id);
    }

    public function guardardocumentacion(Request $request)
    {
        $info = Licitacion::where('id', $request->id)->first();
        $doc = TipoDocumentoLicitacion::where('id', $request->id_documento)->first();

        $path = Storage::disk('public')->put('licitaciones/', $request->file('archivo'));
        $archivo_cer = $rest = substr($path, 12);

        $subido_cer = Storage::disk('public')->move('licitaciones/' . $archivo_cer, "licitaciones/" . $info->folio . '/' . $request->file('archivo')->getClientOriginalName());

        $data = [
            'id_licitacion' => $request->id,
            'documento' => $request->file('archivo')->getClientOriginalName(),
            'tipo_documento' => $doc->documento_licitacion,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        DocumentoLicitacion::insert($data);

        session()->flash('success', 'El documento se creo correctamente');
        return redirect()->route('licitacion.editarlicitacion', $request->id);
    }

    public function eliminardocumentacion(Request $request)
    {

        $doc = DocumentoLicitacion::find($request->id);
        $estatus = true;
        if ($doc) {
            $info = Licitacion::where('id', $doc->id_licitacion)->first();
            DocumentoLicitacion::where('id', $request->id)->delete();
            Storage::delete('licitacion/' . $info->folio . '/' . $doc->documento);
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }


    public function eliminarLicitacion(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo_desactivar' => $request->motivo,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')

        ];
        Licitacion::find($request->id)->update($data);


        session()->flash('success', 'El concurso se desactivo correctamente');
        return redirect()->route('licitacion.listadolicitaciones');

    }

    public function verlicitacion($licitacion)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);
        $info = Licitacion::findOrFail($licitacion);
        $documentos = DocumentoLicitacion::where('id_licitacion', $licitacion)->get();
        $publicacion = PublicacionLicitacion::where('status_delete', 1)->get();

        $tipo_documento = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();
        $cliente = Cliente::where('id_cliente', $info->cliente)->first();
        $tipo_contratacion = TipoContratacion::find($info->contratacion);

        if ($info->id_licitacion_estatus == 2) {
            $contrato = Proyecto::where('licitacion_id', $licitacion)->get();
            $op_contrato = 1;
        } else {
            $contrato = 0;
            $op_contrato = 0;
        }

        $proposicioneconomica = LicitacionSegmento::where("licitacion_id", $licitacion)->get();

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'licitacion_proposicion_economica.precio_unitario_maximo',
            'licitacion_proposicion_economica.cantidad_maxima',
            'licitacion_proposicion_economica.partida',
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
            ->where("licitacion_proposicion_economica.licitacion_id",$licitacion)
            ->get();


        return view('licitaciones.ver-licitaciones', compact('licitacion', 'info', 'tipo_documento', 'documentos', 'publicacion', 'cliente', 'tipo_contratacion', 'contrato', 'op_contrato', 'proposicioneconomica', 'segmento', 'permiso_array'));
    }

    public function catalogolicitacionesinactivas()
    {

      $licitaciones = Licitacion::select('licitaciones.id','licitaciones.folio', 'licitaciones.titulo_servicio' ,
          'licitaciones.empresa_dependencia', 'licitaciones.no_licitacion', 'licitaciones.fecha_visita',
          'licitaciones.junta_aclaraciones', 'licitaciones.apertura_proposiciones', 'licitaciones.acto_fallo',
          'licitaciones.participacion_conjunta', 'licitaciones.publicacion_licitacion', 'pl.publicacion_licitacion as publ',
          'licitaciones.cliente', 'cli.razon_social', 'licitaciones.id_licitacion_prioridad', 'tc.tipo_contratacion',
          'licitaciones.contratacion', 'licitaciones.motivo_desactivar')
          ->leftjoin("publicacion_licitacion as pl","pl.id","licitaciones.publicacion_licitacion")
          ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
          ->leftjoin("tipo_contratacion as tc", "tc.id", "licitaciones.contratacion")
          ->where("licitaciones.id_status_delete", 2)
          ->get();

      return view('licitaciones.listado-licitaciones-inactivas', compact('licitaciones'));
    }

    public function activarlicitacion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Licitacion::where('id', $request->id)->update($data);

        session()->flash('success', 'La licitación se activo correctamente');
        return redirect()->route('licitacion.catalogolicitacionesinactivas');
    }

    public function inventariounidad()
    {
        $ubicaciones = UbicacionUnidad::where('id_status_delete', 1)->get();
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $estatus = StatusUnidad::where('id_status_delete', 1)->get();
        $contratos = Proyecto::where('id_status_delete', 1)->get();

        return view('unidades.gerenciacomercial.unidades', compact('ubicaciones', 'marcas', 'modelos', 'estatus', 'contratos'));        
    }

    public function unidaddatatablecomercial(Request $request)
    {

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
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'pr.id_contrato'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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
                        'mu.nombre_marca',
                        'mou.nombre_modelo',
                        'uu.ubicacion',
                        'st.nombre_status',
                        'pr.id_contrato',
                        'pr.id_contrato'
                    )
                        ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                        ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                        ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                        ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                        ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
                        ->where("unidad.id_status_delete", 1)
                        ->where("unidad.proyectos_id", '=', $valor)
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
                'mu.nombre_marca',
                'mou.nombre_modelo',
                'uu.ubicacion',
                'st.nombre_status',
                'pr.id_contrato',
                'pr.id_contrato'
            )
                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
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

        return view('unidades.gerenciacomercial.ver-unidad-comercial', compact('unidad', 'ubicaciones', 'marcas', 'modelos', 'aseguradoras', 'estatus', 'complemento_unidad', 'fotosunidad', 'unidad_id', 'complemento_unidad_if', 'op_post', 'documentos', 'fotografias', 'ver', 'bitacora_unidad'));
    }

    public function informacionfinanzas($idlicitacion)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $proposicioneconomica = LicitacionSegmento::where("licitacion_id", $idlicitacion)->get();
        // dd($proposicioneconomica);

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'licitacion_proposicion_economica.precio_unitario_maximo',
            'licitacion_proposicion_economica.cantidad_maxima',
            'licitacion_proposicion_economica.partida',
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
            ->where("licitacion_proposicion_economica.licitacion_id", $idlicitacion)
            ->get();

        $count_segmento = count($segmento);

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion',
            'licitaciones.acto_fallo',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $idlicitacion)
            ->get();

        $licitacion_fianzas = LicitacionFianza::where('licitaciones_id', $idlicitacion)->get();

        $licitacion_segurosrc = LicitacionSeguroRC::where('licitaciones_id', $idlicitacion)->get();

        $documentos = Afianzadora::where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_afianzadora.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $tipo_fianzas = LicitacionTipoFianza::where('id_status_delete', 1)->get();
        //tipo de documentos en formato json
        $cadenaTipoFianza = "";
        foreach($tipo_fianzas as $documento){
            $cadenaTipoFianza .= '"'.$documento->id.'":"'.$documento->tipo_fianza.'",';
        }
        $cadenaTipoFianza = '{'.rtrim($cadenaTipoFianza, ',').'}';

        return view('licitaciones.informacion-fianzas', compact('segmento', 'licitacion', 'idlicitacion', 'count_segmento', 'proposicioneconomica', 'cadenaTipoDocumento', 'cadenaTipoFianza', 'licitacion_fianzas', 'licitacion_segurosrc', 'permiso_array'));

    }

    public function modificarinfofinanciera(Request $request)
    {
        $licitacion = Licitacion::where('id', $request->id_licitacion)->first();

        $colIdTipofianza= $request->tipo_fianza;
        $colIdAfianzadora = $request->nombre_fianza;
        $colVigenciaInicial = $request->vigencia_inicial;
        $colVigenciaFinal = $request->vigencia_final;
        $colPorcentaje = $request->porcentaje;

        if($request->hasfile('select_documento')){
            $archivos = $request->file('select_documento');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('licitacion/'.$licitacion->folio, $archivo, $archivoNombre);

                $data = [
                    'licitaciones_id' => $request->id_licitacion,
                    'tipo_fianza_id' => $colIdTipofianza[$indice],
                    'afianzadoras_id' => $colIdAfianzadora[$indice],
                    'vigencia_inicial' => $colVigenciaInicial[$indice] ? Carbon::createFromFormat('d/m/Y', $colVigenciaInicial[$indice])->format('Y-m-d'):null,
                    'vigencia_final' => $colVigenciaFinal[$indice] ? Carbon::createFromFormat('d/m/Y', $colVigenciaFinal[$indice])->format('Y-m-d'):null,
                    'documento' => $archivoNombre,
                    'porcentaje' => $colPorcentaje[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];

                LicitacionFianza::insert($data);
            }
        }

        $colIdAfianzadorarc = $request->nombre_fianzarc;
        $colVigenciaInicialrc = $request->vigencia_inicialrc;
        $colVigenciaFinalrc = $request->vigencia_finalrc;
        $colPorcentajerc = $request->porcentajerc;
        if($request->hasfile('select_documentorc')){
            $archivos = $request->file('select_documentorc');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('licitacion/'.$licitacion->folio, $archivo, $archivoNombre);

                $data = [
                    'licitaciones_id' => $request->id_licitacion,
                    'afianzadoras_id' => $colIdAfianzadorarc[$indice],
                    'vigencia_inicialrc' => $colVigenciaInicialrc[$indice] ? Carbon::createFromFormat('d/m/Y', $colVigenciaInicialrc[$indice])->format('Y-m-d'):null,
                    'vigencia_finalrc' => $colVigenciaFinalrc[$indice] ? Carbon::createFromFormat('d/m/Y', $colVigenciaFinalrc[$indice])->format('Y-m-d'):null,
                    'documento_rc' => $archivoNombre,
                    'porcentajerc' => $colPorcentajerc[$indice],
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                LicitacionSeguroRC::insert($data);
            }
        }

        session()->flash('success', 'La información se guardo correctamente');
        return redirect()->route('licitacion.informacionfinanzas', $request->id_licitacion );
    }

    public function eliminarinfofinanciera(Request $request)
    {
        $doc = LicitacionFianza::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            // Storage::delete('cliente/'.$doc->id_cliente.'/'.$doc->documento);
            LicitacionFianza::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    public function eliminarinfosegurorc(Request $request)
    {
        $doc = LicitacionSeguroRC::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            // Storage::delete('cliente/'.$doc->id_cliente.'/'.$doc->documento);
            LicitacionSeguroRC::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);       
    }

    public function verlicitacionPDF($licitacion)
    {

        $info = Licitacion::findOrFail($licitacion);
        $documentos = DocumentoLicitacion::where('id_licitacion', $licitacion)->get();
        $publicacion = PublicacionLicitacion::where('status_delete', 1)->get();

        $tipo_documento = TipoDocumentoLicitacion::where('id_status_delete', 1)->get();
        $cliente = Cliente::where('id_cliente', $info->cliente)->first();
        $tipo_contratacion = TipoContratacion::find($info->contratacion);

        if ($info->id_licitacion_estatus == 2) {
            $contrato = Proyecto::where('licitacion_id', $licitacion)->get();
            $op_contrato = 1;
        } else {
            $contrato = 0;
            $op_contrato = 0;
        }

        $proposicioneconomica = LicitacionSegmento::where("licitacion_id", $licitacion)->get();

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
        
        $header = view('licitaciones.ver-licitaciones-pdf-header', compact('info'))->render();
        $footer = view('licitaciones.ver-licitaciones-pdf-footer')->render();
        $body = view('licitaciones.ver-licitaciones-pdf-body', compact('info','cliente', 'tipo_contratacion', 'publicacion','segmento'))->render();

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
