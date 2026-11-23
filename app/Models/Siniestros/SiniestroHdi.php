<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestros_agencia_id
 * @property string $no_folio
 * @property integer $numero_siniestro
 * @property string $fecha_ocurrido
 * @property string $year_ocurrido
 * @property integer $numero_poliza
 * @property string $estatus_poliza
 * @property integer $inciso
 * @property string $proyecto
 * @property string $inicio_vigencia
 * @property string $termino_vigencia
 * @property string $estado
 * @property string $ciudad
 * @property string $conductor
 * @property integer $telefono
 * @property string $vehiculo
 * @property integer $year
 * @property integer $serie
 * @property string $placa
 * @property string $causa_siniestro
 * @property string $hora_reporte
 * @property string $responsable
 * @property string $evento_cabina
 * @property string $tipo_siniestro
 * @property string $estatus_siniestro
 * @property string $con_costo
 * @property string $equipo_pesado
 * @property float $estimacion_reserva_dm
 * @property float $estimacion_reserva_rt
 * @property float $estimacion_reserva_gm
 * @property float $estimacion_reserva_rc
 * @property float $reserva_otras
 * @property float $reserva_vigente
 * @property float $reserva_anterior
 * @property float $avance
 * @property float $ingresos_recuperaciones
 * @property float $deducible
 * @property float $pagos_realizados_dhi
 * @property float $salvamento
 * @property float $total_ocurrido
 * @property float $neto_ocurrido
 * @property string $contratante
 * @property string $cobertura
 * @property string $legal
 * @property string $taller
 * @property string $perdida_total
 * @property string $robo_localizado
 * @property integer $pt_indemnizada
 * @property string $comentarios
 * @property float $primas_no_denegadas
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiniestrosAgencium $siniestrosAgencium
 * @property User $user
 */
class SiniestroHdi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestro_registro_hdi';

    /**
     * @var array
     */
    protected $fillable = ['siniestros_agencia_id', 'no_folio', 'numero_siniestro', 'fecha_ocurrido', 'year_ocurrido', 'numero_poliza', 'estatus_poliza', 'inciso', 'proyecto', 'inicio_vigencia', 'termino_vigencia', 'estado', 'ciudad', 'conductor', 'telefono', 'vehiculo', 'year', 'serie', 'placa', 'causa_siniestro', 'hora_reporte', 'responsable', 'evento_cabina', 'tipo_siniestro', 'estatus_siniestro', 'con_costo', 'equipo_pesado', 'estimacion_reserva_dm', 'estimacion_reserva_rt', 'estimacion_reserva_gm', 'estimacion_reserva_rc', 'reserva_otras', 'reserva_vigente', 'reserva_anterior', 'avance', 'ingresos_recuperaciones', 'deducible', 'pagos_realizados_dhi', 'salvamento', 'total_ocurrido', 'neto_ocurrido', 'contratante', 'cobertura', 'legal', 'taller', 'perdida_total', 'robo_localizado', 'pt_indemnizada', 'comentarios', 'primas_no_denegadas', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'reporte_cabina', 'op_deducible'];


    public function siniestrosAgencia()
    {
        return $this->belongsTo('App\Models\Siniestros', 'siniestros_agencia_id');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

}
