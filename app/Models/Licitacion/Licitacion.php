<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cliente
 * @property integer $id_licitacion_estatus
 * @property integer $id_licitacion_prioridad
 * @property integer $id_status_delete
 * @property string $folio
 * @property string $titulo_servicio
 * @property string $folio_num
 * @property string $empresa_dependencia
 * @property string $no_licitacion
 * @property integer $contratacion
 * @property string $fecha_visita
 * @property string $junta_aclaraciones
 * @property string $apertura_proposiciones
 * @property string $acto_fallo
 * @property string $participacion_conjunta
 * @property string $publicacion_licitacion
 * @property float $monto_ofertado
 * @property float $monto_ganado
 * @property float $monto_fianza
 * @property string $porcentaje_efectividad
 * @property string $firma_entrega
 * @property string $fecha_entrega
 * @property string $fecha_cierre
 * @property integer $tipo_documento
 * @property string $observaciones
 * @property float $monto_fianza_liberada
 * @property string $id_contrato
 * @property string $no_contrato
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $updated_at
 * @property string $created_at
 * @property DocumentosLicitacione[] $documentosLicitaciones
 * @property LicitacionProposicionEconomica[] $licitacionProposicionEconomicas
 * @property LicitacionPropuestaTecnicaAdministrativa[] $licitacionPropuestaTecnicaAdministrativas
 * @property LicitacionPropuestaTecnicaFinanciera[] $licitacionPropuestaTecnicaFinancieras
 * @property LicitacionPropuestaTecnicaFiscal[] $licitacionPropuestaTecnicaFiscals
 * @property LicitacionPropuestaTecnicaLegal[] $licitacionPropuestaTecnicaLegals
 * @property LicitacionPropuestaTecnicaOtro[] $licitacionPropuestaTecnicaOtros
 * @property LicitacionSegmento[] $licitacionSegmentos
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Client $client
 * @property LicitacionPrioridad $licitacionPrioridad
 * @property User $user
 * @property LicitacionEstatus $licitacionEstatus
 * @property PagoProyecto[] $pagoProyectos
 * @property ProyectoDeductivaPago[] $proyectoDeductivaPagos
 * @property ProyectoDocumento[] $proyectoDocumentos
 * @property Proyecto[] $proyectos
 */
class Licitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitaciones';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['cliente', 'id_licitacion_estatus', 'id_licitacion_prioridad', 'id_status_delete', 'folio', 'titulo_servicio', 'folio_num', 'empresa_dependencia', 'no_licitacion', 'contratacion', 'fecha_visita', 'junta_aclaraciones', 'apertura_proposiciones', 'acto_fallo', 'participacion_conjunta', 'publicacion_licitacion', 'monto_ofertado', 'monto_ganado', 'monto_fianza', 'porcentaje_efectividad', 'firma_entrega', 'fecha_entrega', 'fecha_cierre', 'tipo_documento', 'observaciones', 'monto_fianza_liberada', 'fecha_fianza' , 'id_contrato', 'no_contrato', 'iduserCreated', 'iduserUpdated', 'updated_at', 'created_at', 'motivo_desactivar', 'sector', 'tipo_partida', 'numero_vehiculos', 'fecha_final_servicios', 'tipo_contrato', 'fecha_preguntas', 'fecha_visita_aplica', 'fecha_apertura_tecnica', 'fecha_apertura_economica', 'fecha_subasta_aplica', 'fecha_subasta', 'modalidad', 'fecha_compra_bases', 'fecha_entrega_propuestas', 'fecha_repreguntas_aplica', 'fecha_repreguntas', 'acto_fallo_info'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentosLicitaciones()
    {
        return $this->hasMany('App\Models\Licitacion\DocumentosLicitacion', 'id_licitacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionProposicionEconomicas()
    {
        return $this->hasMany('App\Models\Licitacion\ProposicionEconomica', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPropuestaTecnicaAdministrativas()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPropuestaTecnicaAdministrativa', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPropuestaTecnicaFinanciera()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPropuestaTecnicaFinanciera', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPropuestaTecnicaFiscal()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPropuestaTecnicaFiscal', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPropuestaTecnicaLegal()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPropuestaTecnicaLegal', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionPropuestaTecnicaOtros()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionPropuestaTecnicaOtro', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionSegmentos()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionSegmento', 'licitacion_id');
    }


    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente\Cliente', 'cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacionPrioridad()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionPrioridad', 'id_licitacion_prioridad');
    }


    public function licitacionEstatus()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionEstatus', 'id_licitacion_estatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoProyectos()
    {
        return $this->hasMany('App\Models\Proyecto\PagoProyecto', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoDeductivaPagos()
    {
        return $this->hasMany('App\Models\Proyecto\DeductivaPago', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoDocumentos()
    {
        return $this->hasMany('App\Models\Proyecto\ProyectoDocumento', 'licitacion_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectos()
    {
        return $this->hasMany('App\Models\Proyecto\Proyecto', 'licitacion_id');
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
