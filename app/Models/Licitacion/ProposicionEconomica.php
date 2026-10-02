<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitacion_id
 * @property integer $segmento_id
 * @property string $cantidad
 * @property float $precio_unitario
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Licitacione $licitacione
 * @property User $user
 * @property Segmento $segmento
 * @property User $user
 */
class ProposicionEconomica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_proposicion_economica';

    /**
     * @var array
     */
    protected $fillable = ['licitacion_id', 'segmento_id', 'cantidad', 'precio_unitario', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'partida', 'cantidad_maxima', 'precio_unitario_maximo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacione()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmento()
    {
        return $this->belongsTo('App\Models\Segmento\Segmento');
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
