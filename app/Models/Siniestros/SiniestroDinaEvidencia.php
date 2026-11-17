<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestros_dina_id
 * @property integer $tipo_documento_id
 * @property string $documento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiniestrosTipoDocumento $siniestrosTipoDocumento
 * @property User $user
 * @property SiniestrosRegistroDina $siniestrosRegistroDina
 */
class SiniestroDinaEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestros_registro_dina_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['siniestros_dina_id', 'tipo_documento_id', 'documento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SiniestroTipoDocumento()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestroTipoDocumento', 'tipo_documento_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SiniestroDina()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestrosRegistroDina', 'siniestros_dina_id');
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
