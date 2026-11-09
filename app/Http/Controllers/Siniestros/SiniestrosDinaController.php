<?php

namespace App\Http\Controllers\Siniestros;

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

use App\Models\Siniestros\SiniestroAgencia;
use App\Models\Siniestros\SiniestroDina;
use App\Models\Siniestros\SiniestroSicurezza;
use App\Imports\SiniestrosDinaImport;


class SiniestrosDinaController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogodina()
    {
        $siniestro_dina = SiniestroDina::where('siniestros_agencia_id', 1)->get();

        return view('siniestro.dina.catalogo-dina', compact('siniestro_dina'));
    }

    public function cargamasivadina(Request $request)
    {
        
        Excel::import( new SiniestrosDinaImport(), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('siniestro.catalogodina');
    }
    
}