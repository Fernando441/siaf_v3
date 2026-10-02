<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $estatus
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitud[] $solicituds
 * @property SolicitudBitacora[] $solicitudBitacoras
 */
class SolicitudEstatus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'solicitud_estatus';

    /**
     * @var array
     */
    protected $fillable = ['estatus', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud\Solicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudBitacoras()
    {
        return $this->hasMany('App\Models\Solicitud\SolicitudBitacora');
    }
}
