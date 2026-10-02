<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_tramite_bajavehiculo_venta_info_id
 * @property integer $id_evidencia
 * @property string $documento
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property UnidadTramiteBajavehiculoEvidencium $unidadTramiteBajavehiculoEvidencium
 * @property UnidadTramiteBajavehiculoVentaInfo $unidadTramiteBajavehiculoVentaInfo
 * @property User $user
 */
class TramiteBajaVehiculoVentaDoc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_bajavehiculo_venta_doc';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_tramite_bajavehiculo_venta_info_id', 'id_evidencia', 'documento', 'created_at', 'iduserCreated'];

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
    public function unidadTramiteBajavehiculoEvidencia()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteBajavehiculoEvidencia', 'id_evidencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TramiteBajavehiculoVentaInfo()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteBajavehiculoVentaInfo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
