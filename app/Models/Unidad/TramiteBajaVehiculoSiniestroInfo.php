<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $id_propietario
 * @property integer $estatus_id
 * @property integer $id_status_delete
 * @property integer $unidad_tramite_gestor_id
 * @property integer $estado_id_estado
 * @property integer $municipio_id_municipio
 * @property integer $unidad_tramite_bajavehiculo_siniestro_tipo_id
 * @property string $fecha_tramite
 * @property string $observaciones
 * @property integer $op_estatus
 * @property float $importe
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $fecha_ocurrencia
 * @property string $fecha_conclusion
 * @property string $cia_seguros
 * @property string $no_siniestro
 * @property string $no_reporte
 * @property string $conductor
 * @property string $autoridad_participante
 * @property string $no_carpeta
 * @property UnidadTramiteBajavehiculoSiniestroDoc[] $unidadTramiteBajavehiculoSiniestroDocs
 * @property UnidadTramiteBajavehiculoSiniestroTipo $unidadTramiteBajavehiculoSiniestroTipo
 * @property Estado $estado
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property UnidadTramiteGestor $unidadTramiteGestor
 * @property User $user
 * @property Municipio $municipio
 * @property Unidad $unidad
 * @property UnidadTramiteBajavehiculoSiniestroEstatus $unidadTramiteBajavehiculoSiniestroEstatus
 */
class TramiteBajaVehiculoSiniestroInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_bajavehiculo_siniestro_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_propietario', 'estatus_id', 'id_status_delete', 'unidad_tramite_gestor_id', 'estado_id_estado', 'municipio_id_municipio', 'unidad_tramite_bajavehiculo_siniestro_tipo_id', 'fecha_tramite', 'observaciones', 'op_estatus', 'importe', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'fecha_ocurrencia', 'fecha_conclusion', 'cia_seguros', 'no_siniestro', 'no_reporte', 'conductor', 'autoridad_participante', 'no_carpeta'];


    public function unidadTramiteBajavehiculoSiniestroTipo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteBajavehiculoSiniestroTipo');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'estado_id_estado', 'id_estado');
    }


    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', 'municipio_id_municipio', 'id_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unidadTramiteBajavehiculoSiniestroDocs()
    {
        return $this->hasMany('App\Models\Unidad\TramiteBajavehiculoSiniestroDoc');
    }


    public function unidadTramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGestor');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }


    public function InformacionPropietario()
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

    public function TramiteBajavehiculoSiniestroEstatus()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteBajavehiculoSiniestroEstatus', 'estatus_id');
    }
}
