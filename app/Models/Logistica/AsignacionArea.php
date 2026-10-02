<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nombre_area
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 */
class AsignacionArea extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'asignacion_area_adm';

    /**
     * @var array
     */
    protected $fillable = ['nombre_area', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
