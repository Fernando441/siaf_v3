<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_municipio
 * @property integer $id_status_delete
 * @property string $municipio_nombre
 * @property integer $id_estado
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property Client[] $clients
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 */
class Municipio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'municipio';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_municipio';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'municipio_nombre', 'id_estado', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cliente()
    {
        return $this->hasMany('App\Models\Cliente\Cliente', 'id_municipio', 'id_municipio');
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
