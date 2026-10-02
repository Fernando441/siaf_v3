<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitaciones_id
 * @property integer $afianzadoras_id
 * @property string $documento_rc
 * @property integer $porcentajerc
 * @property string $vigencia_inicialrc
 * @property string $vigencia_finalrc
 * @property integer $iduserCreated
 * @property string $created_at
 * @property integer $iduserUpdated
 * @property string $updated_at
 * @property User $user
 * @property Afianzadora $afianzadora
 * @property User $user
 * @property Licitacione $licitacione
 */
class LicitacionSeguroRC extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_seguros_rc';

    /**
     * @var array
     */
    protected $fillable = ['licitaciones_id', 'afianzadoras_id', 'documento_rc', 'porcentajerc', 'vigencia_inicialrc', 'vigencia_finalrc', 'iduserCreated', 'created_at', 'iduserUpdated', 'updated_at'];



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
