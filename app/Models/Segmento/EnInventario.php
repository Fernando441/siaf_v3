<?php

namespace App\Models\Segmento;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_status_delete
 * @property string $en_inventario
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property SiafStatus $siafStatus
 * @property User $user
 * @property Segmento[] $segmentos
 */
class EnInventario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'segmento_en_inventario';

    /**
     * @var array
     */
    protected $fillable = ['id_status_delete', 'en_inventario', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

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
    
    public function segmentos()
    {
        return $this->hasMany('App\Models\Segmento\Segmento', 'en_inventario_id');
    }
}
