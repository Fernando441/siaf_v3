<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $motivo_id
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $unidad_id_base
 * @property integer $proyectos_id
 * @property string $fecha_hora_solicitud
 * @property string $descripcion_motivo
 * @property string $calle
 * @property string $colonia
 * @property string $codigo_postal
 * @property string $nombre_responsable
 * @property string $email
 * @property string $telefono
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $estatus
 * @property Unidad $unidad
 * @property User $user
 * @property Municipio $municipio
 * @property SustitutoMotivo $sustitutoMotivo
 * @property User $user
 * @property Estado $estado
 * @property Proyecto $proyecto
 */
class SustitutoSolicitud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sustituto_solicitud';

    /**
     * @var array
     */
    protected $fillable = ['motivo_id', 'estado_id', 'municipio_id', 'unidad_id_base', 'proyectos_id', 'fecha_hora_solicitud', 'descripcion_motivo', 'calle', 'colonia', 'codigo_postal', 'nombre_responsable', 'email', 'telefono', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'estatus', 'id_status_delete', 'enviada_logistica', 'env_logistica_id', 'op_unidad_sustituta', 'unidad_id_sustituta', 'op_traslado', 'id_estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad', 'unidad_id_base');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', 'id_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sustitutoMotivo()
    {
        return $this->belongsTo('App\Models\Logistica\SustitutoMotivo', 'motivo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'id_estado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'proyectos_id');
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

    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function userenvlogistica()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'env_logistica_id');
    }

    public function unidadsustituta()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad', 'unidad_id_sustituta');
    }

}
