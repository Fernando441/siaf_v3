<?php

namespace App\Models\Sistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $inventario_id
 * @property integer $user_asignado
 * @property integer $user_asigno
 * @property integer $op_asignado
 * @property string $fecha_asignacion
 * @property string $fecha_retiro
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property InventarioEquipoComputo $inventarioEquipoComputo
 * @property User $user
 */
class InventarioComputoBitacora extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'inventario_equipo_computo_bitacora';

    /**
     * @var array
     */
    protected $fillable = ['inventario_id', 'user_asignado', 'user_asigno', 'op_asignado', 'fecha_asignacion', 'fecha_retiro', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAsignado()
    {
        return $this->belongsTo('App\Models\User', 'user_asignado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventarioEquipoComputo()
    {
        return $this->belongsTo('App\Models\Sistemas\InventarioComputo', 'inventario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAsigno()
    {
        return $this->belongsTo('App\Models\User', 'user_asigno');
    }
}
