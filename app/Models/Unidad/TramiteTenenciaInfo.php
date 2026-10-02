<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $id_propietario
 * @property integer $id_status_delete
 * @property integer $unidad_tramite_gestor_id
 * @property string $fecha_tramite
 * @property string $observaciones
 * @property integer $op_estatus
 * @property float $importe
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property UnidadTramiteTenenciaDoc[] $unidadTramiteTenenciaDocs
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadTramiteGestor $unidadTramiteGestor
 * @property User $user
 */
class TramiteTenenciaInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_tenencia_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_propietario', 'id_status_delete', 'unidad_tramite_gestor_id', 'fecha_tramite', 'observaciones', 'op_estatus', 'importe', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function TramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGestor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TramiteTenenciaDoc()
    {
        return $this->hasMany('App\Models\Unidad\TramiteTenenciaDoc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }


    public function unidadInformacionPropietario()
    {
        return $this->belongsTo('App\Models\Unidad\InformacionPropietario', 'id_propietario');
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
