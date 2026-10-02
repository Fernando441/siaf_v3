<?php

namespace App\Models\Translados;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property integer $asignacion_solicitud_id
 * @property integer $sustituto_solicitud_id
 * @property integer $estatus_id
 * @property string $nombre_translado
 * @property string $observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $envio_transladista
 * @property string $envio_operador
 * @property integer $op_solicitud
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property AsignacionUnidadLog $asignacionUnidadLog
 * @property SustitutoSolicitud $sustitutoSolicitud
 * @property TransladosUnidad[] $transladosUnidads
 */
class Translados extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'asignacion_solicitud_id', 'sustituto_solicitud_id', 'estatus_id', 'nombre_translado', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'envio_transladista', 'envio_operador', 'op_solicitud'];


    public function asignacionUnidadLog()
    {
        return $this->belongsTo('App\Models\Logistica\AsignacionLogistica', 'asignacion_solicitud_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sustitutoSolicitud()
    {
        return $this->belongsTo('App\Models\Logistica\SustitutoSolicitud', 'sustituto_solicitud_id');
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
