<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_proyecto
 * @property integer $id_proyecto_tipo_documento
 * @property integer $licitacion_id
 * @property string $documento
 * @property string $mime_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Licitacione $licitacione
 * @property Proyecto $proyecto
 * @property User $user
 * @property ProyectoTipoDocumento $proyectoTipoDocumento
 * @property User $user
 */
class ProyectoDocumento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'proyecto_documento';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_proyecto', 'id_proyecto_tipo_documento', 'licitacion_id', 'documento', 'mime_type', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto\Proyecto', 'id_proyecto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyectoTipoDocumento()
    {
        return $this->belongsTo('App\Models\Proyecto\ProyectoTipoDocumento', 'id_proyecto_tipo_documento');
    }

}
