<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $pago_proyecto_id
 * @property integer $proyecto_id
 * @property integer $licitacion_id
 * @property integer $proyecto_penalizaciones_id
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $fecha_deductiva
 * @property float $monto_deductiva
 * @property string $deductiva_pago
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status_delete
 * @property User $user
 * @property PagoProyecto $pagoProyecto
 * @property Proyecto $proyecto
 * @property User $user
 * @property Licitacione $licitacione
 * @property ProyectoPenalizacione $proyectoPenalizacione
 */
class DeductivaPago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_deductiva_pago';

    /**
     * @var array
     */
    protected $fillable = ['pago_proyecto_id', 'proyecto_id', 'licitacion_id', 'proyecto_penalizaciones_id', 'iduserCreated', 'iduserUpdated', 'fecha_deductiva', 'monto_deductiva', 'deductiva_pago', 'created_at', 'updated_at', 'status_delete'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacion()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pagoProyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\PagoProyecto');
    }

    public function proyectoPenalizacione()
    {
        return $this->belongsTo('App\Models\Proyecto\PenalizacionesDeducciones', 'proyecto_penalizaciones_id');
    }
}
