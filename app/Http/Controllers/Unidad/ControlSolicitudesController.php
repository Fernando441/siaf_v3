<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

use App\Models\Unidad\Unidad;
use App\Models\Taller\Taller;
use App\Models\Taller\TallerSolicitud;
use App\Models\Taller\TallerSolicitudDocumento;
use App\Models\Unidad\UnidadFotografia;

use App\Models\Logistica\SustitutoSolicitud;
use App\Models\Proyecto\Proyecto;
use App\Models\Licitacion\Licitacion;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use App\Models\Logistica\SustitutoMotivo;
use App\Models\Logistica\SustitutoEvidencia;

use App\Models\Logistica\AsignacionLogistica;
use App\Models\Logistica\AsignacionTipoDocumento;
use App\Models\Logistica\AsignacionDocumento;
use App\Models\Logistica\AsignacionTotalUnidades;

use App\Models\Translados\Translados;
use App\Models\Solicitud\Solicitud;
use App\Models\Solicitud\SolicitudDocumento;
use App\Models\Solicitud\SolicitudEjecucion;
use App\Models\Solicitud\SolicitudValidacion;
use App\Models\Solicitud\SolicitudBitacora;
class ControlSolicitudesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function controlsolicitudes()
    {
    	$mantenimientSolicitud = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->get();
        $total_mantenimientSolicitud = count($mantenimientSolicitud);
        $mantenimientSolicitud_prioridad_alta = TallerSolicitud::where('prioridad', 0)->get();
        $mantenimientSolicitud_prioridad_media = TallerSolicitud::where('prioridad', 1)->get();
        $mantenimientSolicitud_prioridad_baja = TallerSolicitud::where('prioridad', 2)->get();

        $ms_tipo_preventivo = TallerSolicitud::where('tipo_solicitud', 'PREVENTIVO')->get();
        $ms_tipo_correctivo = TallerSolicitud::where('tipo_solicitud', 'CORRECTIVO')->get();
        $ms_tipo_siniestro = TallerSolicitud::where('tipo_solicitud', 'SINIESTRO')->get();
        $ms_tipo_admin = TallerSolicitud::where('tipo_solicitud', 'ADMINISTRATIVO')->get();

        $ms_estatus_pendiente = TallerSolicitud::where('taller_solicitud_estado_id', 1)->get();
        $ms_estatus_envrevision = TallerSolicitud::where('taller_solicitud_estado_id', 2)->get();
        $ms_estatus_rechazado = TallerSolicitud::where('taller_solicitud_estado_id', 3)->get();
        $ms_estatus_autorizado = TallerSolicitud::where('taller_solicitud_estado_id', 4)->get();
        $ms_estatus_finalizado = TallerSolicitud::where('taller_solicitud_estado_id', 5)->get();
        $ms_estatus_entaller = TallerSolicitud::where('taller_solicitud_estado_id', 6)->get();
        // END solicitudes Mantenimiento

        $sustituto_solicitud = SustitutoSolicitud::where('id_status_delete', 1)->get();
        $sus_motivo_falla = SustitutoSolicitud::where('motivo_id', 1)->get();
        $sus_motivo_siniestro = SustitutoSolicitud::where('motivo_id', 2)->get();
        $sus_motivo_perdida = SustitutoSolicitud::where('motivo_id', 3)->get();

        $sustituto_estatus_solicitado = SustitutoSolicitud::where('estatus', 1)->get();
        $sustituto_estatus_envlogistica = SustitutoSolicitud::where('estatus', 2)->get();
        $sustituto_estatus_unidasignada = SustitutoSolicitud::where('estatus', 3)->get();
        $sustituto_estatus_finalizado = SustitutoSolicitud::where('estatus', 4)->get();
        // END solicitudes sustitutos

        $asignacion_unidades = AsignacionLogistica::where('id_status_delete', 1)->get();
        $as_tipo_patio = AsignacionLogistica::where('tipo_asignacion', 0)->get();
        $as_tipo_contrato = AsignacionLogistica::where('tipo_asignacion', 1)->get();
        // END solicitudes Asignacion unidades

        $traslados = Translados::where('id_status_delete', 1)->get();
        $traslados_estatus_pendiente = Translados::where('estatus_id', 0)->get();
        $traslados_estatus_trasladista = Translados::where('estatus_id', 1)->get();
        $traslados_estatus_operador = Translados::where('estatus_id', 2)->get();
        // END solicitudes Asignacion unidades

        $gps = Solicitud::get();
        $gps_estatus_solicitada = Solicitud::where('solicitud_estatus_id', 1)->get();
        $gps_estatus_env_proveedor = Solicitud::where('solicitud_estatus_id', 2)->get();
        $gps_estatus_finalizada = Solicitud::where('solicitud_estatus_id', 3)->get();
        $gps_estatus_pendiente = Solicitud::where('solicitud_estatus_id', 4)->get();
        $gps_estatus_validacion = Solicitud::where('solicitud_estatus_id', 5)->get();
        $gps_estatus_rechazada = Solicitud::where('solicitud_estatus_id', 6)->get();
        // dd($gps);

    	return view('unidades.controlsolicitudes.listado-solicitudes', compact('mantenimientSolicitud', 'total_mantenimientSolicitud', 'mantenimientSolicitud_prioridad_alta', 'mantenimientSolicitud_prioridad_media', 'mantenimientSolicitud_prioridad_baja', 'ms_tipo_preventivo', 'ms_tipo_correctivo', 'ms_tipo_siniestro', 'ms_tipo_admin', 'ms_estatus_pendiente', 'ms_estatus_envrevision', 'ms_estatus_rechazado', 'ms_estatus_autorizado', 'ms_estatus_finalizado', 'ms_estatus_entaller', 'sustituto_solicitud', 'sus_motivo_falla', 'sus_motivo_siniestro', 'sus_motivo_perdida', 'sustituto_estatus_solicitado', 'sustituto_estatus_envlogistica', 'sustituto_estatus_unidasignada', 'sustituto_estatus_finalizado', 'asignacion_unidades', 'as_tipo_patio', 'as_tipo_contrato', 'traslados', 'traslados_estatus_pendiente', 'traslados_estatus_trasladista', 'traslados_estatus_operador', 'gps', 'gps_estatus_solicitada', 'gps_estatus_env_proveedor', 'gps_estatus_finalizada', 'gps_estatus_pendiente', 'gps_estatus_validacion', 'gps_estatus_rechazada'));
    }

    public function versolmantenimiento($id)
    {
        $solicitud = TallerSolicitud::with('unidad')->where('id', $id)->first();
        $unidad = Unidad::where('id', $solicitud->unidad_id)->first();
        $documentosSolicitud = TallerSolicitudDocumento::where('taller_solicitud_id', $id)->where('id_status_delete', 1)->get();
        $evidencia = false;
        foreach ($documentosSolicitud as $documento) {
            if ($documento->taller_solicitud_tipo_documento_id == 6) {
                $evidencia = true;
            }
        }

        $taller = Taller::where('id_status_delete', 1)->get();
        // dd($taller);

        $fotografias = UnidadFotografia::where('unidad_id', $unidad->id)->get();
        $active = UnidadFotografia::where('unidad_id', $unidad->id)->first();

        if ($active == null) {
                $ver = 0;
        } else {
                $ver = $active->id;
        }
    	return view('unidades.controlsolicitudes.ver-mantenimiento', compact('solicitud', 'unidad', 'evidencia', 'fotografias', 'active', 'ver'));

    }

    public function versolsustitutos($id_solicitud)
    {
    	$solicitud_sustituto = SustitutoSolicitud::where('id', $id_solicitud)->first();
 
		$unidad = Unidad::where('id', $solicitud_sustituto->unidad_id_base)->first();
    	$fotografias = UnidadFotografia::where('unidad_id', $solicitud_sustituto->unidad_id_base)->get();
    	$active = UnidadFotografia::where('unidad_id', $unidad->id)->first();
    	
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

		return view('unidades.controlsolicitudes.ver-sustituto', compact('unidad', 'fotografias', 'ver', 'proyecto_info', 'info_licitacion', 'estados', 'municipios', 'sustituto', 'solicitud_sustituto', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s'));     	
    }

    public function versolasignacion($id_asignacion)
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

		return view('unidades.controlsolicitudes.ver-asignacion', compact('estados', 'municipios','cadenaTipoDocumento', 'asignacionLogistica', 'doc_asignacion')); 

    }

    public function versoltraslado($id_translado)
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

		return view('unidades.controlsolicitudes.ver-traslado', compact('solicitud', 'id_translado', 'sol_asignacion', 'solicitud_sustituto', 'tipo_solicitud', 'estados', 'municipios', 'solicitud_sustituto', 'unidad', 'fotografias', 'active', 'ver', 'proyecto_info', 'info_licitacion', 'sustituto', 'ubicacion_data', 'unidad_sustituta', 'fotografias_sustitutas', 'active_s', 'ver_s', 'unidades_seleccionadas')); 

    }

    public function versolgps(Request $request)
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

		return view('unidades.controlsolicitudes.ver-gps', compact('solicitudes', 'solicitudEjecucion', 'solicitudValidacion', 'solicitudBitacora'));    	
    }


}