<?php

namespace App\Models\Licitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatusLicitacion extends Model
{
    use HasFactory;

    protected $table = 'licitacion_status_proyecto';
    protected $fillable = [
        'estatus',
        'status_delete',
        'iduserCreated',
        'iduserUpdated',
        'created_at',
        'updated_at'
    ];

}