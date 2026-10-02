<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $proyectos_id
 * @property integer $licitaciones_id
 * @property integer $cliente_id
 * @property integer $id_status_delete
 * @property string $periodo_inicial
 * @property string $periodo_final
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Client $client
 * @property Proyecto $proyecto
 * @property User $user
 * @property Licitacione $licitacione
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property ProyectoEstimacionesUnidade[] $proyectoEstimacionesUnidades
 */
class EstimacionesProyecto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_estimaciones';

    /**
     * @var array
     */
    protected $fillable = ['proyectos_id', 'licitaciones_id', 'cliente_id', 'id_status_delete', 'periodo_inicial', 'periodo_final', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'no_folio', 'estatus_envio', 'seguimiento_estimaciones', 'importe_estimacion', 'motivo_rechazo'];


    public function licitacion()
    {
        return $this->belongsTo('App\Models\Proyecto\Licitacion', 'licitaciones_id');
    }


    public function estimacionesUnidades()
    {
        return $this->hasMany('App\Models\Proyecto\EstimacionesUnidades', 'proyecto_estimaciones_id');
    }


    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente\Cliente', 'cliente_id', 'id_cliente');
    }


    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'proyectos_id');
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


}
