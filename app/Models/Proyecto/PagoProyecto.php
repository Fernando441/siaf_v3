<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitacion_id
 * @property integer $id_proyecto
 * @property string $fecha_pago
 * @property float $monto
 * @property string $factura
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property User $user
 * @property Licitacione $licitacione
 * @property ProyectoDeductivaPago[] $proyectoDeductivaPagos
 */
class PagoProyecto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago_proyecto';

    /**
     * @var array
     */
    protected $fillable = ['licitacion_id', 'id_proyecto', 'fecha_pago', 'monto', 'factura', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoDeductivaPagos()
    {
        return $this->hasMany('App\Models\Proyecto\ProyectoDeductivaPago');
    }
}
