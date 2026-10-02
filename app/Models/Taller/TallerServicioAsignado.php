<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_id
 * @property integer $servicio_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Servicio $servicio
 * @property User $user
 * @property Taller $taller
 * @property User $user
 */
class TallerServicioAsignado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_servicio';

    /**
     * @var array
     */
    protected $fillable = ['taller_id', 'servicio_id', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicio()
    {
        return $this->belongsTo('App\Models\Taller\ServicioTaller');
    }


    public function taller()
    {
        return $this->belongsTo('App\Models\Taller\Taller');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\Taller\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Taller\User', 'iduserUpdated');
    }

}
