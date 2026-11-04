<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tickets_id
 * @property integer $users_id
 * @property string $created_at
 * @property integer $estatus_visto
 * @property string $fecha_visto
 * @property integer $estatus_finalizado
 * @property string $fecha_finalizado
 * @property string $ip_usuario
 * @property Ticket $ticket
 * @property User $user
 */
class TicketsUsuario extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tickets_id', 'users_id', 'created_at', 'estatus_visto', 'fecha_visto', 'estatus_finalizado', 'fecha_finalizado', 'ip_usuario', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('App\Models\Tickets\Tickets', 'tickets_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
