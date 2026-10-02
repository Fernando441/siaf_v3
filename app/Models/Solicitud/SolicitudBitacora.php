<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_id
 * @property integer $solicitud_estatus_id
 * @property string $bitacora
 * @property string $created_at
 * @property string $updated_at
 * @property integer $activo
 * @property Solicitud $solicitud
 * @property SolicitudEstatus $solicitudEstatus
 */
class SolicitudBitacora extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_bitacora';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_id', 'solicitud_estatus_id', 'bitacora', 'created_at', 'updated_at', 'activo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud()
    {
        return $this->belongsTo('App\Models\Solicitud\Solicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudEstatus()
    {
        return $this->belongsTo('App\Models\Solicitud\SolicitudEstatus');
    }
}
