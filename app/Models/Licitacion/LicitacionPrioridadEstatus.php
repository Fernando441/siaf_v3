<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $estatus
 * @property string $created_at
 * @property string $updated_at
 * @property LicitacionPrioridad[] $licitacionPrioridads
 * @property User $userCreated
 * @property User $userUpdated
 */
class LicitacionPrioridadEstatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licitacion_prioridad_estatus';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['iduserCreated', 'iduserUpdated', 'estatus', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPrioridad()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPrioridad', 'id_licitacion_prioridad_estatus');
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
}
