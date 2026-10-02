<?php

namespace App\Models\Segmento;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $status_delete
 * @property string $tipo_vehiculo
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Segmento[] $segmentos
 */
class TipoVehiculo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'segmento_tipo_vehiculo';

    /**
     * @var array
     */
    protected $fillable = ['status_delete', 'tipo_vehiculo', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'status_delete');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function segmentos()
    {
        return $this->hasMany('App\Models\Segmento\Segmento', 'tipo_vehiculo_id');
    }
}
