<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $id_propietario
 * @property integer $id_status_delete
 * @property integer $unidad_tramite_gestor_id
 * @property string $numero_identificacion
 * @property string $marca_gps
 * @property string $modelo_gps
 * @property string $fecha_instalacion
 * @property string $informacion_proveedor
 * @property float $importe
 * @property string $observaciones
 * @property integer $op_estatus
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadTramiteGestor $unidadTramiteGestor
 * @property UnidadTratmiteGpsDoc[] $unidadTratmiteGpsDocs
 */
class TramiteGpsInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_gps_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_propietario', 'id_status_delete', 'unidad_tramite_gestor_id', 'numero_identificacion', 'marca_gps', 'modelo_gps', 'fecha_instalacion', 'informacion_proveedor', 'importe', 'observaciones', 'op_estatus', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function TramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGestor');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }

 
    public function unidadInformacionPropietario()
    {
        return $this->belongsTo('App\Models\Unidad\InformacionPropietario', 'id_propietario');
    }

    public function unidadTratmiteGpsDoc()
    {
        return $this->hasMany('App\Models\Unidad\TratmiteGpsDoc');
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
