<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_hora_inicio
 * @property string $fecha_hora_final
 * @property integer $prioridad
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property User $user
 */
class Pendientes extends Model
{
    /**
     * @var array
     */
    protected $table = 'pendientes';
    
    protected $fillable = ['titulo', 'descripcion', 'fecha_hora_inicio', 'fecha_hora_final', 'prioridad', 'op_finalizado', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
