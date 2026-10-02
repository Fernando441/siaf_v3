<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property integer $taller_id
 * @property string $tec_calidad
 * @property string $tec_calidad_obs
 * @property string $ope_tiempo
 * @property string $ope_tiempo_obs
 * @property string $ope_cumplimiento
 * @property string $ope_cumplimiento_obs
 * @property string $ope_cobertura
 * @property string $ope_cobertura_obs
 * @property string $adm_documentacion
 * @property string $adm_documentacion_obs
 * @property string $adm_claridad
 * @property string $adm_claridad_obs
 * @property string $adm_registro
 * @property string $adm_registro_obs
 * @property string $cli_trato
 * @property string $cli_trato_obs
 * @property string $cli_disposicion
 * @property string $cli_disposicion_obs
 * @property string $cli_resultados
 * @property string $cli_resultados_obs
 * @property string $fin_relacion
 * @property string $fin_relacion_obs
 * @property string $fin_entrega
 * @property string $fin_entrega_obs
 * @property string $res_tecnica
 * @property string $res_operativa
 * @property string $res_administrativa
 * @property string $res_cliente
 * @property string $res_financiera
 * @property string $res_total
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property TallerSolicitud $tallerSolicitud
 * @property User $user
 * @property Taller $taller
 * @property User $user
 */
class EvaluacionTaller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_evaluacion';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'taller_id', 'tec_calidad', 'tec_calidad_obs', 'ope_tiempo', 'ope_tiempo_obs', 'ope_cumplimiento', 'ope_cumplimiento_obs', 'ope_cobertura', 'ope_cobertura_obs', 'adm_documentacion', 'adm_documentacion_obs', 'adm_claridad', 'adm_claridad_obs', 'adm_registro', 'adm_registro_obs', 'cli_trato', 'cli_trato_obs', 'cli_disposicion', 'cli_disposicion_obs', 'cli_resultados', 'cli_resultados_obs', 'fin_relacion', 'fin_relacion_obs', 'fin_entrega', 'fin_entrega_obs', 'res_tecnica', 'res_operativa', 'res_administrativa', 'res_cliente', 'res_financiera', 'res_total', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taller()
    {
        return $this->belongsTo('App\Models\Taller\Taller');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitud()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitud');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
