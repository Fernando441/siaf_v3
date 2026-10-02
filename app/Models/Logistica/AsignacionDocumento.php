<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $asignacion_id
 * @property integer $id_tipo_documento
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserUpdated
 * @property AsignacionTipoDocumento $asignacionTipoDocumento
 * @property User $user
 * @property AsignacionUnidadLog $asignacionUnidadLog
 */
class AsignacionDocumento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'asignacion_documento';

    /**
     * @var array
     */
    protected $fillable = ['asignacion_id', 'id_tipo_documento', 'documento', 'created_at', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asignacionTipoDocumento()
    {
        return $this->belongsTo('App\Models\Logistica\AsignacionTipoDocumento', 'id_tipo_documento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asignacionUnidadLog()
    {
        return $this->belongsTo('App\Models\Logistica\AsignacionLogistica', 'asignacion_id');
    }
}
