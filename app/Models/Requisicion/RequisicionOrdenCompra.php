<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_id
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Requisicion $requisicion
 * @property User $user
 * @property RequisicionOrdenProveedor[] $requisicionOrdenProveedors
 */
class RequisicionOrdenCompra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_orden_compra';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_id', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
    
    public function requisicion()
    {
        return $this->belongsTo('App\Models\Requisicion\Requisicion');
    }

}
