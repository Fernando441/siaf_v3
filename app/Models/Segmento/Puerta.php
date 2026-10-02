<?php

namespace App\Models\Segmento;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property integer $puertas
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Segmento[] $segmentos
 */
class Puerta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'segmento_puerta';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'puertas', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function segmentos()
    {
        return $this->hasMany('App\Models\Segmento\Segmento', 'puerta_id');
    }
}
