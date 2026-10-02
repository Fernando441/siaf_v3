<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_tipo_transporte_id
 * @property integer $id_status_delete
 * @property string $descripcion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionTipoTransporte $requisicionTipoTransporte
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 * @property RequisicionPartidaAseguramiento[] $requisicionPartidaAseguramientos
 */
class RequisicionCobertura extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_cobertura';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_tipo_transporte_id', 'id_status_delete', 'descripcion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionTipoTransporte()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionTipoTransporte');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisicionPartidaAseguramientos()
    {
        return $this->hasMany('App\Models\Licitacion\RequisicionPartidaAseguramiento');
    }
}
