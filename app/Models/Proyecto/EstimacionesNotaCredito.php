<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $estimacion_id
 * @property string $no_nota_credito
 * @property string $fecha_emision
 * @property string $referencia_factura
 * @property string $observaciones
 * @property string $monto_creditar
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property ProyectoEstimacione $proyectoEstimacione
 * @property User $user
 */
class EstimacionesNotaCredito extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_estimaciones_notacredito';

    /**
     * @var array
     */
    protected $fillable = ['estimacion_id', 'no_nota_credito', 'fecha_emision', 'referencia_factura', 'observaciones', 'monto_creditar', 'documento', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function EstimacionesProyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\EstimacionesProyecto', 'estimacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
