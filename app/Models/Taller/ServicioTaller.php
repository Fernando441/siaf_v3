<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $servicio
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property TallerServicio[] $tallerServicios
 */
class ServicioTaller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'servicio';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'servicio', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
    
    public function tallerServicios()
    {
        return $this->hasMany('App\Models\Taller\ServicioTaller');
    }
}
