<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $nombre_estatus
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 * @property UnidadTramiteBajavehiculoSiniestroInfo[] $unidadTramiteBajavehiculoSiniestroInfos
 */
class TramiteBajaVehiculoSiniestroEstatus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_bajavehiculo_siniestro_estatus';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'nombre_estatus', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function TramiteBajavehiculoSiniestroInfo()
    {
        return $this->hasMany('App\Models\Unidad\UnidadTramiteBajavehiculoSiniestroInfo', 'estatus_id');
    }

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
