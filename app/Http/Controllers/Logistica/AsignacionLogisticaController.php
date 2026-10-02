<?php

namespace App\Http\Controllers\Logistica;

use App\Http\Controllers\Controller;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\InventarioEntrega;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\ProyectoClientes;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Cliente\Estado;


use App\Models\Logistica\AsignacionLogistica;


class AsignacionLogisticaController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }


}