<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_tenencia_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property UnidadTramiteTenenciaInfo $unidadTramiteTenenciaInfo
 * @property UnidadTramiteTenenciaEvidencium $unidadTramiteTenenciaEvidencium
 * @property User $user
 */
class TramiteTenenciaDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_tenencia_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_tenencia_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

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
    public function TramiteTenenciaInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteTenenciaInfo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTramiteTenenciaEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteTenenciaEvidencia', 'id_evidencia');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
