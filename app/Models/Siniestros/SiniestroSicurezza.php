<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestros_agencia_id
 * @property integer $siniestro_completo
 * @property string $proyecto
 * @property string $fecha_ocurrencia
 * @property string $causa_enfermedad
 * @property float $recuperacion_aplicada
 * @property float $deducibles
 * @property string $nombre_agente
 * @property string $asegurado
 * @property integer $modelo
 * @property integer $serie
 * @property string $descripcion_auto
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property SiniestrosAgencium $siniestrosAgencium
 * @property User $user
 * @property User $user
 */
class SiniestroSicurezza extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestro_registro_sicurezza';

    /**
     * @var array
     */
    protected $fillable = ['siniestros_agencia_id', 'siniestro_completo', 'proyecto', 'fecha_ocurrencia', 'causa_enfermedad', 'recuperacion_aplicada', 'deducibles', 'nombre_agente', 'asegurado', 'modelo', 'serie', 'descripcion_auto', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'no_folio', 'op_modificado', 'op_deducible', 'op_recuperacion_aplicada'];

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
