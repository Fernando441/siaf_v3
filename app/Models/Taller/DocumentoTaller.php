<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_id
 * @property integer $taller_tipo_documento_id
 * @property string $documento
 * @property string $mime_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property TallerTipoDocumento $tallerTipoDocumento
 * @property User $user
 * @property Taller $taller
 * @property User $user
 */
class DocumentoTaller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_documento';

    /**
     * @var array
     */
    protected $fillable = ['taller_id', 'taller_tipo_documento_id', 'documento', 'mime_type', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerTipoDocumento()
    {
        return $this->belongsTo('App\Models\Taller\TipoDocumentoTaller');
    }

    public function taller()
    {
        return $this->belongsTo('App\Models\Taller\Taller');
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
