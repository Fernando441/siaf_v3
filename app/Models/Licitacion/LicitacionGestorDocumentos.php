<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitacion_gestor_tipo_documento_id
 * @property string $documento
 * @property string $size
 * @property integer $licitacion_gestor_documentos_year_id
 * @property integer $month
 * @property integer $day
 * @property string $mine_type
 * @property string $comentario
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property LicitacionGestorTipoDocumento $licitacionGestorTipoDocumento
 * @property User $user
 * @property User $user
 */
class LicitacionGestorDocumentos extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['licitacion_gestor_tipo_documento_id', 'documento', 'mine_type', 'comentario', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'licitacion_gestor_documentos_year_id', 'month', 'day', 'size'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function licitacionGestorTipoDocumento()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionGestorTipoDocumento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserUpdated');
    }

    public function licitacionGestorDocumentosYear()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionGestorDocumentosYear', 'licitacion_gestor_documentos_year_id');
    }
}
