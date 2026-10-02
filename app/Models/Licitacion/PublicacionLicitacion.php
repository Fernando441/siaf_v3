<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacionLicitacion extends Model
{
    use HasFactory;

    protected $table = 'publicacion_licitacion';
    protected $fillable = [
        'publicacion_licitacion',
        'status_delete',
        'id_user_created',
        'id_user_update',
        'created_at',
        'updated_at'
    ];

}