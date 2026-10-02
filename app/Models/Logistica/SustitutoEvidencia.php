<?php

namespace App\Models\Logistica;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $sustituto_solicitud_id
 * @property integer $users_id
 * @property string $documento
 * @property string $tipo_documento
 * @property string $created_at
 * @property SustitutoSolicitud $sustitutoSolicitud
 * @property User $user
 */
class SustitutoEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sustituto_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['sustituto_solicitud_id', 'users_id', 'documento', 'tipo_documento', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sustitutoSolicitud()
    {
        return $this->belongsTo('App\Models\Logistica\SustitutoSolicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\Licitacion\User', 'iduserCreated');
    }
}
