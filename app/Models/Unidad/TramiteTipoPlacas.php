<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $tipo_placas
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property UnidadTramiteEmplacamientoInfo[] $unidadTramiteEmplacamientoInfos
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 */
class TramiteTipoPlacas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_tipo_placas';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'tipo_placas', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TramiteEmplacamientoInfo()
    {
        return $this->hasMany('App\Models\Unidad\TramiteEmplacamientoInfo', 'unidad_tramite_tipo_placas_id');
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
