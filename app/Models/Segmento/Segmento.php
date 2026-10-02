<?php

namespace App\Models\Segmento;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property integer $tipo_vehiculo_id
 * @property integer $puerta_id
 * @property integer $carroceria_id
 * @property integer $no_cilindro_id
 * @property integer $cilindro_id
 * @property integer $pasajero_id
 * @property integer $motor_id
 * @property integer $capacidad_id
 * @property integer $llanta_refaccion_id
 * @property integer $potencia_id
 * @property integer $transmision_id
 * @property integer $gps_id
 * @property integer $radio_id
 * @property integer $direccion_id
 * @property integer $blindaje_id
 * @property integer $en_inventario_id
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property string $espejos_laterales
 * @property string $accesorios
 * @property LicitacionProposicionEconomica[] $licitacionProposicionEconomicas
 * @property SegmentoTipoVehiculo $segmentoTipoVehiculo
 * @property SegmentoNoCilindro $segmentoNoCilindro
 * @property SegmentoDireccion $segmentoDireccion
 * @property SiafStatus $siafStatus
 * @property SegmentoPotencium $segmentoPotencium
 * @property SegmentoGp $segmentoGp
 * @property SegmentoCapacidad $segmentoCapacidad
 * @property User $user
 * @property SegmentoRadio $segmentoRadio
 * @property SegmentoMotor $segmentoMotor
 * @property SegmentoCilindro $segmentoCilindro
 * @property SegmentoTransmision $segmentoTransmision
 * @property SegmentoPasajero $segmentoPasajero
 * @property SegmentoEnInventario $segmentoEnInventario
 * @property SegmentoBlindaje $segmentoBlindaje
 * @property User $user
 * @property SegmentoPuertum $segmentoPuertum
 * @property SegmentoLlantaRefaccion $segmentoLlantaRefaccion
 * @property SegmentoCarrocerium $segmentoCarrocerium
 */
class Segmento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'tipo_vehiculo_id', 'puerta_id', 'carroceria_id', 'no_cilindro_id', 'cilindro_id', 'pasajero_id', 'motor_id', 'capacidad_id', 'llanta_refaccion_id', 'potencia_id', 'transmision_id', 'gps_id', 'radio_id', 'direccion_id', 'blindaje_id', 'en_inventario_id', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at', 'espejos_laterales', 'accesorios', 'motivo_desactivar'];


    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Segmento\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoCapacidad()
    {
        return $this->belongsTo('App\Models\Segmento\Capacidad', 'capacidad_id');
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
    public function segmentoPuertum()
    {
        return $this->belongsTo('App\Models\Segmento\Puerta', 'puerta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoLlantaRefaccion()
    {
        return $this->belongsTo('App\Models\Segmento\LantaRefaccion', 'llanta_refaccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoCilindro()
    {
        return $this->belongsTo('App\Models\Segmento\Cilindro', 'cilindro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoTipoVehiculo()
    {
        return $this->belongsTo('App\Models\Segmento\TipoVehiculo', 'tipo_vehiculo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoNoCilindro()
    {
        return $this->belongsTo('App\Models\Segmento\NoCilindro', 'no_cilindro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoEnInventario()
    {
        return $this->belongsTo('App\Models\Segmento\EnInventario', 'en_inventario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoBlindaje()
    {
        return $this->belongsTo('App\Models\Segmento\Blindaje', 'blindaje_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoPotencium()
    {
        return $this->belongsTo('App\Models\Segmento\Potencia', 'potencia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoGp()
    {
        return $this->belongsTo('App\Models\Segmento\Gps', 'gps_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoCarrocerium()
    {
        return $this->belongsTo('App\Models\Segmento\Carroceria', 'carroceria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoRadio()
    {
        return $this->belongsTo('App\Models\Segmento\Radio', 'radio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoMotor()
    {
        return $this->belongsTo('App\Models\Segmento\Motor', 'motor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoDireccion()
    {
        return $this->belongsTo('App\Models\Segmento\SegmentoDireccion', 'direccion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoTransmision()
    {
        return $this->belongsTo('App\Models\Segmento\Transmision', 'transmision_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function segmentoPasajero()
    {
        return $this->belongsTo('App\Models\Segmento\Pasajero', 'pasajero_id');
    }

}
