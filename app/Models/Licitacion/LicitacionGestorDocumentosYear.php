<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $year
 * @property LicitacionGestorDocumento[] $licitacionGestorDocumentos
 */
class LicitacionGestorDocumentosYear extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'licitacion_gestor_documentos_year';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['year'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacionGestorDocumentos()
    {
        return $this->hasMany('App\Models\Licitacion\LicitacionGestorDocumentos');
    }
}
