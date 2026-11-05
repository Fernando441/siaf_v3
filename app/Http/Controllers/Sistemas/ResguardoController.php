<?php

namespace App\Http\Controllers\Sistemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Sistemas\InventarioComputo;
use App\Models\Sistemas\Resguardo;
use App\Models\Sistemas\ResguardoEquipo;
use App\Models\Sistemas\ResguardoEvidencia;
use App\Models\Sistemas\ResguardoTipoEvidencia;


class ResguardoController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogoresguardo()
    {
        $resguardo = Resguardo::where('id_status_delete', 1)->get();

        return view('sistemas.resguardo.catalogo-resguardos', compact('resguardo'));
    }

    public function agregarResguardo()
    {

        $usuarios = User::where('id_status_delete', 1)->get();
        $documentos = ResguardoTipoEvidencia::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo_evidencia.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $equipos = InventarioComputo::where('id_status_delete', 1)->where('estatus_asignado', 0)->get();
        //Equipos en formato json
        $cadenaEquipos = "";
        foreach($equipos as $documento){
            $cadenaEquipos .= '"'.$documento->id.'":"'.$documento->no_folio." Serie: ".$documento->no_serie.'",';
        }
        $cadenaEquipos = '{'.rtrim($cadenaEquipos, ',').'}';

        return view('sistemas.resguardo.agregar-resguardo', compact('cadenaTipoDocumento', 'usuarios', 'equipos', 'cadenaEquipos'));        
    }
}