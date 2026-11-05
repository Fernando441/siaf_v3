<?php

namespace App\Models\Sistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $tipo_evidencia
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property ResguardoEquipoEvidencium[] $resguardoEquipoEvidencias
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class ResguardoTipoEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resguardo_tipo_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'tipo_evidencia', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
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
