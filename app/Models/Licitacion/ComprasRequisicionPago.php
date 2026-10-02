<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_compras_id
 * @property string $documento
 * @property string $importe
 * @property string $created_at
 * @property integer $iduserCreated
 * @property User $user
 * @property RequisicionCompra $requisicionCompra
 */
class ComprasRequisicionPago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_compras_finanzas';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_compras_id', 'documento', 'importe', 'created_at', 'iduserCreated'];

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
    public function requisicionCompra()
    {
        return $this->belongsTo('App\Models\Licitacion\ComprasRequisicion', 'requisicion_compras_id');
    }
}
