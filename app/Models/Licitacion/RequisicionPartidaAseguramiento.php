<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $requisicion_partida_id
 * @property integer $requisicion_tipo_transporte_id
 * @property integer $id_status_delete
 * @property string $cantidad
 * @property string $vigencia
 * @property string $vigencia_fin
 * @property string $doc_aseguramiento
 * @property string $observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property RequisicionPartida $requisicionPartida
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property RequisicionTipoTransporte $requisicionTipoTransporte
 * @property User $user
 */
class RequisicionPartidaAseguramiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion_partida_aseguramiento';

    /**
     * @var array
     */
    protected $fillable = ['requisicion_partida_id', 'requisicion_tipo_transporte_id', 'id_status_delete', 'cantidad', 'vigencia', 'vigencia_fin', 'doc_aseguramiento', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'op_documento_aseg'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionPartida()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionPartida');
    }

    public function requisicionTipoTransporte()
    {
        return $this->belongsTo('App\Models\Licitacion\RequisicionTipoTransporte');
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
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Licitacion\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserUpdated');
    }


}
