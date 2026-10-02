<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property integer $taller_solicitud_tipo_documento_id
 * @property integer $id_status_delete
 * @property string $nombre
 * @property string $documento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property TallerSolicitud $tallerSolicitud
 * @property TallerSolicitudTipoDocumento $tallerSolicitudTipoDocumento
 */
class TallerSolicitudDocumento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_solicitud_documento';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'taller_solicitud_tipo_documento_id', 'id_status_delete', 'nombre', 'documento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Taller\User', 'iduserCreated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\Taller\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\Taller\SiafStatus', 'id_status_delete');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitud()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tallerSolicitudTipoDocumento()
    {
        return $this->belongsTo('App\Models\Taller\TallerSolicitudTipoDocumento');
    }
}
