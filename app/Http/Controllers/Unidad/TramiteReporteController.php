<?php

namespace App\Http\Controllers\Unidad;

use App\Exports\TramiteReporteExport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Busqueda\Busqueda;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Tramite\ReporteService;
use Maatwebsite\Excel\Facades\Excel;

class TramiteReporteController extends Controller
{
    protected $tramitesVehiculares = [
        "Emplacamiento",
        "Tenencia y/o pago de derechos",
        "Verificación",
        "Aseguramiento",
        "Reemplacamiento",
        "Cambio de propietario",
        "Reposición"
    ];

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
		$bid = Str::uuid();
    	return view('unidades.tramitesvehiculares.reporte.tramites', compact( 'bid'));
    }

     public function consulta(Request $request)
    {

        //campos de salida
        $campos = $request->campos;

        //campos de filtro
        $bid = $request->bid;
        $busquedas = new ReporteService();
        $unidades = $busquedas->registrosTramites($request->fecha_inicio, $request->fecha_final);
        $unidadesTotal = count($unidades["unidades"]);
        if ($unidadesTotal) {
            $parametros = json_encode(["fecha_inicio" => $request->fecha_inicio, "fecha_final" => $request->fecha_final]);
            $busqueda = Busqueda::firstOrNew(
                ['bid' => $bid],
                ['parametros' => $parametros, 'iduserCreated' => Auth::user()->id]
            );
            $busqueda->save();
        }

        return view('unidades.tramitesvehiculares.reporte.resultados', compact('unidades', 'bid'));
    }

    public function excel(Request $request)
    {
        return Excel::download(new TramiteReporteExport($request->bid), "Tramites - " . date('d-m-Y_h-m') . ".xlsx");
    }
}