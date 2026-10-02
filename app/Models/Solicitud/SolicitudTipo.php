<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $tipo
 * @property integer $activo
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitud[] $solicituds
 */
class SolicitudTipo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_tipo';

    /**
     * @var array
     */
    protected $fillable = ['tipo', 'activo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud\Solicitud');
    }
}
