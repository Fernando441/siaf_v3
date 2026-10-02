<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $orden_compra_id
 * @property integer $proveedor_id
 * @property integer $requisicion_id
 * @property integer $requisicion_documentos_compras_id
 * @property string $documento
 * @property string $mime_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionOrdenCompra $requisicionOrdenCompra
 * @property User $user
 * @property RequisicionDocumentosCompra $requisicionDocumentosCompra
 * @property RequisicionOrdenProveedor $requisicionOrdenProveedor
 * @property User $user
 * @property Requisicion $requisicion
 */
class RequisicionEvidenciaCompra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_evidencia_compra';

    /**
     * @var array
     */
    protected $fillable = ['orden_compra_id', 'proveedor_id', 'requisicion_id', 'requisicion_documentos_compras_id', 'documento', 'mime_type', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
    public function requisicionDocumentosCompra()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionDocumentosCompras', 'requisicion_documentos_compras_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionOrdenProveedor()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionOrdenProveedor', 'proveedor_id');
    }


    public function requisicion()
    {
        return $this->belongsTo('App\Models\Requisicion\Requisicion');
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
