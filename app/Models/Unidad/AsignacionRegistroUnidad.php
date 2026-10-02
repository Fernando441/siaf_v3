<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $licitaciones_id
 * @property integer $proyectos_id
 * @property integer $licitacion_proposicion_economica_id
 * @property integer $id_tipo_asignacion
 * @property integer $cliente_id
 * @property integer $ubicacion_id
 * @property string $fecha_asignacion
 * @property integer $op_asignacion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Licitacione $licitacione
 * @property UbicacionUnidad $ubicacionUnidad
 * @property UnidadTipoAsignacion $unidadTipoAsignacion
 * @property User $user
 * @property LicitacionProposicionEconomica $licitacionProposicionEconomica
 * @property Proyecto $proyecto
 * @property Unidad $unidad
 * @property User $user
 * @property User $user
 */
class AsignacionRegistroUnidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_registro_asignacion';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'licitaciones_id', 'proyectos_id', 'licitacion_proposicion_economica_id', 'id_tipo_asignacion', 'cliente_id', 'ubicacion_id', 'fecha_asignacion', 'op_asignacion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function ubicacionUnidad()
    {
        return $this->belongsTo('App\Models\Unidad\UbicacionUnidad', 'ubicacion_id');
    }


    public function cliente()
    {
        return $this->belongsTo('App\Models\User', 'cliente_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitaciones_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProposicionEconomica()
    {
        return $this->belongsTo('App\Models\Licitacion\ProposicionEconomica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'proyectos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTipoAsignacion()
    {
        return $this->belongsTo('App\Models\Unidad\TipoAsignacion', 'id_tipo_asignacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
