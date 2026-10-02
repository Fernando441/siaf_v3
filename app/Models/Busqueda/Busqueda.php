<?php

namespace App\Models\Busqueda;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $bid
 * @property string $parametros
 * @property integer $iduserCreated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Busqueda extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'busqueda';

    /**
     * @var array
     */
    protected $fillable = ['bid', 'parametros', 'iduserCreated', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Busqueda\User', 'iduserCreated');
    }
}
