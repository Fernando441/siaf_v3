<?php

namespace App\Models\Siniestros;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $agencia_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property SiniestrosRegistroDina[] $siniestrosRegistroDinas
 * @property SiniestroRegistroSicurezza[] $siniestroRegistroSicurezzas
 */
class SiniestroAgencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'siniestros_agencia';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'agencia_nombre', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
