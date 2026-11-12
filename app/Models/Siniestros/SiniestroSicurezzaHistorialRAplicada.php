<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $registro_sicurezza_id
 * @property float $recuperacion_aplicada
 * @property string $created_at
 * @property integer $iduserCreated
 * @property SiniestroRegistroSicurezza $siniestroRegistroSicurezza
 * @property User $user
 */
class SiniestroSicurezzaHistorialRAplicada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestro_registro_sicurezza_historial_raplicada';

    /**
     * @var array
     */
    protected $fillable = ['registro_sicurezza_id', 'recuperacion_aplicada', 'created_at', 'iduserCreated'];

    public function siniestroSicurezza()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestroSicurezza', 'registro_sicurezza_id');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
}
