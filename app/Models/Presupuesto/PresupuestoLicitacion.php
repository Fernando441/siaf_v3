<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoLicitacion extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_licitacion';
    protected $fillable = [
        'id_licitacion',
        'folio_presupuesto',
        'folio_num',
        'id_user_created',
        'id_user_update',
        'created_at',
        'updated_at'
    ];

}