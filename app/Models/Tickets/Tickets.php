<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $ip_usuario
 * @property string $created_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property integer $estatus
 * @property User $user
 * @property User $user
 */
class Tickets extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['titulo', 'descripcion', 'ip_usuario', 'created_at', 'iduserCreated', 'iduserUpdated', 'estatus'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Tickets\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function userC()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
