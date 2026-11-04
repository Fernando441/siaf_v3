<?php

namespace App\Models\Sistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $folio
 * @property integer $anio
 * @property string $created_at
 * @property string $updated_at
 */
class InventarioFolioComputo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'inventrio_equipo_computo_folio';

    /**
     * @var array
     */
    protected $fillable = ['folio', 'anio', 'created_at', 'updated_at'];
}
