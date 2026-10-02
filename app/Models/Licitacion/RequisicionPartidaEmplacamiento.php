<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_entidad_federativa_id
 * @property integer $requisicion_tipo_placas_id
 * @property integer $id_status_delete
 * @property string $cantidad
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionEntidadFederativa $requisicionEntidadFederativa
 * @property RequisicionTipoPlaca $requisicionTipoPlaca
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 */
class RequisicionPartidaEmplacamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_partida_emplacamiento';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_partida_id', 'requisicion_entidad_federativa_id', 'requisicion_tipo_placas_id', 'id_status_delete', 'cantidad', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'op_documento'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionEntidadFederativa()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionEntidadFederativa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionPartida()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionPartida');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionTipoPlacas()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionTipoPlacas', 'requisicion_tipo_placas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Licitacion\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserUpdated');
    }
}
