<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_gps_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property UnidadTramiteGpsEvidencium $unidadTramiteGpsEvidencium
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadTramiteGpsInfo $unidadTramiteGpsInfo
 */
class TramiteGpsDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_gps_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteGpsEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGpsEvidencia', 'id_evidencia');
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
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTramiteGpsInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGpsInfo');
    }
}
