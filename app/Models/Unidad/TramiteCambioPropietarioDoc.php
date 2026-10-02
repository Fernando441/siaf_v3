<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_cambiopropietario_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property UnidadTramiteCambiopropietarioEvidencium $unidadTramiteCambiopropietarioEvidencium
 * @property UnidadTramiteCambiopropietarioInfo $unidadTramiteCambiopropietarioInfo
 * @property User $user
 */
class TramiteCambioPropietarioDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_cambiopropietario_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_cambiopropietario_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

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
    public function unidadTramiteCambiopropietarioEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteCambioPropietarioEvidencia', 'id_evidencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteCambiopropietarioInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteCambioPropietarioInfo');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
