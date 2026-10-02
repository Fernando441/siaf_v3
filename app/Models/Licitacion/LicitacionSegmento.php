<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitacion_id
 * @property integer $afianzadoras_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $observaciones
 * @property string $numero_sostenibilidad
 * @property float $importe
 * @property string $vigencia_fianza
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Afianzadora $afianzadora
 * @property User $user
 * @property Licitacione $licitacione
 * @property User $user
 */
class LicitacionSegmento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_segmento';

    /**
     * @var array
     */
    protected $fillable = ['licitacion_id', 'afianzadoras_id', 'created_at', 'updated_at', 'observaciones', 'precio_cotizar', 'precio_cotizar_diario', 'precio_cotizar_mes', 'precio_cotizar_anual' ,'numero_sostenibilidad', 'importe', 'vigencia_fianza', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afianzadora()
    {
        return $this->belongsTo('App\Models\Licitacion\Afianzadora', 'afianzadoras_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitacion_id');
    }

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
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
