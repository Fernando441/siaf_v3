<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_gestor
 * @property string $documento
 * @property string $mime_type
 * @property integer $iduserCreated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property UnidadTramiteGestor $unidadTramiteGestor
 */
class GestorDocumento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_gestor', 'documento', 'mime_type', 'iduserCreated', 'created_at', 'updated_at'];

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
    public function unidadTramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\UnidadTramiteGestor', 'id_gestor');
    }
}
