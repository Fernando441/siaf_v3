<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestro_hdi_id
 * @property integer $tipo_documento_id
 * @property string $documento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property SiniestrosTipoDocumento $siniestrosTipoDocumento
 * @property User $user
 * @property SiniestroRegistroHdi $siniestroRegistroHdi
 * @property User $user
 */
class SiniestroHdiEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestro_registro_hdi_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['siniestro_hdi_id', 'tipo_documento_id', 'documento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
    public function siniestroRegistroHdi()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestroHdi', 'siniestro_hdi_id');
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
