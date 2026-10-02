<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitaciones_id
 * @property string $num
 * @property string $nombre_requerimiento
 * @property string $descripcion
 * @property string $obligatorio
 * @property string $respuesta
 * @property string $acciones
 * @property string $archivo_propuesta
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property Licitacione $licitacione
 * @property User $user
 */
class LicitacionPropuestaCargaFinal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_propuesta_cargafinal';

    /**
     * @var array
     */
    protected $fillable = ['licitaciones_id', 'num', 'nombre_requerimiento', 'descripcion', 'obligatorio', 'respuesta', 'acciones', 'archivo_propuesta', 'seccion' ,'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];


    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitaciones_id');
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
