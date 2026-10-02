<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_id
 * @property integer $requisicion_grupo_id
 * @property string $documento
 * @property string $mime_type
 * @property float $monto
 * @property string $fecha
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property User $user
 * @property RequisicionGrupo $requisicionGrupo
 * @property Requisicion $requisicion
 */
class RequisicionConversion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_conversion';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_id', 'requisicion_grupo_id', 'documento', 'mime_type', 'monto', 'fecha', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionGrupo()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionGrupo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicion()
    {
        return $this->belongsTo('App\Models\Licitacion\Requisicion');
    }
}
