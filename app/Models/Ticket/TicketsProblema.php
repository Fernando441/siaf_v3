<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $subcategoria_id
 * @property string $nombre_problema
 * @property TicketsSubcategorium $ticketsSubcategorium
 */
class TicketsProblema extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tickets_problema';

    /**
     * @var array
     */
    protected $fillable = ['subcategoria_id', 'nombre_problema'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketsSubcategoria()
    {
        return $this->belongsTo('App\Models\Ticket\TicketsSubcategoria', 'subcategoria_id');
    }
}
