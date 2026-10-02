<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $id_propietario
 * @property integer $entidad_placas
 * @property integer $id_status_delete
 * @property integer $unidad_tramite_gestor_id
 * @property integer $unidad_tramite_tipo_placas_id
 * @property string $fecha_tramite
 * @property string $numero_placas
 * @property integer $engomado
 * @property integer $verificacion_op
 * @property string $tarjeta_circularion
 * @property string $fecha_emision_tarjeta
 * @property string $fecha_vencimiento_tarjeta
 * @property string $holograma
 * @property string $observaciones
 * @property integer $op_estatus
 * @property float $importe
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $fecha_expedicion
 * @property UnidadTramiteReemplacamientoDoc[] $unidadTramiteReemplacamientoDocs
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property UnidadTramiteTipoPlaca $unidadTramiteTipoPlaca
 * @property User $user
 * @property Estado $estado
 * @property Unidad $unidad
 * @property UnidadTramiteGestor $unidadTramiteGestor
 * @property User $user
 */
class TramiteReemplacamientoInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_reemplacamiento_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_propietario', 'entidad_placas', 'id_status_delete', 'unidad_tramite_gestor_id', 'unidad_tramite_tipo_placas_id', 'fecha_tramite', 'numero_placas', 'engomado', 'verificacion_op', 'tarjeta_circularion', 'fecha_emision_tarjeta', 'fecha_vencimiento_tarjeta', 'holograma', 'observaciones', 'op_estatus', 'importe', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'fecha_expedicion'];


    public function TramiteTipoPlaca()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteTipoPlaca', 'unidad_tramite_tipo_placas_id');
    }

    public function TramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGestor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unidadTramiteEmplacamientoDocs()
    {
        return $this->hasMany('App\Models\Unidad\TramiteEmplacamientoDoc');
    }


    public function unidadInformacionPropietario()
    {
        return $this->belongsTo('App\Models\Unidad\InformacionPropietario', 'id_propietario');
    }


    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'entidad_placas', 'id_estado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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
