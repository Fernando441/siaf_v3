<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitaciones_id
 * @property string $num
 * @property string $nombre_requerimiento
 * @property string $descripcion
 * @property string $obligatorio
 * @property string $respuesta
 * @property string $acciones
 * @property Licitacione $licitacione
 */
class LicitacionPropuestaCargaPreliminar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_propuesta_cargapreliminar';

    /**
     * @var array
     */
    protected $fillable = ['licitaciones_id', 'num', 'nombre_requerimiento', 'descripcion', 'obligatorio', 'respuesta', 'acciones'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitaciones_id');
    }
}
