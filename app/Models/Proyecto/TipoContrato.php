<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    use HasFactory;

    protected $table = 'tipo_contrato';
    protected $fillable = [
        'tipo_contrato',
        'status_delete',
        'id_user_created',
        'id_user_update',
        'created_at',
        'updated_at'
    ];
}
