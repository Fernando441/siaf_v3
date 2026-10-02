<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesPresupuesto extends Model
{
    use HasFactory;

    protected $table = 'unidades_presupuestos';
    protected $fillable = [
        'id_licitacion',
        'id_presupuesto',
        'id_unidad',
        'id_user_created',
        'id_user_update',
        'created_at',
        'updated_at'
    ];

}