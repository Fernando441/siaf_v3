<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_id
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $comentarios
 * @property integer $activo
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitud $solicitud
 * @property SolicitudValidacion[] $solicitudValidacions
 */
class SolicitudTecnico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_tecnico';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_id', 'nombre', 'direccion', 'telefono', 'comentarios', 'activo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud()
    {
        return $this->belongsTo('App\Models\Solicitud\Solicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudValidacions()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudValidacion');
    }
}
