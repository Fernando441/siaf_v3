<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $siniestro_hdi_id
 * @property float $deducible
 * @property string $created_at
 * @property integer $iduserUpdated
 * @property SiniestroRegistroHdi $siniestroRegistroHdi
 * @property User $user
 */
class SiniestroHdiHistorial extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestro_registro_hdi_historial';

    /**
     * @var array
     */
    protected $fillable = ['siniestro_hdi_id', 'deducible', 'created_at', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siniestroRegistroHdi()
    {
        return $this->belongsTo('App\Models\Siniestros\SiniestroHdi', 'siniestro_hdi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

}
