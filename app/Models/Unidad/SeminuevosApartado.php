<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_unidad_venta
 * @property integer $id_unidad
 * @property integer $iduserCreated
 * @property integer $vendedor_user_id
 * @property integer $dias_apartado
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Unidad $unidad
 * @property UnidadVentum $unidadVentum
 */
class SeminuevosApartado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'seminuevos_apartado';

    /**
     * @var array
     */
    protected $fillable = ['id_unidad_venta', 'id_unidad', 'iduserCreated', 'vendedor_user_id', 'dias_apartado', 'activo', 'created_at', 'updated_at'];

    protected $casts = [
        'activo' => 'integer',
    ];

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
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad', 'id_unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadVentum()
    {
        return $this->belongsTo('App\Models\Unidad\UnidadVentum', 'id_unidad_venta');
    }
}
