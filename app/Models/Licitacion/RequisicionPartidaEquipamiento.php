<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_partida_id
 * @property integer $id_status_delete
 * @property integer $requisicion_grupo_id
 * @property string $archivo_equipamiento
 * @property string $cantidad
 * @property string $observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionPartida $requisicionPartida
 * @property User $user
 * @property RequisicionGrupo $requisicionGrupo
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class RequisicionPartidaEquipamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_partida_equipamiento';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_partida_id', 'id_status_delete', 'requisicion_grupo_id', 'archivo_equipamiento', 'cantidad', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function requisicionGrupo()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionGrupo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionPartida()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionPartida');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Licitacion\SiafStatus', 'id_status_delete');
    }

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


}
