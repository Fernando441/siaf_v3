<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_licitacion
 * @property integer $tipo_documento
 * @property string $documento
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Licitacione $licitacione
 * @property User $user
 * @property TipoDocumentosLicitacione $tipoDocumentosLicitacione
 */
class DocumentoLicitacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'documentos_licitaciones';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_licitacion', 'tipo_documento', 'documento', 'iduserCreated', 'iduserUpdated', 'created_at', 'updated_at'];

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
    
    public function licitaciones()
    {
        return $this->belongsTo('App\Models\Licitacion\Licitacion', 'id_licitacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDocumentosLicitaciones()
    {
        return $this->belongsTo('App\Models\Licitacion\TipoDocumentoLicitacion', 'tipo_documento');
    }
}
