<?php

namespace App\Models\Translados;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $translados_id
 * @property integer $translados_unidad_id
 * @property integer $unidad_id
 * @property string $poliza_seguros
 * @property string $manual
 * @property string $lugar
 * @property string $no_tarjeta_circulacion
 * @property string $verificacion_ambiental
 * @property string $kilometraje
 * @property string $tenencia
 * @property string $poliza_de_garantia
 * @property string $aire_acondicionado
 * @property string $llanta_refaccion
 * @property string $tapon_aceite
 * @property string $calefaccion
 * @property string $gato
 * @property string $tapon_agua
 * @property string $radio
 * @property string $llave_auxiliar
 * @property string $tapon_gasolina
 * @property string $antena
 * @property string $herramienta
 * @property string $defensa_lateral
 * @property string $encendedor
 * @property string $extinguidor
 * @property string $defensa_trasera
 * @property string $ceniceros
 * @property string $calaveras
 * @property string $tapetes
 * @property string $manijas
 * @property string $parabrisas
 * @property string $viceras
 * @property string $elevadores
 * @property string $medallon
 * @property string $biseles
 * @property string $espejo_retrovisor
 * @property string $brazos_limpiadores
 * @property string $cuartos
 * @property string $claxon
 * @property string $espejos_laterales
 * @property string $stop
 * @property string $tapones_llantas
 * @property string $senales_carretera
 * @property string $duplicado_llaves
 * @property string $reflejantes
 * @property string $cables_corriente
 * @property string $acumulador
 * @property string $marca_llantas
 * @property string $llanta_delantera_derecha
 * @property string $llanta_delantera_izquierda
 * @property string $llanta_trasera_derecha
 * @property string $llanta_trasera_izquierda
 * @property string $llantar_refaccion
 * @property string $nivel_combustible
 * @property string $observaciones
 * @property integer $op_inventario
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property Translado $translado
 * @property Unidad $unidad
 * @property User $user
 * @property TransladosUnidad $transladosUnidad
 */
class TransladosInventarioEntregaCliente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'translado_inventario_entrega_cliente';

    /**
     * @var array
     */
    protected $fillable = ['translados_id', 'translados_unidad_id', 'unidad_id', 'poliza_seguros', 'manual', 'lugar', 'no_tarjeta_circulacion', 'verificacion_ambiental', 'kilometraje', 'tenencia', 'poliza_de_garantia', 'aire_acondicionado', 'llanta_refaccion', 'tapon_aceite', 'calefaccion', 'gato', 'tapon_agua', 'radio', 'llave_auxiliar', 'tapon_gasolina', 'antena', 'herramienta', 'defensa_lateral', 'encendedor', 'extinguidor', 'defensa_trasera', 'ceniceros', 'calaveras', 'tapetes', 'manijas', 'parabrisas', 'viceras', 'elevadores', 'medallon', 'biseles', 'espejo_retrovisor', 'brazos_limpiadores', 'cuartos', 'claxon', 'espejos_laterales', 'stop', 'tapones_llantas', 'senales_carretera', 'duplicado_llaves', 'reflejantes', 'cables_corriente', 'acumulador', 'marca_llantas', 'llanta_delantera_derecha', 'llanta_delantera_izquierda', 'llanta_trasera_derecha', 'llanta_trasera_izquierda', 'llantar_refaccion', 'nivel_combustible', 'observaciones', 'op_inventario', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transladosUnidad()
    {
        return $this->belongsTo('App\Models\Translados\TransladosUnidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translado()
    {
        return $this->belongsTo('App\Models\Translados\Translados', 'translados_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad\Unidad');
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
