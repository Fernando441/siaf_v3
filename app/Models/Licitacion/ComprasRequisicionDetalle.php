<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_compras_id
 * @property string $descripcion
 * @property string $cantidad
 * @property float $importe
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property RequisicionCompra $requisicionCompra
 * @property User $user
 */
class ComprasRequisicionDetalle extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_compras_detalle';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_compras_id', 'descripcion', 'cantidad', 'obervaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function requisicionCompra()
    {
        return $this->belongsTo('App\Models\Licitacion\CompraRequisicion', 'requisicion_compras_id');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

}
