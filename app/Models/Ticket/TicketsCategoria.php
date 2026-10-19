<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nombre_categoria
 */
class TicketsCategoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tickets_categoria';

    /**
     * @var array
     */
    protected $fillable = ['nombre_categoria'];
}
