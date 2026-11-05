<?php

namespace App\Models\Sistemas;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_resguardo
 * @property string $no_folio
 * @property string $fecha_asignacion
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 * @property User $user
 * @property ResguardoEquipo[] $resguardoEquipos
 * @property ResguardoEquipoEvidencium[] $resguardoEquipoEvidencias
 */
class Resguardo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resguardo';

    /**
     * @var array
     */
    protected $fillable = ['user_resguardo', 'no_folio', 'fecha_asignacion', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'id_status_delete', 'descripcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function userresguardo()
    {
        return $this->belongsTo('App\Models\User', 'user_resguardo');
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
