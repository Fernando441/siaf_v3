<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_bajavehiculo_siniestro_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property UnidadTramiteBajavehiculoSiniestroInfo $unidadTramiteBajavehiculoSiniestroInfo
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadTramiteBajavehiculoSiniestroEvidencium $unidadTramiteBajavehiculoSiniestroEvidencium
 */
class TramiteBajavehiculoSiniestroDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_bajavehiculo_siniestro_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_bajavehiculo_siniestro_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTramiteBajavehiculoSiniestroInfo()
    {
        return $this->belongsTo('App\Models\Unidad\UnidadTramiteBajavehiculoSiniestroInfo');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteBajavehiculoSiniestroEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteBajavehiculoSiniestroEvidencia', 'id_evidencia');
    }
}
