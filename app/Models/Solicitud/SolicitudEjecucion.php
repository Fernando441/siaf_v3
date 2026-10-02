<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_id
 * @property string $fecha_actividad
 * @property string $nombre_tecnico
 * @property string $fecha_elaboracion
 * @property boolean $activo
 * @property string $created_at
 * @property string $updated_at
 * @property ActividadUnidad[] $actividadUnidads
 * @property Solicitud $solicitud
 */
class SolicitudEjecucion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_ejecucion';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_id', 'fecha_actividad', 'nombre_tecnico', 'fecha_elaboracion', 'activo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadUnidads()
    {
        return $this->hasMany('App\Models\Solicitud\ActividadUnidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitud()
    {
        return $this->belongsTo('App\Models\Solicitud\Solicitud');
    }
}
