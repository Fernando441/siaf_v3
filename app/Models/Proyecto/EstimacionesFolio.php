<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $folio
 * @property integer $anio
 * @property string $created_at
 * @property string $updated_at
 */
class EstimacionesFolio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_folio_estimaciones';

    /**
     * @var array
     */
    protected $fillable = ['folio', 'anio', 'created_at', 'updated_at'];
}
