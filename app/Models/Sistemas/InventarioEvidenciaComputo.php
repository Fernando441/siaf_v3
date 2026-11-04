<?php

namespace App\Models\Sistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_inventario
 * @property integer $tipo_evidencia_id
 * @property string $documento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property InventarioEquipoComputo $inventarioEquipoComputo
 * @property User $user
 * @property InventarioEquipoComputoTipoevidencium $inventarioEquipoComputoTipoevidencium
 * @property User $user
 */
class InventarioEvidenciaComputo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'inventario_equipo_computo_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['id_inventario', 'tipo_evidencia_id', 'documento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventarioEquipoComputo()
    {
        return $this->belongsTo('App\Models\Sistemas\InventarioComputo', 'id_inventario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventarioEquipoComputoTipoevidencia()
    {
        return $this->belongsTo('App\Models\Sistemas\InventarioTipoEvidenciaComputo', 'tipo_evidencia_id');
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
