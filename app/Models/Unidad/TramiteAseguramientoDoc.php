<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_aseguramiento_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property UnidadTramiteAseguramientoEvidencium $unidadTramiteAseguramientoEvidencium
 * @property UnidadTramiteAseguramientoInfo $unidadTramiteAseguramientoInfo
 * @property User $user
 */
class TramiteAseguramientoDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_aseguramiento_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_aseguramiento_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

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
    public function unidadTramiteAseguramientoEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteAseguramientoEvidencia', 'id_evidencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteAseguramientoInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteAseguramientoInfo');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
