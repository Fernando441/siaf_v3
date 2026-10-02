<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $estado_id
 * @property integer $ciudad_id
 * @property integer $id_status_delete
 * @property string $nombre_propietario
 * @property string $rfc
 * @property string $no_identificacion
 * @property string $direccion
 * @property string $cp
 * @property string $telefono
 * @property string $correo
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Estado $estado
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Municipio $municipio
 */
class InformacionPropietario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_informacion_propietario';

    /**
     * @var array
     */
    protected $fillable = ['estado_id', 'ciudad_id', 'id_status_delete', 'nombre_propietario', 'rfc', 'no_identificacion', 'direccion', 'cp', 'telefono', 'correo', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];


    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', null, 'id_estado');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', 'ciudad_id', 'id_municipio');
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
