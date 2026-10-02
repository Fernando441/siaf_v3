<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_asignacion
 * @property integer $unidad_id
 * @property integer $id_patio
 * @property integer $id_requisicion
 * @property string $fecha_asignacion
 * @property integer $iduserCreated
 * @property integer $op_asignacion
 * @property Requisicion $requisicion
 * @property Unidad $unidad
 * @property AsignacionUnidadLog $asignacionUnidadLog
 * @property UbicacionUnidad $ubicacionUnidad
 * @property User $user
 */
class AsignacionTotalUnidades extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_asignacion', 'unidad_id', 'id_patio', 'id_requisicion', 'fecha_asignacion', 'iduserCreated', 'op_asignacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicion()
    {
        return $this->belongsTo('App\Models\Requisicion\Requisicion', 'id_requisicion');
    }


    public function ubicacionUnidad()
    {
        return $this->belongsTo('App\Models\Unidad\UbicacionUnidad', 'id_patio');
    }

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
    public function asignacionUnidadLog()
    {
        return $this->belongsTo('App\Models\Logistica\AsignacionLogistica', 'id_asignacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

}
