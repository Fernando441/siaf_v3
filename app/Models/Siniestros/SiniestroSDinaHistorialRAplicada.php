<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $registro_dina_id
 * @property float $recuperacion_aplicada
 * @property string $created_at
 * @property integer $iduserCreated
 * @property SiniestrosRegistroDina $siniestrosRegistroDina
 * @property User $user
 */
class SiniestroSDinaHistorialRAplicada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestros_registro_dina_historial_raplicada';

    /**
     * @var array
     */
    protected $fillable = ['registro_dina_id', 'recuperacion_aplicada', 'created_at', 'iduserCreated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siniestrosDina()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestrosRegistroDina', 'registro_dina_id');
    }
}
