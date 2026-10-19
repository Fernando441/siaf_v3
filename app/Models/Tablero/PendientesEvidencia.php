<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $pendientes_id
 * @property string $nombre_evidencia
 * @property integer $iduserCreated
 * @property string $created_at
 * @property Pendiente $pendiente
 * @property User $user
 */
class PendientesEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pendientes_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['pendientes_id', 'nombre_evidencia', 'nombre_archivo', 'iduserCreated', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pendiente()
    {
        return $this->belongsTo('App\Models\Tablero\Pendientes', 'pendientes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
}
