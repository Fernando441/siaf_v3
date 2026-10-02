<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property integer $taller_id
 * @property string $fecha_asignacion
 * @property integer $iduserCreated
 * @property Taller $taller
 * @property User $user
 * @property TallerSolicitud $tallerSolicitud
 */
class TallerAsignadoSolicitud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_asignado_solicitud';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'taller_id', 'fecha_asignacion', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taller()
    {
        return $this->belongsTo('App\Models\Taller\Taller');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitud()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitud');
    }
}
