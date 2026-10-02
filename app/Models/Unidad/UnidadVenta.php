<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_unidad
 * @property integer $id_status_delete
 * @property integer $id_tipo_persona
 * @property boolean $politicas
 * @property string $politicas_comentarios
 * @property boolean $retiro_placas
 * @property boolean $retiro_gps
 * @property boolean $apartado_politicas
 * @property boolean $confirmacion_directiva
 * @property string $confirmacion_comentarios
 * @property boolean $vendido
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property float $precio_mercado
 * @property float $precio_venta
 * @property string $fecha_entrega
 * @property string $fecha_pago
 * @property string $fecha_registro_venta
 * @property string $fecha_venta
 * @property string $numero_factura
 * @property string $vendedor_unidad
 * @property string $nombre_cliente
 * @property string $direccion_cliente
 * @property string $identificacion_cliente
 * @property string $rfc
 * @property float $compra
 * @property float $media
 * @property float $ajustes_sobre_valor
 * @property float $autometrica
 * @property float $ajustes_conversion
 * @property float $conversion
 * @property float $conversion_ajuste
 * @property float $venta_final
 * @property SeminuevosApartado[] $seminuevosApartados
 * @property SeminuevosDocumento[] $seminuevosDocumentos
 * @property SiafStatus $siafStatus
 * @property Unidad $unidad
 * @property User $user
 * @property User $user
 * @property TipoPersona $tipoPersona
 */
class UnidadVenta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_venta';

    /**
     * @var array
     */
    protected $fillable = ['id_unidad', 'id_status_delete', 'id_tipo_persona', 'politicas', 'politicas_comentarios', 'retiro_placas', 'retiro_gps', 'apartado_politicas', 'confirmacion_directiva', 'confirmacion_comentarios', 'vendido', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'precio_mercado', 'precio_venta', 'fecha_entrega', 'fecha_pago', 'fecha_registro_venta', 'fecha_venta', 'numero_factura', 'vendedor_unidad', 'nombre_cliente', 'direccion_cliente', 'identificacion_cliente', 'rfc', 'compra', 'media', 'ajustes_sobre_valor', 'autometrica', 'ajustes_conversion', 'conversion', 'conversion_ajuste', 'venta_final'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seminuevosApartados()
    {
        return $this->hasMany('App\Models\Unidad\SeminuevosApartado', 'id_unidad_venta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seminuevosDocumentos()
    {
        return $this->hasMany('App\Models\Unidad\SeminuevosDocumento', 'id_unidad_venta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Unidad\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad', 'id_unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Unidad\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Unidad\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPersona()
    {
        return $this->belongsTo('App\Models\Unidad\TipoPersona', 'id_tipo_persona');
    }
}
