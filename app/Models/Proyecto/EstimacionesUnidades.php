<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $segmentos_id
 * @property integer $proyecto_estimaciones_id
 * @property integer $licitaciones_id
 * @property integer $proyectos_id
 * @property string $dias_trabajo
 * @property string $precio_segmento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Unidad $unidad
 * @property User $user
 * @property ProyectoEstimacione $proyectoEstimacione
 * @property Segmento $segmento
 * @property User $user
 * @property Licitacione $licitacione
 * @property Proyecto $proyecto
 */
class EstimacionesUnidades extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_estimaciones_unidades';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'segmentos_id', 'proyecto_estimaciones_id', 'licitaciones_id', 'proyectos_id', 'dias_trabajo', 'precio_segmento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function segmento()
    {
        return $this->belongsTo('App\Models\Segmento\Segmento', 'segmentos_id');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
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
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'proyectos_id');
    }


    public function proyectoEstimaciones()
    {
        return $this->belongsTo('App\Models\Proyecto\EstimacionesProyecto', 'proyecto_estimaciones_id');
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
