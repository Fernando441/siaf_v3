<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property string $folio
 * @property string $documento
 * @property integer $estatus
 * @property float $subtotal
 * @property float $total
 * @property string $iva
 * @property string $fecha_cotizacion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property TallerSolicitud $tallerSolicitud
 * @property User $user
 */
class CotizacionTaller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_cotizacion';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'folio', 'documento', 'estatus', 'subtotal', 'total', 'iva', 'fecha_cotizacion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

}
