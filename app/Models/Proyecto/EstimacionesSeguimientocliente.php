<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $estimacion_id
 * @property integer $estatus_estimacion
 * @property string $fecha_envio
 * @property string $observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property ProyectoEstimacione $proyectoEstimacione
 * @property User $user
 */
class EstimacionesSeguimientocliente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_estimaciones_seguimiento';

    /**
     * @var array
     */
    protected $fillable = ['estimacion_id', 'estatus_estimacion', 'fecha_envio', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

 
    public function Estimacionesproyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\EstimacionesProyecto', 'estimacion_id');
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
