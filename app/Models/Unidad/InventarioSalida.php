<?php

namespace App\Models\Unidad;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $unidad_id
 * @property integer $licitaciones_id
 * @property integer $proyectos_id
 * @property integer $ubicacion_unidad_id
 * @property integer $entidad_federativa
 * @property string $fecha_retiro
 * @property string $poliza_seguro
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
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $nombre_jetvan
 * @property string $fecha_jetvan
 * @property integer $personal
 * @property string $nombre_entrega
 * @property string $fecha_entrega
 * @property string $nombre_cliente
 * @property string $fecha_recepcion
 * @property string $calle
 * @property string $colonia
 * @property string $numero_int
 * @property string $numero_ext
 * @property string $codigo_postal
 * @property integer $tipo_translado
 * @property User $user
 * @property Licitacione $licitacione
 * @property UbicacionUnidad $ubicacionUnidad
 * @property User $user
 * @property Estado $estado
 * @property Proyecto $proyecto
 * @property Unidad $unidad
 */
class InventarioSalida extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'unidad_inventario_salida_contrato';

    /**
     * @var array
     */
    protected $fillable = ['unidad_id', 'licitaciones_id', 'proyectos_id', 'ubicacion_unidad_id', 'entidad_federativa', 'fecha_retiro', 'poliza_seguro', 'manual', 'lugar', 'no_tarjeta_circulacion', 'verificacion_ambiental', 'kilometraje', 'tenencia', 'poliza_de_garantia', 'aire_acondicionado', 'llanta_refaccion', 'tapon_aceite', 'calefaccion', 'gato', 'tapon_agua', 'radio', 'llave_auxiliar', 'tapon_gasolina', 'antena', 'herramienta', 'defensa_lateral', 'encendedor', 'extinguidor', 'defensa_trasera', 'ceniceros', 'calaveras', 'tapetes', 'manijas', 'parabrisas', 'viceras', 'elevadores', 'medallon', 'biseles', 'espejo_retrovisor', 'brazos_limpiadores', 'cuartos', 'claxon', 'espejos_laterales', 'stop', 'tapones_llantas', 'senales_carretera', 'duplicado_llaves', 'reflejantes', 'cables_corriente', 'acumulador', 'marca_llantas', 'llanta_delantera_derecha', 'llanta_delantera_izquierda', 'llanta_trasera_derecha', 'llanta_trasera_izquierda', 'llantar_refaccion', 'nivel_combustible', 'observaciones', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'nombre_jetvan', 'fecha_jetvan', 'personal', 'nombre_entrega', 'fecha_entrega', 'nombre_cliente', 'fecha_recepcion', 'calle', 'colonia', 'numero_int', 'numero_ext', 'codigo_postal', 'tipo_translado','calle_recoleccion', 'colonia_recoleccion', 'entidad_federativa_recoleccion', 'requiere_permiso'];


    public function ubicacionUnidad()
    {
        return $this->belongsTo('App\Models\Unidad\UbicacionUnidad');
    }

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

    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'entidad_federativa', 'id_estado');
    }

    public function estadorec()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'entidad_federativa_recoleccion', 'id_estado');
    }
}
