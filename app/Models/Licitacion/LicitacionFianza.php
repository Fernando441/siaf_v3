<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitaciones_id
 * @property integer $tipo_fianza_id
 * @property integer $afianzadoras_id
 * @property string $vigencia_inicial
 * @property string $vigencia_final
 * @property string $documento
 * @property integer $porcentaje
 * @property integer $iduserCreated
 * @property string $created_at
 * @property integer $iduserUpdated
 * @property string $updated_at
 * @property User $user
 * @property LicitacionTipoFianza $licitacionTipoFianza
 * @property User $user
 * @property Afianzadora $afianzadora
 * @property Licitacione $licitacione
 */
class LicitacionFianza extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_fianza';

    /**
     * @var array
     */
    protected $fillable = ['licitaciones_id', 'tipo_fianza_id', 'afianzadoras_id', 'vigencia_inicial', 'vigencia_final', 'documento', 'porcentaje', 'iduserCreated', 'created_at', 'iduserUpdated', 'updated_at'];


    public function licitacionTipoFianza()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionTipoFianza', 'tipo_fianza_id');
    }


    public function afianzadora()
    {
        return $this->belongsTo('App\Models\Licitacion\Afianzadora', 'afianzadoras_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitaciones_id');
    }
     

    public function userCreated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserUpdated');
    }

}
