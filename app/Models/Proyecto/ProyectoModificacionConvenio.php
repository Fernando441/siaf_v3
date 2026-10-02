<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $nombre_modificacion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class ProyectoModificacionConvenio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_modificacion_convenio';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'nombre_modificacion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
}
