<?php

namespace App\Models\Sistemas;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_compras_id
 * @property integer $user_asignado
 * @property integer $id_status_delete
 * @property string $no_folio
 * @property string $no_serie
 * @property string $marca
 * @property string $modelo
 * @property string $descripcion
 * @property string $fecha_ingreso
 * @property integer $estatus_asignado
 * @property string $motivo_delete
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionCompra $requisicionCompra
 * @property User $user
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class InventarioComputo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'inventario_equipo_computo';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_compras_id', 'user_asignado', 'id_status_delete', 'no_folio', 'no_serie', 'marca', 'modelo', 'descripcion', 'fecha_ingreso', 'estatus_asignado', 'motivo_delete', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'tipo_equipo_id', 'op_requisicion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionCompra()
    {
        return $this->belongsTo('App\Models\Licitacion\ComprasRequisicion', 'requisicion_compras_id');
    }

    public function Tipoequipo()
    {
        return $this->belongsTo('App\Models\Sistemas\InventarioTipoComputo', 'tipo_equipo_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAsignado()
    {
        return $this->belongsTo('App\Models\User', 'user_asignado');
    }

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
