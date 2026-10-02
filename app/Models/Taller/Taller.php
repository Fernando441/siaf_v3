<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $users_id
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $id_status_delete
 * @property string $alias
 * @property string $nombre
 * @property string $direccion
 * @property string $codigo_postal
 * @property string $referencia
 * @property string $tel_local
 * @property string $tel_celular
 * @property string $correo
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Estado $estado
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Municipio $municipio
 * @property User $user
 * @property User $user
 * @property TallerServicio[] $tallerServicios
 * @property TallerSolicitud[] $tallerSolicituds
 */
class Taller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller';

    /**
     * @var array
     */
    protected $fillable = ['users_id', 'estado_id', 'municipio_id', 'id_status_delete', 'alias', 'nombre', 'direccion', 'codigo_postal', 'referencia', 'tel_local', 'tel_celular', 'correo', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'coordenadas', 'motivo', 'calificacion', 'tel_tres', 'rfc', 'colonia', 'nombre_resp', 'correo', 'observaciones', 'user_taller'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', null, 'id_estado');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', null, 'id_municipio');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tallerServicios()
    {
        return $this->hasMany('App\Models\Taller\ServicioTaller');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tallerSolicitud()
    {
        return $this->hasMany('App\Models\Taller\TallerSolicitud');
    }


    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    public function userTaller()
    {
        return $this->belongsTo('App\Models\User', 'user_taller');
    }

}
