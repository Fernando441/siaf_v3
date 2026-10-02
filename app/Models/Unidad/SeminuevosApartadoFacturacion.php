<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

class SeminuevosApartadoFacturacion extends Model
{
    protected $table = 'seminuevos_apartado_facturacion';

    protected $fillable = [
        'id_seminuevos_apartado',
        'fecha',
        'nombre_asesor',
        'nombre_cliente',
        'rfc',
        'correo_electronico',
        'numero_telefono',
        'direccion_completa',
        'forma_pago',
        'uso_cfdi',
        'unidad_medida',
        'clave_producto',
        'importe_facturar',
        'iduserCreated',
        'created_at',
        'updated_at',
    ];
}
