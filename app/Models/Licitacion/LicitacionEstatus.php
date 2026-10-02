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
 * @property User $userCreated
 * @property User $userUpdated
 * @property Licitacione[] $licitaciones
 */
class LicitacionEstatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licitacion_estatus';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitaciones()
    {
        return $this->hasMany('App\Models\Licitacion\Licitacion', 'id_licitacion_estatus');
    }
}
