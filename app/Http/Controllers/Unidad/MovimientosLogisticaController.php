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

use App\Models\Translados\Translados;
use App\Models\Translados\TransladosUnidad;
use App\Models\Translados\TrasladoInventarioEntrega;
use App\Models\Translados\TransladosInventarioEntregaCliente;
use App\Models\Translados\TrasladoUnidadDocumento;
use App\Imports\TransladosUnidadesImport;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;

use App\Models\Logistica\SustitutoSolicitud;
use App\Models\Logistica\AsignacionLogistica;

use App\Models\Unidad\TramiteEmplacamientoInfo;
use App\Models\Unidad\TramiteTenenciaInfo;
use App\Models\Unidad\TramiteVerificacionInfo;

use App\Models\Licitacion\Licitacion;
use App\Models\Logistica\SustitutoMotivo;
use App\Models\Logistica\SustitutoEvidencia;


class MovimientosLogisticaController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }

    public function listadomovimientos()
    {
		$unidad = Translados::where('id_status_delete', 1)->get();

    	return view('unidades.movimientos.listado-movimientos', compact('unidad'));
    }

    public function solicitudmovimiento()
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();
        $users = User::select('users.id', 'users.name', 'users.email', 'users.id_status_delete', 'rol.name as name_role', 'users.role', 'users.rfc', 'users.telefono', 'users.ubicacion', 'users.avatar')->leftjoin("roles as rol","rol.id","users.role")->where('role', 16)->get();
        // dd($users);
        $sustituto = SustitutoSolicitud::select('sustituto_solicitud.id', 'sustituto_solicitud.fecha_hora_solicitud', 'sustituto_solicitud.motivo_id', 'sustituto_solicitud.unidad_id_base',
            'sustituto_solicitud.proyectos_id', 'sustituto_solicitud.nombre_responsable', 'sustituto_solicitud.estado_id', 'sustituto_solicitud.municipio_id',
            'es.estado_nombre', 'mu.municipio_nombre', 'sm.motivo','unid.no_serie', 'pro.no_contrato', 'sustituto_solicitud.estatus', 'sustituto_solicitud.op_traslado')
            ->leftjoin("estado as es","es.id_estado","sustituto_solicitud.estado_id")
            ->leftjoin("municipio as mu", "mu.id_municipio", "sustituto_solicitud.municipio_id")
            ->leftjoin("sustituto_motivo as sm", "sm.id", "sustituto_solicitud.motivo_id")
            ->leftjoin("unidad as unid", "unid.id", "sustituto_solicitud.unidad_id_base")
            ->leftjoin("proyectos as pro", "pro.id", "sustituto_solicitud.proyectos_id")
            ->where('sustituto_solicitud.id_status_delete', 1)
            ->where('sustituto_solicitud.estatus', 4)
            ->where('sustituto_solicitud.op_traslado', 0)
            ->get();
        
        $asignacionLogistica = AsignacionLogistica::where('id_status_delete', 1)->where('op_traslado', 0)->get();
        // dd($asignacionLogistica);

        return view('unidades.movimientos.nueva-solicitud-movimientos', compact('estados', 'ubicacion', 'users', 'sustituto', 'asignacionLogistica'));       
    }

    public function asignarunidades()
    {
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        return view('unidades.movimientos.asignar-unidades-movimiento', compact('ubicacion')); 
    }

    public function unidadestranslados(Request $request)
    {
        
        if($request->op_solicitud == 1){
            $asignacion_id = $request->id_asignacion;
            $sustituta = null;

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
            ->where('atu.id_asignacion', $request->id_asignacion)
            ->get();

        }else{
            $asignacion_id = null;
            $sustituta = $request->id_sustituta;
            $solicitud_sustituto = SustitutoSolicitud::where('id', $request->id_sustituta)->first();
            $unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
            $unidad_base = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
            // dd($unidad_sustituta);
        }

        
        $data = [
            'nombre_translado' => $request->titulo_translado,
            'observaciones' => $request->observaciones,
            'estatus_id' => 0,
            'op_solicitud' => $request->op_solicitud,
            'id_status_delete' => 1,
            'asignacion_solicitud_id' => $asignacion_id,
            'sustituto_solicitud_id' => $sustituta,
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        $traslado_id = Translados::insertGetId($data);
        // dd($unidades_seleccionadas);

        if($request->op_solicitud == 1){
            foreach($unidades_seleccionadas as $indice => $unidad)
            {
                $data = [
                    'translados_id' => $traslado_id,
                    'unidad_id' => $unidad->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                TransladosUnidad::insert($data);  

            }

        }else{

                $data = [
                    'translados_id' => $traslado_id,
                    'unidad_id' => $unidad_base->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                TransladosUnidad::insert($data); 

                //end unidad base

                $data = [
                    'translados_id' => $traslado_id,
                    'unidad_id' => $unidad_sustituta->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                TransladosUnidad::insert($data); 
                //end unidad sustituta
        }


        // Excel::import(new TransladosUnidadesImport,request()->file('file_carga'));

        session()->flash('success', 'El translado se creo correctamente');
        return redirect()->route('movimientoslog.listadomovimientos');
    }

    public function editarsolicitud($id_translado)
    {
        $solicitud = Translados::where('id', $id_translado)->first();
        $tipo_solicitud = $solicitud->op_solicitud;
        if($tipo_solicitud == 1){
            $sol_asignacion = AsignacionLogistica::where('id', $solicitud->asignacion_solicitud_id)->first();

            $unidades_seleccionadas = Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $sol_asignacion->id)->get();
            // dd($unidades_seleccionadas);

            $solicitud_sustituto = [];
            $unidad = ""; $fotografias=""; $active = ""; $ver =""; $proyecto_info = 1; $info_licitacion= 1; $sustituto = "";
            $ubicacion_data = ""; $unidad_sustituta = 0; $fotografias_sustitutas = 0; $active_s = 0;  $ver_s=0;
        }else{
            
            $sol_asignacion = [];
            $unidades_seleccionadas="";

            $solicitud_sustituto = SustitutoSolicitud::where('id', $solicitud->sustituto_solicitud_id)->first();
            $unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
            $fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
            // dd($unidad);
            if ($active == null) {
                    $ver = 0;
            } else {
                    $ver = $active->id;
            }

            if($unidad->unidad_asignacion_id == 1){
                $proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
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
                    ->where('licitaciones.id', $unidad->licitaciones_id)
                    ->get();

            }else{
                $proyecto_info = 1;
                $info_licitacion= 1;
            }

            $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
            $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();

            $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

            $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
                'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
                'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
                // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
                ->where('unidad.unidad_asignacion_id', 2)
                ->where('unidad.apartado_sustituto', 0) 
                ->where('unidad.id_status_delete', 1)->get();  

            if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
            {
                $unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
                $fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
                $active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
                
                if ($active_s == null) {
                        $ver_s = 0;
                } else {
                        $ver_s = $active->id;
                }
            }else{
                $unidad_sustituta = 0;
                $fotografias_sustitutas = 0;
                $active_s = 0;
                $ver_s=0;
            }  



        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();


        return view('unidades.movimientos.editar-movimientos', compact( 'solicitud', 'id_translado', 'sol_asignacion', 'solicitud_sustituto', 'tipo_solicitud', 'estados', 'municipios', 'solicitud_sustituto', 'unidad', 'fotografias', 'active', 'ver', 'proyecto_info', 'info_licitacion', 'sustituto', 'ubicacion_data', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s', 'unidades_seleccionadas'));
    }

    public function edittrasladoinfo(Request $request)
    {
        $data = [
            'nombre_translado' => $request->titulo_translado,
            'observaciones' => $request->observaciones,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Translados::where('id', $request->id_traslado)->update($data);

        session()->flash('success', 'El translado se edito correctamente');
        return redirect()->route('movimientoslog.editarsolicitud', $request->id_traslado);
    }

    public function versolicitud($id_translado)
    {
        $solicitud = Translados::where('id', $id_translado)->first();
        $tipo_solicitud = $solicitud->op_solicitud;
        if($tipo_solicitud == 1){
            $sol_asignacion = AsignacionLogistica::where('id', $solicitud->asignacion_solicitud_id)->first();

            $unidades_seleccionadas = Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $sol_asignacion->id)->get();
            // dd($unidades_seleccionadas);

            $solicitud_sustituto = [];
            $unidad = ""; $fotografias=""; $active = ""; $ver =""; $proyecto_info = 1; $info_licitacion= 1; $sustituto = "";
            $ubicacion_data = ""; $unidad_sustituta = 0; $fotografias_sustitutas = 0; $active_s = 0;  $ver_s=0;
        }else{
            
            $sol_asignacion = [];
            $unidades_seleccionadas="";

            $solicitud_sustituto = SustitutoSolicitud::where('id', $solicitud->sustituto_solicitud_id)->first();
            $unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
            $fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
            // dd($unidad);
            if ($active == null) {
                    $ver = 0;
            } else {
                    $ver = $active->id;
            }

            if($unidad->unidad_asignacion_id == 1){
                $proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
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
                    ->where('licitaciones.id', $unidad->licitaciones_id)
                    ->get();

            }else{
                $proyecto_info = 1;
                $info_licitacion= 1;
            }

            $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
            $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();

            $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

            $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
                'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
                'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
                // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
                ->where('unidad.unidad_asignacion_id', 2)
                ->where('unidad.apartado_sustituto', 0) 
                ->where('unidad.id_status_delete', 1)->get();  

            if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
            {
                $unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
                $fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
                $active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
                
                if ($active_s == null) {
                        $ver_s = 0;
                } else {
                        $ver_s = $active->id;
                }
            }else{
                $unidad_sustituta = 0;
                $fotografias_sustitutas = 0;
                $active_s = 0;
                $ver_s=0;
            }  

        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        return view('unidades.movimientos.ver-movimientos', compact('solicitud', 'id_translado', 'sol_asignacion', 'solicitud_sustituto', 'tipo_solicitud', 'estados', 'municipios', 'solicitud_sustituto', 'unidad', 'fotografias', 'active', 'ver', 'proyecto_info', 'info_licitacion', 'sustituto', 'ubicacion_data', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s', 'unidades_seleccionadas'));        
    }

    public function verinfounidadtraslado($id_translado, $id_unidad)
    {
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $unidad_info = Unidad::find($id_unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $emplcamiento = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->get();
        $tenencia = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        $verificacion = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        
        $translados_unidad = TransladosUnidad::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();

        $solicitud = Translados::where('id', $id_translado)->first();

        $trasladistas = User::where('role', 16)->get();
        $documentos = TrasladoUnidadDocumento::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->get();

        $inventario_entrega = TrasladoInventarioEntrega::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();
        $inventario_cliente = TransladosInventarioEntregaCliente::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();

        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();
       // dd($inventario_cliente);
        return view('unidades.movimientos.ver-unidad-movimientos', compact('fotografias', 'unidad_info', 'marcas', 'modelos', 'active', 'ver', 'estados', 'id_translado', 'emplcamiento', 'tenencia', 'verificacion', 'translados_unidad', 'solicitud', 'trasladistas', 'id_unidad', 'documentos', 'inventario_entrega', 'inventario_cliente', 'ubicacion'));
    }

    public function unidadestransladoinfo($id_translado, $id_unidad)
    {
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $unidad_info = Unidad::find($id_unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $emplcamiento = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->get();
        $tenencia = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        $verificacion = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        
        $translados_unidad = TransladosUnidad::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();
        $solicitud_id = $translados_unidad->id;

        $trasladistas = User::where('role', 16)->get();
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();
        // dd($ubicacion);
       
        return view('unidades.movimientos.unidades-editar-movimientos', compact('fotografias', 'unidad_info', 'marcas', 'modelos', 'active', 'ver', 'estados', 'id_translado', 'emplcamiento', 'tenencia', 'verificacion', 'translados_unidad', 'id_unidad', 'solicitud_id', 'trasladistas', 'ubicacion'));

    }


    public function eliminarunidad(Request $request)
    {
        // dd($request);
        $data = TransladosUnidad::where('translados_id', $request->translado)->where('unidad_id', $request->id)->delete();


        session()->flash('success', 'La unidad se elimino correctamente');
        return redirect()->route('movimientoslog.editarsolicitud', $request->translado);

    }

    public function editunidtraslado(Request $request)
    {
        // dd($request);
        $data = [
            'tipo_asignacion' => $request->tipo_asignacion,
            'fecha_translado' => $request->fecha_translado,
            'id_transportista' => $request->id_transportista,
            'requerimiento' => $request->requerimiento,
            'transladadora' => $request->transladadora,
            'origen' => $request->origen,
            'recoleccion' => $request->recoleccion,
            'cto_origen' => $request->cto_origen,
            'destino' => $request->destino,
            'cto_destino' => $request->cto_destino,
            'observaciones' => $request->observaciones,
            'estatus' => $request->estatus,
            'ubicacion_unidad_id' => $request->id_ubicacion,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        TransladosUnidad::where('id', $request->solicitud_id)->update($data);

        $exist_inventario = TrasladoInventarioEntrega::where('translados_id', $request->id_traslado)->where('translados_unidad_id', $request->solicitud_id)->where('unidad_id', $request->id_unidad)->first();
        
        if($exist_inventario == null)
        {
            $data = [
                'translados_id' => $request->id_traslado,
                'translados_unidad_id' => $request->solicitud_id,
                'unidad_id' => $request->id_unidad,
                'poliza_seguros' => 1,
                'manual' => 1,
                'lugar' => 1,
                'no_tarjeta_circulacion' => 1,
                'verificacion_ambiental' => 1,
                'kilometraje' => 1,
                'tenencia' => 1,
                'poliza_de_garantia' => 1,
                'aire_acondicionado' => 1,
                'llanta_refaccion' => 1,
                'tapon_aceite' => 1,
                'calefaccion' => 1,
                'gato' => 1,
                'tapon_agua' => 1,
                'radio' => 1,
                'llave_auxiliar' => 1,
                'tapon_gasolina' => 1,
                'antena' => 1,
                'herramienta' => 1,
                'defensa_lateral' => 1,
                'encendedor' => 1,
                'extinguidor' => 1,
                'defensa_trasera' => 1,
                'ceniceros' => 1,
                'calaveras' => 1,
                'tapetes' => 1,
                'manijas' => 1,
                'parabrisas' => 1,
                'viceras'  => 1,
                'elevadores' => 1,
                'medallon' => 1,
                'biseles' => 1,
                'espejo_retrovisor' => 1,
                'brazos_limpiadores' => 1,
                'cuartos' => 1,
                'claxon' => 1,
                'espejos_laterales' => 1,
                'stop' => 1,
                'tapones_llantas' => 1,
                'senales_carretera' => 1,
                'duplicado_llaves' => 1,
                'reflejantes' => 1,
                'cables_corriente' => 1,
                'acumulador'  => 1,
                'marca_llantas' => "",
                'llanta_delantera_derecha' => 1,
                'llanta_delantera_izquierda' => 1,
                'llanta_trasera_derecha' => 1,
                'llanta_trasera_izquierda' => 1,
                'llantar_refaccion' => 1,
                'nivel_combustible' => "",
                'observaciones' => "",
                'op_inventario' => 0,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
            ];
            TrasladoInventarioEntrega::insert($data);
        }
        

        session()->flash('success', 'La información se modifico correctamente');
        return redirect()->route('movimientoslog.unidadestranslado', [$request->id_traslado, $request->id_unidad]);
    }


    public function enviarsolicitud(Request $request)
    {

        $data = [
            'estatus_id' => 1,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s'),
            'envio_transladista'=>date('Y-m-d H:i:s'),
        ];


        Translados::where('id', $request->id)->update($data);

        session()->flash('success', 'La solicitud se envio correctamente');
        return redirect()->route('movimientoslog.listadomovimientos');        
    }

    public function updateuniddestino(Request $request)
    {
        dd($request);

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

    }


    // T R A N S L A D I S T A
    public function listadomovimientostransladistas()
    {
        $unidad = Translados::where('id_status_delete', 1)->where('estatus_id', 1)->get();

        return view('unidades.movimientos.transladistas.transladista-listado-movimientos', compact('unidad'));        
    }

    public function versolicitudtransladista($id_translado)
    {
        $solicitud = Translados::where('id', $id_translado)->first();
        $tipo_solicitud = $solicitud->op_solicitud;
        if($tipo_solicitud == 1){
            $sol_asignacion = AsignacionLogistica::where('id', $solicitud->asignacion_solicitud_id)->first();

            $unidades_seleccionadas = Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $sol_asignacion->id)->get();
            // dd($unidades_seleccionadas);

            $solicitud_sustituto = [];
            $unidad = ""; $fotografias=""; $active = ""; $ver =""; $proyecto_info = 1; $info_licitacion= 1; $sustituto = "";
            $ubicacion_data = ""; $unidad_sustituta = 0; $fotografias_sustitutas = 0; $active_s = 0;  $ver_s=0;
        }else{
            
            $sol_asignacion = [];
            $unidades_seleccionadas="";

            $solicitud_sustituto = SustitutoSolicitud::where('id', $solicitud->sustituto_solicitud_id)->first();
            $unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
            $fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
            // dd($unidad);
            if ($active == null) {
                    $ver = 0;
            } else {
                    $ver = $active->id;
            }

            if($unidad->unidad_asignacion_id == 1){
                $proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
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
                    ->where('licitaciones.id', $unidad->licitaciones_id)
                    ->get();

            }else{
                $proyecto_info = 1;
                $info_licitacion= 1;
            }

            $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
            $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();

            $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

            $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
                'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
                'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
                // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
                ->where('unidad.unidad_asignacion_id', 2)
                ->where('unidad.apartado_sustituto', 0) 
                ->where('unidad.id_status_delete', 1)->get();  

            if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
            {
                $unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
                $fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
                $active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
                
                if ($active_s == null) {
                        $ver_s = 0;
                } else {
                        $ver_s = $active->id;
                }
            }else{
                $unidad_sustituta = 0;
                $fotografias_sustitutas = 0;
                $active_s = 0;
                $ver_s=0;
            }  

        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
            

        return view('unidades.movimientos.transladistas.ver-solicitud-translados', compact('solicitud', 'id_translado', 'sol_asignacion', 'solicitud_sustituto', 'tipo_solicitud', 'estados', 'municipios', 'solicitud_sustituto', 'unidad', 'fotografias', 'active', 'ver', 'proyecto_info', 'info_licitacion', 'sustituto', 'ubicacion_data', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s', 'unidades_seleccionadas'));
    }

    public function inventarioentrega($id_translado, $id_unidad)
    {
        // dd($id_translado);
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $unidad_info = Unidad::find($id_unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $emplcamiento = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->get();
        $tenencia = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        $verificacion = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        
        $translados_unidad = TransladosUnidad::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();

        $solicitud = Translados::where('id', $id_translado)->first();

        $trasladistas = User::where('role', 16)->get();
        $documentos = TrasladoUnidadDocumento::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->get();

        $inventario_entrega = TrasladoInventarioEntrega::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        return view('unidades.movimientos.transladistas.unidades-solicitud-translados', compact('fotografias', 'unidad_info', 'marcas', 'modelos', 'active', 'ver', 'estados', 'id_translado', 'emplcamiento', 'tenencia', 'verificacion', 'translados_unidad', 'solicitud', 'trasladistas', 'id_unidad', 'documentos', 'inventario_entrega', 'ubicacion'));        
    }

    public function guardardocumentounidad(Request $request)
    {
        // dd($request);
        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Traslado/'.$request->id_traslado, $archivo, $archivoNombre);
                $data = [
                    'translados_id' => $request->id_traslado,
                    'unidad_id' => $request->id_unidad,
                    'nombre' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TrasladoUnidadDocumento::insert($data);
            }
        }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('transladistassol.inventarioentrega', [$request->id_traslado,$request->id_unidad]);         

    }

    public function eliminardocumentotraslado(Request $request)
    {
        $doc = TrasladoUnidadDocumento::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('Traslado/'.$doc->translados_id.'/'.$doc->documento);
            TrasladoUnidadDocumento::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);        
    }

    public function editinventrega(Request $request)
    {
        
        $inventario_entrega = TrasladoInventarioEntrega::where('translados_id', $request->id_traslado)->where('unidad_id', $request->id_unidad)->first();
        // dd($inventario_entrega);
            $data = [
                'poliza_seguros' => $request->poliza_seguro,
                'manual' => $request->manual,
                'lugar' => $request->lugar,
                'no_tarjeta_circulacion' => $request->tarjeta_circulacion,
                'verificacion_ambiental' => $request->verificacion_ambiental,
                'kilometraje' => $request->kilometraje,
                'tenencia' => $request->tenencia,
                'poliza_de_garantia' => $request->poliza_garantia,
                'aire_acondicionado' => $request->aire_acondicionado,
                'llanta_refaccion' => $request->llanta_refaccion,
                'tapon_aceite' => $request->tapon_aceite,
                'calefaccion' => $request->calefaccion,
                'gato' => $request->gato,
                'tapon_agua' => $request->tapon_agua,
                'radio' => $request->radio,
                'llave_auxiliar' => $request->llave_auxiliar,
                'tapon_gasolina' => $request->tapon_gasolina,
                'antena' => $request->antena,
                'herramienta' => $request->herramienta,
                'defensa_lateral' => $request->defensa_lateral,
                'encendedor' => $request->encendedor,
                'extinguidor' => $request->extinguidor,
                'defensa_trasera' => $request->defensa_trasera,
                'ceniceros' => $request->ceniceros,
                'calaveras' => $request->calaveras,
                'tapetes' => $request->tapetes,
                'manijas' => $request->manijas,
                'parabrisas' => $request->parabrisas,
                'viceras'  => $request->viceras,
                'elevadores' => $request->elevadores,
                'medallon' => $request->medallon,
                'biseles' => $request->biseles,
                'espejo_retrovisor' => $request->espejo_retrovisor,
                'brazos_limpiadores' => $request->brazos_limpiadores,
                'cuartos' => $request->cuartos,
                'claxon' => $request->claxon,
                'espejos_laterales' => $request->espejos_laterales,
                'stop' => $request->stop,
                'tapones_llantas' => $request->tapones_llantas,
                'senales_carretera' => $request->senales_carretera,
                'duplicado_llaves' => $request->duplicado_llaves,
                'reflejantes' => $request->reflejantes,
                'cables_corriente' => $request->cables_corriente,
                'acumulador'  => $request->acumulador,
                'marca_llantas' => $request->marca_llantas,
                'llanta_delantera_derecha' => $request->llanta_delantera_derecha,
                'llanta_delantera_izquierda' => $request->llanta_delantera_izquierda,
                'llanta_trasera_derecha' => $request->llanta_trasera_derecha,
                'llanta_trasera_izquierda' => $request->llanta_trasera_izquierda,
                'llantar_refaccion' => $request->llantar_refaccion,
                'nivel_combustible' => $request->nivel_combustible,
                'observaciones' => "",
                'updated_at' =>date('Y-m-d H:i:s'),
                'iduserUpdated' =>auth()->user()->id,
            ];
            // dd($data);
            TrasladoInventarioEntrega::where('id', $inventario_entrega->id)->update($data);

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('transladistassol.inventarioentrega', [$request->id_traslado,$request->id_unidad]);   

    }

    public function enviarsolicitudoperador(Request $request)
    {
        $data = [
            'estatus_id' => 2,
            'envio_operador'=>date('Y-m-d H:i:s'),
        ];


        Translados::where('id', $request->id)->update($data);

        session()->flash('success', 'La solicitud se envio correctamente');
        return redirect()->route('transladistassol.listadomovimientostransladistas');          
    }


    //  O P E R A D O R
    public function listadotransladooperador()
    {
        $unidad = Translados::where('id_status_delete', 1)->where('estatus_id', 2)->get();

        return view('unidades.movimientos.operador.operador-listado-movimientos', compact('unidad')); 
    }

    public function unidadestrasladooper($id_translado)
    {
        $solicitud = Translados::where('id', $id_translado)->first();
        $tipo_solicitud = $solicitud->op_solicitud;
        if($tipo_solicitud == 1){
            $sol_asignacion = AsignacionLogistica::where('id', $solicitud->asignacion_solicitud_id)->first();

            $unidades_seleccionadas = Unidad::select('unidad.id','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
            'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
            'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion', 'atu.id_asignacion', 'atu.fecha_asignacion', 'usr.name', 'unidad.op_unidad_nueva', 'atu.op_asignacion' , 'atu.id_patio' , 'atu.id_requisicion', 'req.folio as folioreq', 'unidad.numero_economico')

            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
            ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
            ->leftjoin("requisicion as req", "req.id", '=', "atu.id_requisicion")
            ->where('atu.id_asignacion', $sol_asignacion->id)->get();
            // dd($unidades_seleccionadas);

            $solicitud_sustituto = [];
            $unidad = ""; $fotografias=""; $active = ""; $ver =""; $proyecto_info = 1; $info_licitacion= 1; $sustituto = "";
            $ubicacion_data = ""; $unidad_sustituta = 0; $fotografias_sustitutas = 0; $active_s = 0;  $ver_s=0;
        }else{
            
            $sol_asignacion = [];
            $unidades_seleccionadas="";

            $solicitud_sustituto = SustitutoSolicitud::where('id', $solicitud->sustituto_solicitud_id)->first();
            $unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
            $fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
            $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
            // dd($unidad);
            if ($active == null) {
                    $ver = 0;
            } else {
                    $ver = $active->id;
            }

            if($unidad->unidad_asignacion_id == 1){
                $proyecto_info = Proyecto::where('id', $unidad->proyectos_id)->first();
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
                    ->where('licitaciones.id', $unidad->licitaciones_id)
                    ->get();

            }else{
                $proyecto_info = 1;
                $info_licitacion= 1;
            }

            $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
            $municipios = DB::table('municipio')
            ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
            ->where('municipio.id_status_delete', 1)
            ->get();

            $sustituto = SustitutoMotivo::where('id_status_delete', 1)->get();

            $ubicacion_data = Unidad::select('unidad.id','unidad.folio','unidad.id_ubicacion','unidad.fecha','unidad.id_marca','unidad.id_modelo','unidad.unidad_year','unidad.no_serie','unidad.placa',
                'unidad.transmision','unidad.no_tarjeta_circulacion','unidad.no_poliza_seguro','unidad.fecha_vencimiento_poliza','unidad.numero_inventario','unidad.color','unidad.id_status',
                'mu.nombre_marca','mou.nombre_modelo','uu.ubicacion','st.nombre_status', 'unidad.licitaciones_id', 'unidad.fecha_asignacion',  'unidad.op_unidad_nueva', 'unidad.numero_economico' ,'uu.codigo')

                ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
                ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
                ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
                ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
                // ->leftjoin("asignacion_total_unidades as atu", "atu.unidad_id", '=', "unidad.id")
                // ->leftjoin("users as usr", "usr.id", '=', "atu.iduserCreated")
                ->where('unidad.unidad_asignacion_id', 2)
                ->where('unidad.apartado_sustituto', 0) 
                ->where('unidad.id_status_delete', 1)->get();  

            if($solicitud_sustituto->estatus == 3 || $solicitud_sustituto->estatus == 4)
            {
                $unidad_sustituta = Unidad::where('id', $solicitud_sustituto->unidad_id_sustituta)->first();
                $fotografias_sustitutas = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_sustituta)->get();
                $active_s = UnidadFotografia::where('unidad_id', $unidad_sustituta->id)->first();
                
                if ($active_s == null) {
                        $ver_s = 0;
                } else {
                        $ver_s = $active->id;
                }
            }else{
                $unidad_sustituta = 0;
                $fotografias_sustitutas = 0;
                $active_s = 0;
                $ver_s=0;
            }  

        }

        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();
            
        // dd($fotografias); 
        return view('unidades.movimientos.operador.unidades-translado-operador', compact('solicitud', 'id_translado', 'sol_asignacion', 'solicitud_sustituto', 'tipo_solicitud', 'estados', 'municipios', 'solicitud_sustituto', 'unidad', 'fotografias', 'active', 'ver', 'proyecto_info', 'info_licitacion', 'sustituto', 'ubicacion_data', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s', 'unidades_seleccionadas'));       
    }

    public function inventarioentregaoperador($id_translado, $id_unidad)
    {
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $unidad_info = Unidad::find($id_unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $emplcamiento = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->get();
        $tenencia = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        $verificacion = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        
        $translados_unidad = TransladosUnidad::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();

        $solicitud = Translados::where('id', $id_translado)->first();

        $trasladistas = User::where('role', 16)->get();
        $documentos = TrasladoUnidadDocumento::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->get();

        $inventario_entrega = TrasladoInventarioEntrega::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();
        $inventario_cliente = TransladosInventarioEntregaCliente::where('translados_id', $id_translado)->where('unidad_id', $id_unidad)->first();
        // dd($inventario_cliente);
        $ubicacion = UbicacionUnidad::where('id_status_delete', 1)->get();

        return view('unidades.movimientos.operador.inventario-entrega-translados', compact('fotografias', 'unidad_info', 'marcas', 'modelos', 'active', 'ver', 'estados', 'id_translado', 'emplcamiento', 'tenencia', 'verificacion', 'translados_unidad', 'solicitud', 'trasladistas', 'id_unidad', 'documentos', 'inventario_entrega', 'inventario_cliente', 'ubicacion'));          
    }

    public function editinventregacliente(Request $request)
    {
        $inventario_entrega = TransladosInventarioEntregaCliente::where('translados_id', $request->id_traslado)->where('unidad_id', $request->id_unidad)->first();
            $data = [
                'translados_id'=> $request->id_traslado,
                'unidad_id'=> $request->id_unidad,
                'translados_unidad_id'=> $request->translados_unidad_id,
                'poliza_seguros' => $request->poliza_seguro,
                'manual' => $request->manual,
                'lugar' => $request->lugar,
                'no_tarjeta_circulacion' => $request->tarjeta_circulacion,
                'verificacion_ambiental' => $request->verificacion_ambiental,
                'kilometraje' => $request->kilometraje,
                'tenencia' => $request->tenencia,
                'poliza_de_garantia' => $request->poliza_garantia,
                'aire_acondicionado' => $request->aire_acondicionado,
                'llanta_refaccion' => $request->llanta_refaccion,
                'tapon_aceite' => $request->tapon_aceite,
                'calefaccion' => $request->calefaccion,
                'gato' => $request->gato,
                'tapon_agua' => $request->tapon_agua,
                'radio' => $request->radio,
                'llave_auxiliar' => $request->llave_auxiliar,
                'tapon_gasolina' => $request->tapon_gasolina,
                'antena' => $request->antena,
                'herramienta' => $request->herramienta,
                'defensa_lateral' => $request->defensa_lateral,
                'encendedor' => $request->encendedor,
                'extinguidor' => $request->extinguidor,
                'defensa_trasera' => $request->defensa_trasera,
                'ceniceros' => $request->ceniceros,
                'calaveras' => $request->calaveras,
                'tapetes' => $request->tapetes,
                'manijas' => $request->manijas,
                'parabrisas' => $request->parabrisas,
                'viceras'  => $request->viceras,
                'elevadores' => $request->elevadores,
                'medallon' => $request->medallon,
                'biseles' => $request->biseles,
                'espejo_retrovisor' => $request->espejo_retrovisor,
                'brazos_limpiadores' => $request->brazos_limpiadores,
                'cuartos' => $request->cuartos,
                'claxon' => $request->claxon,
                'espejos_laterales' => $request->espejos_laterales,
                'stop' => $request->stop,
                'tapones_llantas' => $request->tapones_llantas,
                'senales_carretera' => $request->senales_carretera,
                'duplicado_llaves' => $request->duplicado_llaves,
                'reflejantes' => $request->reflejantes,
                'cables_corriente' => $request->cables_corriente,
                'acumulador'  => $request->acumulador,
                'marca_llantas' => $request->marca_llantas,
                'llanta_delantera_derecha' => $request->llanta_delantera_derecha,
                'llanta_delantera_izquierda' => $request->llanta_delantera_izquierda,
                'llanta_trasera_derecha' => $request->llanta_trasera_derecha,
                'llanta_trasera_izquierda' => $request->llanta_trasera_izquierda,
                'llantar_refaccion' => $request->llantar_refaccion,
                'nivel_combustible' => $request->nivel_combustible,
                'observaciones' => "",
                'updated_at' =>date('Y-m-d H:i:s'),
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'iduserCreated' =>auth()->user()->id,
            ];

            if($inventario_entrega == null){
                TransladosInventarioEntregaCliente::insert($data);  
            }else{
                TransladosInventarioEntregaCliente::where('id', $inventario_entrega->id)->update($data);
            }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('transladooperador.inventarioentregaoperador', [$request->id_traslado,$request->id_unidad]);          
    }

    public function guardardocumentounidadcliente(Request $request)
    {
        // dd($request);
        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Traslado/'.$request->id_traslado, $archivo, $archivoNombre);
                $data = [
                    'translados_id' => $request->id_traslado,
                    'unidad_id' => $request->id_unidad,
                    'nombre' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id
                ];
                TrasladoUnidadDocumento::insert($data);
            }
        }

        session()->flash('success', 'La información se agrego correctamente');
        return redirect()->route('transladooperador.inventarioentregaoperador', [$request->id_traslado,$request->id_unidad]);          
    }

}