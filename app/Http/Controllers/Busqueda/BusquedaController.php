<?php

namespace App\Http\Controllers\Busqueda;

use Illuminate\Support\Str;
// use App\Models\Notificaciones\Notificaciones;
use Illuminate\Http\Request;
use App\Models\Unidad\Unidad;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Busqueda\Busqueda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Services\BusquedaService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BusquedaExport;
use App\Exports\BusquedaSegurosExport;
use App\Models\Unidad\TramiteAseguramientoInfo;

class BusquedaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        return view('busqueda.index', [
            'bid' => Str::uuid()
        ]);
    }

    public function busqueda(Request $request)
    {

        //campos de salida
        $campos = $request->campos;

        //campos de filtro
        $listado = null !== $request->listado ? explode("\r\n", $request->listado) : [];
        $tipo = (int) $request->tipo;
        $bid = $request->bid;
        $busquedas = new BusquedaService();
        $unidades = $busquedas->registros($campos, $listado, $tipo);
        $unidadesTotal = count($unidades["unidades"]);
        if ($unidadesTotal) {
            $parametros = json_encode(["campos" => $campos, "listado" => $listado, "tipo" => $tipo]);
            $busqueda = Busqueda::firstOrNew(
                ['bid' => $bid],
                ['parametros' => $parametros, 'iduserCreated' => Auth::user()->id]
            );
            $busqueda->save();
        }

        return view('busqueda.resultados', compact('unidades', 'bid'));
    }

    public function excel(Request $request)
    {
        return Excel::download(new BusquedaExport($request->bid), "Busqueda - " . date('d-m-Y_h-m') . ".xlsx");
    }


    public function busqseguros(Request $request)
    {

        return view('busqueda.aseguramiento', [
            'bid' => Str::uuid()
        ]);
    }

    public function busquedaaseguramiento(Request $request)
    {

        $campos = $request->campos;

        $listado = null !== $request->listado ? explode("\r\n", $request->listado) : [];
        $tipo = (int) $request->tipo;
        $bid = $request->bid;
        $busquedas = new BusquedaService();
        $unidades = $busquedas->registrosaseguramiento($campos, $listado, $tipo);
        $unidadesTotal = count($unidades["unidades"]);
        if ($unidadesTotal) {
            $parametros = json_encode(["campos" => $campos, "listado" => $listado, "tipo" => $tipo]);
            $busqueda = Busqueda::firstOrNew(
                ['bid' => $bid],
                ['parametros' => $parametros, 'iduserCreated' => Auth::user()->id]
            );
            $busqueda->save();
        }



        return view('busqueda.resultados-aseguramiento', compact('unidades', 'bid'));        
    }

    public function excelseguros(Request $request)
    {
        return Excel::download(new BusquedaSegurosExport($request->bid), "Busqueda - " . date('d-m-Y_h-m') . ".xlsx");
    }



}