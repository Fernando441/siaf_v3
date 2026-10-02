<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $actividad_unidad_id
 * @property string $documento
 * @property string $hash_name
 * @property string $mime_type
 * @property integer $size
 * @property integer $activo
 * @property string $created_at
 * @property string $updated_at
 * @property ActividadUnidad $actividadUnidad
 */
class SolicitudDocumento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_documento';

    /**
     * @var array
     */
    protected $fillable = ['actividad_unidad_id', 'documento', 'hash_name', 'mime_type', 'size', 'activo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividadUnidad()
    {
        return $this->belongsTo('App\Models\Solicitud\ActividadUnidad');
    }
}
