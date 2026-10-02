<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $metodo_pago
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 * @property RequisicionOrdenProveedor[] $requisicionOrdenProveedors
 */
class RequisicionMetodoPago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_metodo_pago';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'clave' ,'metodo_pago', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];


    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
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
