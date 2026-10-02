<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $licitacion_id
 * @property integer $licitacion_gestor_documentos_id
 * @property string $documento
 * @property string $mime_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Licitacione $licitacione
 * @property User $user
 * @property LicitacionGestorDocumento $licitacionGestorDocumento
 * @property User $user
 */
class LicitacionPropuestaTecnicaLegal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_propuesta_tecnica_legal';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['licitacion_id', 'licitacion_gestor_documentos_id', 'documento', 'mime_type', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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

    public function licitacionGestorDocumentos()
    {
        return $this->belongsTo('App\Models\Licitacion\LicitacionGestorDocumentos', 'licitacion_gestor_documentos_id');
    }
}
