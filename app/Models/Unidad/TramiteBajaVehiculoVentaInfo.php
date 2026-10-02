<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $id_propietario
 * @property integer $id_status_delete
 * @property string $fecha_tramite
 * @property string $observaciones
 * @property integer $op_estatus
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property UnidadTramiteBajavehiculoVentaDoc[] $unidadTramiteBajavehiculoVentaDocs
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property User $user
 * @property Unidad $unidad
 * @property User $user
 */
class TramiteBajaVehiculoVentaInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_bajavehiculo_venta_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_propietario', 'id_status_delete', 'fecha_tramite', 'observaciones', 'op_estatus', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated',  'importe'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TramiteBajavehiculoVentaDoc()
    {
        return $this->hasMany('App\Models\Unidad\TramiteBajavehiculoVentaDoc');
    }


    public function unidadInformacionPropietario()
    {
        return $this->belongsTo('App\Models\Unidad\InformacionPropietario', 'id_propietario');
    }


    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
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
