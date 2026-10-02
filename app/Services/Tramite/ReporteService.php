<?php

namespace App\Services\Tramite;

use App\Models\Unidad\TramiteAseguramientoInfo;
use App\Models\Unidad\TramiteCambioPropietarioInfo;
use App\Models\Unidad\Unidad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Unidad\TramiteEmplacamientoInfo;
use App\Models\Unidad\TramiteGpsInfo;
use App\Models\Unidad\TramiteReemplacamientoInfo;
use App\Models\Unidad\TramiteTenenciaInfo;
use App\Models\Unidad\TramiteVerificacionInfo;

class ReporteService
{
    protected $reporteDatos = [];
    protected $consulta = [];
    protected $titulos = [];
    protected $reporteCampos = [
        "economico",
        "serie",
        "unidad",
        "modelo",
        "placa",
        "entidad",
        "tipo_tramite",
        "laminas",
        "tc",
        "proyecto",
        "solicitante",
        "estatus",
        "fecha_recepcion",
        "fecha_ingreso_tramite",
        "fecha_ingreso_pago",
        "fecha_pago",
        "fecha_cita",
        "fecha_conclusion",
        "dias_transcurridos",
        "fecha_entrega",
        "receptor",
        "proyecto_recibe",
        "observaciones"
    ];

