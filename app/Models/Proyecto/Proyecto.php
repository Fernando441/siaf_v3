<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_emisor
 * @property integer $id_cliente
 * @property integer $tipo_contrato
 * @property integer $fuente_proyecto
 * @property integer $licitacion_id
 * @property integer $id_status_delete
 * @property integer $modificacion_id
 * @property string $no_folio
 * @property string $id_contrato
 * @property string $no_contrato
 * @property string $titulo_servicio
 * @property string $nombre_administrativo
 * @property string $correo_administrativo
 * @property string $telefono_administrativo
 * @property integer $id_responsable
 * @property integer $supervisor_proyecto
 * @property string $firma_contrato
 * @property string $firma_inicio_vigencia
 * @property string $firma_final_vigencia
 * @property float $presupuesto_minimo
 * @property float $presupuesto_maximo
 * @property float $importe_general
 * @property float $iva
 * @property float $monto_fianza_liberada
 * @property integer $contrato_op
 * @property integer $id_status
 * @property integer $contrato_complemento
 * @property string $motivo_desactivar
 * @property integer $convenio_op
 * @property string $no_convenio
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property EjecutivoContrato[] $ejecutivoContratos
 * @property FuenteProyecto $fuenteProyecto
 * @property ProyectoModificacionConvenio $proyectoModificacionConvenio
 * @property TipoContratacion $tipoContratacion
 * @property User $user
 * @property Emisore $emisore
 * @property Licitacione $licitacione
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Client $client
 * @property ProyectoCliente[] $proyectoClientes
 * @property ProyectoDeductivaPago[] $proyectoDeductivaPagos
 * @property ProyectoDocumento[] $proyectoDocumentos
 * @property Unidad[] $unidads
 * @property UnidadMovimiento[] $unidadMovimientos
 */
class Proyecto extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_emisor', 'id_cliente', 'tipo_contrato', 'fuente_proyecto', 'licitacion_id', 'id_status_delete', 'modificacion_id', 'no_folio', 'id_contrato', 'no_contrato', 'titulo_servicio', 'nombre_administrativo', 'correo_administrativo', 'telefono_administrativo', 'id_responsable', 'supervisor_proyecto', 'firma_contrato', 'firma_inicio_vigencia', 'firma_final_vigencia', 'presupuesto_minimo', 'presupuesto_maximo', 'importe_general', 'iva', 'monto_fianza_liberada', 'contrato_op', 'id_status', 'contrato_complemento', 'motivo_desactivar', 'convenio_op', 'no_convenio', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at', 'observaciones', 'op_sustituto'];


    public function proyectoModificacionConvenio()
    {
        return $this->belongsTo('App\Models\Proyecto\ProyectoModificacionConvenio', 'modificacion_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoDeductivaPagos()
    {
        return $this->hasMany('App\Models\Proyecto\ProyectoDeductivaPago');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoDocumentos()
    {
        return $this->hasMany('App\Models\Proyecto\ProyectoDocumento', 'id_proyecto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fuenteProyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\FuenteProyecto', 'fuente_proyecto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafEstatus', 'id_status_delete');
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
    public function emisor()
    {
        return $this->belongsTo('App\Models\Proyecto\Emisor', 'id_emisor');
    }

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
    public function tipoContratacion()
    {
        return $this->belongsTo('App\Models\Licitacion\TipoContratacion', 'tipo_contrato');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Cliente\Cliente', 'id_cliente');
    }
}
