<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_partida_id
 * @property integer $requisicion_orden_proveedor_id
 * @property integer $segmentos_id
 * @property string $cantidad
 * @property RequisicionOrdenProveedor $requisicionOrdenProveedor
 * @property Segmento $segmento
 * @property RequisicionPartida $requisicionPartida
 */
class RequisicionOrdenPartida extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_orden_partida';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_partida_id', 'requisicion_orden_proveedor_id', 'segmentos_id', 'cantidad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionOrdenProveedor()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionOrdenProveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmento()
    {
        return $this->belongsTo('App\Models\Segmento\Segmento', 'segmentos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionPartida()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionPartida');
    }
}
