<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_estado
 * @property integer $id_status_delete
 * @property string $estado_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Client[] $clients
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class Estado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'estado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_estado';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'estado_nombre', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cliente()
    {
        return $this->hasMany('App\Models\Cliente\Cliente', 'id_estado', 'id_estado');
    }

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
