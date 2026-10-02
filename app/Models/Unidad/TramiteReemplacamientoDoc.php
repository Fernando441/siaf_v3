<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_reemplacamiento_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property UnidadTramiteReemplacamientoEvidencium $unidadTramiteReemplacamientoEvidencium
 * @property UnidadTramiteReemplacamientoInfo $unidadTramiteReemplacamientoInfo
 * @property User $user
 */
class TramiteReemplacamientoDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_reemplacamiento_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_reemplacamiento_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

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
    public function unidadTramiteEmplacamientoInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteReemplacamientoInfo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTramiteEmplacamientoEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteReemplacamientoEvidencia', 'id_evidencia');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
