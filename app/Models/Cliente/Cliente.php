<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_cliente
 * @property integer $id_municipio
 * @property integer $id_estado
 * @property integer $id_status_delete
 * @property string $rfc
 * @property string $razon_social
 * @property string $alias
 * @property string $calle_numero
 * @property string $colonia
 * @property integer $codigo_postal
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property User $user
 * @property Municipio $municipio
 * @property User $user
 * @property Estado $estado
 * @property SiafStatus $siafStatus
 * @property ClienteDocumento[] $clienteDocumentos
 * @property Licitacione[] $licitaciones
 * @property Proyecto[] $proyectos
 */
class Cliente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'client';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cliente';

    /**
     * @var array
     */
    protected $fillable = ['id_municipio', 'id_estado', 'id_status_delete', 'rfc', 'razon_social', 'alias', 'calle_numero', 'colonia', 'codigo_postal', 'motivo_desactivar' ,'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated', 'cedula_fiscal'];

    public function siafStatus()
    {
        return $this->belongsTo('App\Models\SiafStatus', 'id_status_delete');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
    

    public function municipio()
    {
        return $this->belongsTo('App\Models\Cliente\Municipio', 'id_municipio', 'id_municipio');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Cliente\Estado', 'id_estado', 'id_estado');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clienteDocumentos()
    {
        return $this->hasMany('App\Models\Cliente\ClienteDocumento', 'id_cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licitacion()
    {
        return $this->hasMany('App\Models\Licitacion\Licitacion', 'cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectos()
    {
        return $this->hasMany('App\Models\Proyecto\Proyecto', 'id_cliente', 'id_cliente');
    }
}
