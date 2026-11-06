<?php


namespace App\Models\Sistemas;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $resguardo_id
 * @property integer $tipo_evidencia_id
 * @property string $documento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $iduserCreated
 * @property integer $iduserUpdated
 * @property ResguardoTipoEvidencium $resguardoTipoEvidencium
 * @property User $user
 * @property Resguardo $resguardo
 * @property User $user
 */
class ResguardoEvidencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resguardo_equipo_evidencia';

    /**
     * @var array
     */
    protected $fillable = ['resguardo_id', 'tipo_evidencia_id', 'documento', 'created_at', 'updated_at', 'iduserCreated', 'iduserUpdated'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ResguardoTipoEvidencia()
    {
        return $this->belongsTo('App\Models\Sistemas\ResguardoTipoEvidencia', 'tipo_evidencia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resguardo()
    {
        return $this->belongsTo('App\Models\Sistemas\Resguardo');
    }

    public function userCreated()
    {
        return $this->belongsTo('App\Models\User', 'iduserCreated');
    }
    
    public function userUpdated()
    {
        return $this->belongsTo('App\Models\User', 'iduserUpdated');
    }
}
