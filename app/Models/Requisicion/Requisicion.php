<?php

namespace App\Models\Requisicion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitaciones_id
 * @property integer $requisicion_estatus_id
 * @property integer $solicitante
 * @property integer $id_area
 * @property integer $id_status_delete
 * @property integer $iduservistobueno
 * @property string $folio
 * @property string $fecha_entrega
 * @property string $fecha_solicitud
 * @property string $motivo_finanzas
 * @property string $motivo_desactivar
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property integer $visto_bueno_operaciones
 * @property string $hora_vistobueno
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property User $user
 * @property AreaPersonal $areaPersonal
 * @property RequisicionEstatus $requisicionEstatus
 * @property User $user
 * @property User $user
 * @property Licitacione $licitacione
 * @property RequisicionOrdenCompra[] $requisicionOrdenCompras
 * @property RequisicionPartida[] $requisicionPartidas
 * @property Unidad[] $unidads
 */
class Requisicion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'requisicion';

    /**
     * @var array
     */
    protected $fillable = ['licitaciones_id', 'requisicion_estatus_id', 'solicitante', 'id_area', 'id_status_delete', 'iduservistobueno', 'folio', 'fecha_entrega', 'fecha_solicitud', 'motivo_finanzas', 'motivo_desactivar', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'visto_bueno_operaciones', 'hora_vistobueno'];

 
    public function licitaciones()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitaciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function areaPersonal()
    {
        return $this->belongsTo('App\Models\Requisicion\AreaPersonal', 'id_area');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Requisicion\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requisicionEstatus()
    {
        return $this->belongsTo('App\Models\Requisicion\RequisicionEstatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisicionPartidas()
    {
        return $this->hasMany('App\Models\Requisicion\RequisicionPartida');
    }

    public function usersolicitante()
    {
        return $this->belongsTo('App\Models\User', 'solicitante');
    }

    public function uservistobueno()
    {
        return $this->belongsTo('App\Models\User', 'iduservistobueno');
    }


}
