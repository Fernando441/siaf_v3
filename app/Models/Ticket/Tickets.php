<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tickets_categoria_id
 * @property integer $tickets_subcategoria_id
 * @property integer $tickets_problema_id
 * @property string $descripcion
 * @property integer $estatus
 * @property string $ip_usuario
 * @property string $created_at
 * @property string $update_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property TicketsProblema $ticketsProblema
 * @property User $user
 * @property TicketsCategorium $ticketsCategorium
 * @property TicketsSubcategorium $ticketsSubcategorium
 * @property User $user
 */
class Tickets extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tickets_categoria_id', 'tickets_subcategoria_id', 'tickets_problema_id', 'descripcion', 'estatus', 'ip_usuario', 'created_at', 'update_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketsProblema()
    {
        return $this->belongsTo('App\Models\Ticket\TicketsProblema');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketsCategoria()
    {
        return $this->belongsTo('App\Models\Ticket\TicketsCategoria', 'tickets_categoria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketsSubcategoria()
    {
        return $this->belongsTo('App\Models\Ticket\TicketsSubcategoria', 'tickets_subcategoria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
}
