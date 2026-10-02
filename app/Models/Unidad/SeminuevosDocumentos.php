<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_unidad_venta
 * @property string $documento
 * @property string $mime_type
 * @property string $descripcion
 * @property integer $iduserCreated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property UnidadVentum $unidadVentum
 */
class SeminuevosDocumentos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_unidad_venta', 'documento', 'mime_type', 'descripcion', 'iduserCreated', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Unidad\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadVenta()
    {
        return $this->belongsTo('App\Models\Unidad\UnidadVenta', 'id_unidad_venta');
    }
}
