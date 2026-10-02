<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_id
 * @property integer $id_estado
 * @property integer $id_municipio
 * @property integer $id_patio
 * @property integer $id_proyectos
 * @property integer $id_status_delete
 * @property string $nombre_asignacion
 * @property string $direccion
 * @property string $sub_direccion
 * @property string $coordinacion
 * @property string $area
 * @property string $partida
 * @property string $calle
 * @property string $poblacion
 * @property string $cp
 * @property string $contacto
 * @property string $observaciones
 * @property integer $tipo_asignacion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property AsignacionDocumento[] $asignacionDocumentos
 * @property AsignacionTotalUnidade[] $asignacionTotalUnidades
 * @property Municipio $municipio
 * @property Requisicion $requisicion
 * @property UbicacionUnidad $ubicacionUnidad
 * @property User $user
 * @property Estado $estado
 * @property Proyecto $proyecto
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class AsignacionLogistica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'asignacion_unidad_log';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_id', 'id_estado', 'id_municipio', 'id_patio', 'id_proyectos', 'id_status_delete', 'nombre_asignacion', 'direccion', 'sub_direccion', 'coordinacion', 'area', 'partida', 'calle', 'poblacion', 'cp', 'contacto', 'observaciones', 'tipo_asignacion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'op_traslado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignacionDocumentos()
    {
        return $this->hasMany('App\Models\Logistica\AsignacionDocumento', 'asignacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignacionTotalUnidades()
    {
        return $this->hasMany('App\Models\Logistica\AsignacionTotalUnidades', 'id_asignacion');
    }


    public function ubicacionUnidad()
    {
        return $this->belongsTo('App\Models\Unidad\UbicacionUnidad', 'id_patio');
    }


    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'id_proyectos');
    }



  public function requisicions()
    {
        return $this->hasMany('App\Models\Requisicion\Requisicion');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', 'id_municipio', 'id_municipio');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'id_estado', 'id_estado');
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
