<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property string $documento
 * @property string $tipo_documento
 * @property string $importe
 * @property string $observaciones
 * @property string $created_at
 * @property integer $iduserCreated
 * @property TallerSolicitud $tallerSolicitud
 * @property User $user
 */
class TallerPagoFinanzas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_documento_finanzas';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'documento', 'tipo_documento', 'importe', 'observaciones', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitud()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitud');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

}
