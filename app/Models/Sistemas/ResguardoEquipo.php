<?php

namespace AppModelsSistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $resguardo_id
 * @property integer $computo_id
 * @property string $created_at
 * @property string $updated_at
 * @property InventarioEquipoComputo $inventarioEquipoComputo
 * @property Resguardo $resguardo
 */
class ResguardoEquipo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resguardo_equipo';

    /**
     * @var array
     */
    protected $fillable = ['resguardo_id', 'computo_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventarioEquipoComputo()
    {
        return $this->belongsTo('App\Models\Sistemas\InventarioComputo', 'computo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resguardo()
    {
        return $this->belongsTo('App\Models\Sistemas\Resguardo');
    }
}
