<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $orden_compra_id
 * @property integer $proveedores_id
 * @property integer $forma_pago_id
 * @property integer $metodo_pago_id
 * @property string $uso_cfdi
 * @property float $precio_unitario
 * @property string $created_at
 * @property string $updated_at
 * @property RequisicionOrdenPartida[] $requisicionOrdenPartidas
 * @property RequisicionOrdenCompra $requisicionOrdenCompra
 * @property Proveedore $proveedore
 * @property RequisicionMetodoPago $requisicionMetodoPago
 * @property RequisicionFormaPago $requisicionFormaPago
 */
class RequisicionOrdenProveedor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_orden_proveedor';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['orden_compra_id', 'proveedores_id', 'forma_pago_id', 'metodo_pago_id', 'uso_cfdi', 'precio_unitario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionOrdenCompra()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionOrdenCompra', 'orden_compra_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Unidad\Proveedor', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionMetodoPago()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionMetodoPago', 'metodo_pago_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionFormaPago()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionFormaPago', 'forma_pago_id');
    }
}
