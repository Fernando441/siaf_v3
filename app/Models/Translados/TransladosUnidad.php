<?php

namespace App\Models\Translados;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $translados_id
 * @property integer $unidad_id
 * @property integer $id_transportista
 * @property string $fecha_translado
 * @property string $tipo_asignacion
 * @property string $created_at
 * @property string $updated_at
 * @property Unidad $unidad
 * @property Translado $translado
 * @property User $user
 */
class TransladosUnidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'translados_unidad';

    /**
     * @var array
     */
    protected $fillable = ['translados_id', 'unidad_id', 'id_transportista', 'fecha_translado', 'tipo_asignacion', 'created_at', 'updated_at', 'requerimiento', 'transladadora', 'origen', 'cto_origen', 'destino', 'cto_destino', 'estatus', 'recoleccion', 'inv_prov_sistema', 'observaciones', 'ubicacion_unidad_id'];

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
    public function translado()
    {
        return $this->belongsTo('App\Models\Translados\Translado', 'translados_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_transportista');
    }


    public function ubicacion()
    {
        return $this->belongsTo('App\Models\Unidad\UbicacionUnidad', 'ubicacion_unidad_id');
    }

}
