<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_verificacion_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property UnidadTramiteVerificacionEvidencium $unidadTramiteVerificacionEvidencium
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadTramiteVerificacionInfo $unidadTramiteVerificacionInfo
 */
class TramiteVerificacionDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_verificacion_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_verificacion_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteVerificacionEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteVerificacionEvidencia', 'id_evidencia');
    }


    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }


    public function TramiteVerificacionInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteVerificacionInfo');
    }


    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

}
