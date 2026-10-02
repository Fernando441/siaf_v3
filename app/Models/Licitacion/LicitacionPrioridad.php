<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_licitacion_prioridad_estatus
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $prioridad
 * @property string $created_at
 * @property string $updated_at
 * @property LicitacionPrioridadEstatus $licitacionPrioridadEstatus
 * @property User $userCreated
 * @property User $userUpdated
 * @property Licitacione[] $licitaciones
 */
class LicitacionPrioridad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licitacion_prioridad';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_licitacion_prioridad_estatus', 'iduserCreated', 'iduserUpdated', 'prioridad', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacionPrioridadEstatus()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionPrioridadEstatus', 'id_licitacion_prioridad_estatus');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitaciones()
    {
        return $this->hasMany('App\Models\Licitacion\Licitacion', 'id_licitacion_prioridad');
    }
}
