<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $categoria_id
 * @property string $nombre_subcategoria
 * @property TicketsCategorium $ticketsCategorium
 */
class TicketsSubCategoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tickets_subcategoria';

    /**
     * @var array
     */
    protected $fillable = ['categoria_id', 'nombre_subcategoria'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketsCategoria()
    {
        return $this->belongsTo('App\Models\Ticket\TicketsCategoria', 'categoria_id');
    }
}
