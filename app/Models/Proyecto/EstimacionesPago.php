<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $estimacion_id
 * @property integer $proyecto_estimaciones_tipo_documento_id
 * @property string $documento
 * @property string $fecha_pago
 * @property string $created_at
 * @property integer $iduserCreated
 * @property ProyectoEstimacionesTipoDocumento $proyectoEstimacionesTipoDocumento
 * @property ProyectoEstimacione $proyectoEstimacione
 * @property User $user
 */
class EstimacionesPago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_estimaciones_pago';

    /**
     * @var array
     */
    protected $fillable = ['estimacion_id', 'proyecto_estimaciones_tipo_documento_id', 'documento', 'fecha_pago', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyectoEstimacionesTipoDocumento()
    {
        return $this->belongsTo('App\Models\Proyecto\EstimacionesTipoDocumento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyectoEstimacion()
    {
        return $this->belongsTo('App\Models\Proyecto\EstimacionesProyecto', 'estimacion_id');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    

}
