<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_tipo_solicitud_id
 * @property integer $unidad_id
 * @property integer $taller_solicitud_estado_id
 * @property integer $taller_id
 * @property integer $proveedores_id
 * @property integer $proveedor_cuentas_id
 * @property integer $proveedor_direccion_id
 * @property string $tipo_solicitud
 * @property string $fecha_solicitud
 * @property string $fecha_cita
 * @property string $kilometraje
 * @property string $observaciones
 * @property string $domicilio
 * @property string $codigo_postal
 * @property string $concepto
 * @property string $descripcion_falla
 * @property string $importe
 * @property boolean $traslado
 * @property string $diagnostico
 * @property string $cotizacion
 * @property string $tiempo_reparacion
 * @property boolean $pagado
 * @property boolean $terminado
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Proveedore $proveedore
 * @property ProveedorCuenta $proveedorCuenta
 * @property ProveedorDireccion $proveedorDireccion
 * @property Taller $taller
 * @property TallerSolicitudEstado $tallerSolicitudEstado
 * @property TallerTipoSolicitud $tallerTipoSolicitud
 * @property Unidad $unidad
 * @property User $user
 * @property User $user
 * @property TallerSolicitudDocumento[] $tallerSolicitudDocumentos
 */
class TallerSolicitud extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_solicitud';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['taller_tipo_solicitud_id', 'unidad_id', 'taller_solicitud_estado_id', 'proveedores_id', 'proveedor_cuentas_id', 'proveedor_direccion_id', 'tipo_solicitud', 'fecha_solicitud', 'fecha_cita', 'kilometraje', 'observaciones', 'domicilio', 'codigo_postal', 'concepto', 'descripcion_falla', 'importe', 'traslado', 'diagnostico', 'cotizacion', 'tiempo_reparacion', 'pagado', 'terminado', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'id_proceso', 'op_taller', 'sustituto', 'op_validacion', 'fecha_validacion', 'user_validacion', 'motivo', 'ejecutivo_mantenimiento', 'importe_total', 'prioridad', 'fecha_autorizacion', 'user_autorizacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Unidad\Proveedores', 'proveedores_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedorCuentas()
    {
        return $this->belongsTo('App\Models\Unidad\ProveedorCuentas', 'proveedor_cuentas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedorDireccion()
    {
        return $this->belongsTo('App\Models\Unidad\ProveedorDireccion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function taller()
    // {
    //     return $this->belongsTo('App\Models\Taller\Taller');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitudEstado()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitudEstado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerTipoSolicitud()
    {
        return $this->belongsTo('App\Models\Taller\TallerTipoSolicitud');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tallerSolicitudDocumentos()
    {
        return $this->hasMany('App\Models\Taller\TallerSolicitudDocumento');
    }

    public function userValidacion()
    {
        return $this->belongsTo('App\Models\User', 'user_validacion');
    }

    

    public function ejecutivomantenimiento()
    {
        return $this->belongsTo('App\Models\User', 'ejecutivo_mantenimiento');
    }

    public function userAutorizacion()
    {
        return $this->belongsTo('App\Models\User', 'user_autorizacion');
    }


}
