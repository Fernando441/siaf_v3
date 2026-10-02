<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_ejecucion_id
 * @property integer $unidad_id
 * @property integer $solicitud_documento_id
 * @property string $idgps
 * @property string $comentarios
 * @property string $created_at
 * @property string $updated_at
 * @property SolicitudDocumento $solicitudDocumento
 * @property SolicitudEjecucion $solicitudEjecucion
 * @property Unidad $unidad
 */
class ActividadUnidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actividad_unidad';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_ejecucion_id', 'unidad_id', 'solicitud_documento_id', 'idgps', 'comentarios', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudDocumento()
    {
        return $this->belongsTo('App\Models\Solicitud\SolicitudDocumento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudEjecucion()
    {
        return $this->belongsTo('App\Models\Solicitud\SolicitudEjecucion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Solicitud\Unidad');
    }
}
