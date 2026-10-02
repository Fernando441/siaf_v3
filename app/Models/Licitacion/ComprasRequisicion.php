<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $area_personal_id
 * @property integer $id_status_delete
 * @property string $titulo_requisicion
 * @property integer $op_estatus
 * @property string $fecha_requisicion
 * @property string $fecha_revision
 * @property string $fecha_pago
 * @property string $comentario
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property AreaPersonal $areaPersonal
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property RequisicionComprasDetalle[] $requisicionComprasDetalles
 */
class ComprasRequisicion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_compras';

    /**
     * @var array
     */
    protected $fillable = ['area_personal_id', 'id_status_delete', 'titulo_requisicion', 'op_estatus', 'fecha_requisicion', 'fecha_revision', 'fecha_pago', 'comentario', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'motivo_rechazo', 'op_rechazo'];


    public function areaPersonal()
    {
        return $this->belongsTo('App\Models\Licitacion\AreaPersonal');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ComprasDetalles()
    {
        return $this->hasMany('App\Models\Licitacion\ComprasRequisicionDetalle', 'requisicion_compras_id');
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
