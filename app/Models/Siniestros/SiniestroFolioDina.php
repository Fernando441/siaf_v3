<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $folio
 * @property integer $anio
 * @property string $created_at
 * @property string $updated_at
 */
class SiniestroFolioDina extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestros_registro_dina_folio';

    /**
     * @var array
     */
    protected $fillable = ['folio', 'anio', 'created_at', 'updated_at'];
}
