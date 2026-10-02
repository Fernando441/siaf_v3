<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $unidad_informacion_propietario_id
 * @property integer $aseguradora_id
 * @property integer $tipo_cobertura_id
 * @property integer $id_status_delete
 * @property integer $unidad_tramite_gestor_id
 * @property string $fecha_inicial_seguro
 * @property string $fecha_final_seguro
 * @property string $no_poliza
 * @property string $observaciones
 * @property integer $op_estatus
 * @property float $importe
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $descripcion
 * @property string $modelo
 * @property string $serie
 * @property string $uso_unidad_poliza
 * @property float $valor_eq_esp
 * @property float $valor_adaptacion
 * @property string $nombre_archivo_poliza
 * @property string $inciso
 * @property float $prima_neta
 * @property float $recargos
 * @property float $gastos_exp
 * @property float $sub_total
 * @property float $iva
 * @property float $prima_total
 * @property float $primer_recibo
 * @property float $recibos_sub
 * @property UnidadTramiteAseguramientoDoc[] $unidadTramiteAseguramientoDocs
 * @property User $user
 * @property AseguradoraUnidad $aseguradoraUnidad
 * @property Unidad $unidad
 * @property UnidadTipoCobertura $unidadTipoCobertura
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property UnidadInformacionPropietario $unidadInformacionPropietario
 * @property UnidadTramiteGestor $unidadTramiteGestor
 */
class TramiteAseguramientoInfo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_tramite_aseguramiento_info';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'unidad_informacion_propietario_id', 'aseguradora_id', 'tipo_cobertura_id', 'id_status_delete', 'unidad_tramite_gestor_id', 'fecha_inicial_seguro', 'fecha_final_seguro', 'no_poliza', 'observaciones', 'op_estatus', 'importe', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'descripcion', 'modelo', 'serie', 'uso_unidad_poliza', 'valor_eq_esp', 'valor_adaptacion', 'nombre_archivo_poliza', 'inciso', 'prima_neta', 'recargos', 'gastos_exp', 'sub_total', 'iva', 'prima_total', 'primer_recibo', 'recibos_sub', 'valor_factura', 'fecha_factura_eq_esp', 'fecha_factura_adaptacion', 'servicio', 'tramite_estatus', 'orden_trabajo'];


    public function TramiteAseguramientoEstatus()
    {
        return $this->hasMany('App\Models\Unidad\TramiteAseguramientoEstatus', 'tramite_estatus');
    }


    public function TramiteGestor()
    {
        return $this->belongsTo('App\Models\Unidad\TramiteGestor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TramiteAseguramientoDoc()
    {
        return $this->hasMany('App\Models\Unidad\TramiteAseguramientoDoc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadTipoCobertura()
    {
        return $this->belongsTo('App\Models\Unidad\TipoCobertura', 'tipo_cobertura_id');
    }


    public function InformacionPropietario()
    {
        return $this->belongsTo('App\Models\Unidad\InformacionPropietario');
    }

    public function aseguradoraUnidad()
    {
        return $this->belongsTo('App\Models\Unidad\AseguradoraUnidad', 'aseguradora_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
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
