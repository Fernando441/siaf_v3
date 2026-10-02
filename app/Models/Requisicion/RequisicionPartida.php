<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_id
 * @property integer $requisicion_partida_estatus_id
 * @property integer $id_status_delete
 * @property integer $segmentos_id
 * @property string $cantidad
 * @property string $observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Requisicion $requisicion
 * @property Segmento $segmento
 * @property User $user
 * @property RequisicionPartidaEstatus $requisicionPartidaEstatus
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class RequisicionPartida extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_partida';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_id', 'requisicion_partida_estatus_id', 'id_status_delete', 'segmentos_id', 'cantidad', 'precio_unitario', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'orden_estatus','cantidad_orden', 'cantidad_maxima', 'op_cantidades'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicion()
    {
        return $this->belongsTo('App\Models\Requisicion\Requisicion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionPartidaEstatus()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionPartidaEstatus');
    }

    public function segmento()
    {
        return $this->belongsTo('App\Models\Segmento\Segmento', 'segmentos_id');
    }

    public function requisicionPartidaEquipamiento()
    {
        return $this->hasMany('App\Models\Licitacion\RequisicionPartidaEquipamiento');
    }

    public function requisicionPartidaEmplacamiento()
    {
        return $this->hasMany('App\Models\Licitacion\RequisicionPartidaEmplacamiento');
    }

    public function requisicionPartidaAseguramiento()
    {
        return $this->hasMany('App\Models\Licitacion\RequisicionPartidaAseguramiento');
    }

    public function requisicionPartidaLugarEntrega()
    {
        return $this->hasMany('App\Models\Licitacion\RequisicionPartidaLugarEntrega');
    }



}
