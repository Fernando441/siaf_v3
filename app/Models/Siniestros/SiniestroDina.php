<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestros_agencia_id
 * @property string $no_siniestro
 * @property string $contratante
 * @property string $proyecto_poliza
 * @property string $nombre_proyecto
 * @property string $inicio
 * @property string $fin
 * @property string $moneda
 * @property integer $poliza
 * @property integer $serie
 * @property string $fecha_ocurrencia
 * @property string $tipo_siniestro_inicial
 * @property float $deducible
 * @property float $recuperacion_aplicada
 * @property string $nombre_agente
 * @property integer $modelo
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 * @property SiniestrosAgencium $siniestrosAgencium
 */
class SiniestroDina extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestros_registro_dina';

    /**
     * @var array
     */
    protected $fillable = ['siniestros_agencia_id', 'no_siniestro', 'contratante', 'proyecto_poliza', 'nombre_proyecto', 'inicio', 'fin', 'moneda', 'poliza', 'serie', 'fecha_ocurrencia', 'tipo_siniestro_inicial', 'deducible', 'recuperacion_aplicada', 'nombre_agente', 'modelo', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'no_folio', 'op_modificado', 'op_deducible', 'op_recuperacion_aplicada'];


    public function siniestrosAgencia()
    {
        return $this->belongsTo('App\Models\Siniestros', 'siniestros_agencia_id');
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
