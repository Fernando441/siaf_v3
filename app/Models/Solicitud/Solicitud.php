<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_tipo_id
 * @property integer $solicitud_estatus_id
 * @property integer $user_updated_id
 * @property integer $user_created_id
 * @property string $fecha
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $comentarios
 * @property string $comentarios_finalizacion
 * @property integer $activo
 * @property string $created_at
 * @property string $updated_at
 * @property SolicitudEstatus $solicitudEstatus
 * @property SolicitudTipo $solicitudTipo
 * @property User $user
 * @property User $user
 * @property SolicitudBitacora[] $solicitudBitacoras
 * @property SolicitudEjecucion[] $solicitudEjecucions
 * @property SolicitudUnidad[] $solicitudUnidads
 * @property SolicitudValidacion[] $solicitudValidacions
 */
class Solicitud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_tipo_id', 'solicitud_estatus_id', 'user_updated_id', 'user_created_id', 'fecha', 'nombre', 'direccion', 'telefono', 'comentarios', 'comentarios_finalizacion', 'activo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudEstatus()
    {
        return $this->belongsTo('App\Models\Solicitud\SolicitudEstatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudTipo()
    {
        return $this->belongsTo('App\Models\Solicitud\SolicitudTipo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Solicitud\User', 'user_created_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Solicitud\User', 'user_updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudBitacoras()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudBitacora');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudEjecuciones()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudEjecucion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudUnidades()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudUnidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudValidaciones()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudValidacion');
    }
}
