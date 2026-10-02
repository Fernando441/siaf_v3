<?php

namespace App\Models\Translados;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $translados_id
 * @property integer $unidad_id
 * @property string $documento
 * @property string $nombre
 * @property string $created_at
 * @property integer $iduserCreated
 * @property Unidad $unidad
 * @property Translado $translado
 * @property User $user
 */
class TrasladoUnidadDocumento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'traslado_unidad_documento';

    /**
     * @var array
     */
    protected $fillable = ['translados_id', 'unidad_id', 'documento', 'nombre', 'created_at', 'iduserCreated'];

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
        return $this->belongsTo('App\Models\Translados\Translados', 'translados_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
