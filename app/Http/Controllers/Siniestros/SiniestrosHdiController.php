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
use Carbon\Carbon;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Siniestros\SiniestroTipoDocumento;
use App\Models\Siniestros\SiniestroHdi;
use App\Models\Siniestros\SiniestroHdiEvidencia;
use App\Imports\SiniestrosHdiImport;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Illuminate\Support\Facades\File;


class SiniestrosHdiController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogohdi()
    {
        $siniestro_hdi = SiniestroHdi::where('siniestros_agencia_id', 3)->get();

        return view('siniestro.hdi.catalogo-hdi', compact('siniestro_hdi'));
    }

    public function cargamasivhdi(Request $request)
    {
        Excel::import( new SiniestrosHdiImport(), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('siniestro.catalogohdi');
    }
}
