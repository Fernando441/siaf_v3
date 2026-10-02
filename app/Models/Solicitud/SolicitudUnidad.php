<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $solicitud_id
 * @property integer $unidad_id
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitud $solicitud
 * @property Unidad $unidad
 */
class SolicitudUnidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_unidad';

    /**
     * @var array
     */
    protected $fillable = ['solicitud_id', 'unidad_id', 'created_at', 'updated_at'];

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
    public function unidad()
    {
        return $this->belongsTo('App\Models\Solicitud\Unidad');
    }
}