    public function registrosTramites(string $fechaInicio, string  $fechaFinal): array
    {

        $fechaInicioFrm = Carbon::createFromFormat('d/m/Y', $fechaInicio);
        $fechaFinalFrm = Carbon::createFromFormat('d/m/Y', $fechaFinal);

        $tramite = TramiteEmplacamientoInfo::from('unidad_tramite_emplacamiento_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            "es.estado_nombre",
            DB::raw("'Emplacamiento' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            "t.fecha_tramite",
            "t.fecha_expedicion",
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("estado as es", "es.id_estado", "t.entidad_placas");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_tramite', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_tramite', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $totalRegistros = 0;
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteTenenciaInfo::from('unidad_tramite_tenencia_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            DB::raw("'Tenencia' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            "t.fecha_tramite",
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_tramite', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_tramite', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $totalRegistros = 0;
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteVerificacionInfo::from('unidad_tramite_verificacion_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            DB::raw("'Verificación' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            "t.fecha_tramite",
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_tramite', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_tramite', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $totalRegistros = 0;
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteAseguramientoInfo::from('unidad_tramite_aseguramiento_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            DB::raw("'Aseguramiento' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            DB::raw("t.created_at as fecha_tramite"),
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.created_at', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.created_at', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $totalRegistros = 0;
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteReemplacamientoInfo::from('unidad_tramite_reemplacamiento_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            "es.estado_nombre",
            DB::raw("'Remplacamiento' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            "t.fecha_tramite",
            "t.fecha_expedicion",
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("estado as es", "es.id_estado", "t.entidad_placas");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_tramite', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_tramite', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteCambioPropietarioInfo::from('unidad_tramite_cambiopropietario_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            DB::raw("'Cambio de Propietario' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            "t.fecha_tramite",
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_tramite', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_tramite', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $this->construlleDatosReporte($tramiteResultados);

        $tramite = TramiteGpsInfo::from('unidad_tramite_gps_info as t')->select(
            "un.numero_economico",
            "un.no_serie",
            "mu.nombre_marca",
            "mou.nombre_modelo",
            "un.placa",
            DB::raw("'GPS' as tipo_tramite"),
            "pr.titulo_servicio",
            "ges.nombre as soliciante",
            "t.op_estatus",
            DB::raw("t.fecha_instalacion as fecha_tramite"),
            "t.observaciones"
        );
        $tramite->join("unidad as un", "un.id", "t.unidad_id");
        $tramite->leftjoin("marca_unidad as mu", "mu.id", "un.id_marca");
        $tramite->leftjoin("modelo_unidad as mou", "mou.id", '=', "un.id_modelo");
        $tramite->leftjoin("proyectos as pr", "pr.id", '=', "un.proyectos_id");
        $tramite->leftjoin("unidad_tramite_gestor as ges", "ges.id", "t.unidad_tramite_gestor_id");
        $tramite->where("t.id_status_delete", 1);
        $tramite->whereBetween('t.fecha_instalacion', [$fechaInicioFrm->format('Y-m-d'), $fechaFinalFrm->format('Y-m-d')]);
        $tramite->orderBy('t.fecha_instalacion', 'ASC');
        $tramiteResultados = $tramite->get()->toArray();
        $reporteDatos = $this->construlleDatosReporte($tramiteResultados);

        if (!empty($reporteDatos) && isset($reporteDatos['economico']) ) {
            $totalRegistros = count($reporteDatos['economico']);
        }

        // Construcción de títulos
        foreach ($this->reporteCampos as $indice => $campo) {
            $tituloCampo = match ($campo) {
                "economico" =>  "ECONÓMICO",
                "serie" => "SERIE",
                "unidad" => "UNIDAD",
                "modelo" => "MODELO",
                "placa" => "PLACA",
                "entidad" => "ENTIDAD",
                "tipo_tramite" => "TIPO TRAMITE",
                "laminas" => "LÁMINAS",
                "tc" => "TC",
                "proyecto" => "PROYECTO/ÁREA",
                "solicitante" => "SOLICITANTE",
                "estatus" => "ESTATUS",
                "fecha_recepcion" => "FECHA RECEPCIÓN",
                "fecha_ingreso_tramite" => "FECHA INGRESO TRÁMITE",
                "fecha_ingreso_pago" => "FECHA INGRESO PAGO",
                "fecha_pago" => "FECHA PAGO",
                "fecha_cita" => "FECHA CITA",
                "fecha_conclusion" => "FECHA CONCLUSIÓN",
                "dias_transcurridos" => "DÍAS TRANSCURRIDOS EN TRÁMITE",
                "fecha_entrega" => "FECHA ENTREGA",
                "receptor" => "RECEPTOR",
                "proyecto_recibe" => "PROYECTO QUE RECIBE",
                "observaciones" => "OBSERVACIONES",
                default => null
            };

            $this->titulos[] = $tituloCampo;
        }

        return [
            "unidades" => $reporteDatos,
            "titulos" => $this->titulos,
            "total_registros" => $totalRegistros
        ];
    }

    private function construlleDatosReporte(array $tramiteResultados): array
    {
        foreach ($tramiteResultados as $indice => $campoConsulta) {

            foreach ($this->reporteCampos as $indiceCampos => $campoReporte) {

                if ($campoReporte == "economico") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['numero_economico'];
                }elseif ($campoReporte == "serie") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['no_serie'];
                }elseif ($campoReporte == "unidad") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['nombre_marca'];
                }elseif ($campoReporte == "modelo") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['nombre_modelo'];
                }elseif ($campoReporte == "placa") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['placa'];
                }elseif ($campoReporte == "entidad") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['estado_nombre'] ?? '';
                }elseif ($campoReporte == "tipo_tramite") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['tipo_tramite'];    
                }elseif ($campoReporte == "laminas") {
                    $this->reporteDatos[$campoReporte][] = '';        
                }elseif ($campoReporte == "tc") {
                    $this->reporteDatos[$campoReporte][] = '';
                }elseif ($campoReporte == "proyecto") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['titulo_servicio'];
                }elseif ($campoReporte == "solicitante") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['soliciante'];
                }elseif ($campoReporte == "estatus") {
                    $this->reporteDatos[$campoReporte][] = match ($campoConsulta['op_estatus']) {
                        1 => 'En Proceso',
                        2 => 'Concluido',
                        default => ''
                    };
                }elseif (
                    $campoReporte == "fecha_recepcion" || 
                    $campoReporte == "fecha_ingreso_tramite" || 
                    $campoReporte == "fecha_ingreso_pago" || 
                    $campoReporte == "fecha_pago"
                ) {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['fecha_tramite'];    
                }elseif ($campoReporte == "fecha_cita") {
                    $this->reporteDatos[$campoReporte][] = '';
                }elseif ($campoReporte == "fecha_conclusion" || $campoReporte == "fecha_entrega") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['fecha_expedicion'] ?? '';
                }elseif ($campoReporte == "dias_transcurridos") {
                    $diasTranscurridos = null;
                    if (isset($campoConsulta['fecha_expedicion'])) {
                        $diasTranscurridos = Carbon::parse($campoConsulta['fecha_tramite'])->diffInDays(Carbon::parse($campoConsulta['fecha_expedicion']));
                    }
                    $this->reporteDatos[$campoReporte][] = $diasTranscurridos !== null ? $diasTranscurridos : '';    
                }elseif ($campoReporte == "receptor") {
                    $this->reporteDatos[$campoReporte][] = '';
                }elseif ($campoReporte == "proyecto_recibe") {
                    $this->reporteDatos[$campoReporte][] = '';
                }elseif ($campoReporte == "observaciones") {
                    $this->reporteDatos[$campoReporte][] = $campoConsulta['observaciones'];
                }else{
                    $this->reporteDatos[$campoReporte][] = '';
                }
            }
        }

        return $this->reporteDatos;
    }


}