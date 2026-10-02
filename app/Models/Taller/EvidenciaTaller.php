<?php

namespace App\Models\Taller;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $taller_solicitud_id
 * @property integer $taller_id
 * @property string $documento
 * @property string $mime_type
 * @property string $evidencia
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property TallerSolicitud $tallerSolicitud
 * @property User $user
 * @property Taller $taller
 * @property User $user
 */
class EvidenciaTaller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'taller_evidencia_solicitud';

    /**
     * @var array
     */
    protected $fillable = ['taller_solicitud_id', 'taller_id', 'documento', 'mime_type', 'evidencia', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
    public function taller()
    {
        return $this->belongsTo('App\Models\Taller\Taller');
    }

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
}
