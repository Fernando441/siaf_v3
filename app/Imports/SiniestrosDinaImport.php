<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Services\Folio;
use App\Models\Siniestros\SiniestroDina;
use App\Models\Siniestros\SiniestroFolioDina;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class SiniestrosDinaImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {

    }


    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row){
            $folio = SiniestroFolioDina::with('folio')->max('folio');
            $folio = $folio ? ++$folio : 1;
            $folioModel = new SiniestroFolioDina();
            $folioModel->folio = $folio;
            $folioModel->anio = date('Y');
            $folioModel->save();
            $folio = "D-".str_pad($folio,5,"0", STR_PAD_LEFT);

            $deducible = $row['deducibles'];
            $deducible = ($deducible === null || $deducible === '')? 0: (float) str_replace(['.', ','], ['', '.'], $deducible);

            $recuperacion_aplicada = $row['recuperacion_aplicada'];
            $recuperacion_aplicada = ($recuperacion_aplicada === null || $recuperacion_aplicada === '')? 0: (float) str_replace(['.', ','], ['', '.'], $recuperacion_aplicada);


            $data = [
                'no_folio' => $folio, 
                'siniestros_agencia_id' => 1,
                'no_siniestro' => $row['numero_de_siniestro'],
                'contratante' => $row['contratante'],
                'proyecto_poliza' => $row['proyecto_poliza'],
                'nombre_proyecto' => $row['nombre_proyec'],
                'inicio' => $row['inicio'],
                'fin' => $row['fin'],
                'moneda' => $row['moneda'],
                'poliza' => $row['poliza'],
                'serie' => $row['serie'],
                'fecha_ocurrencia' => $row['fecha_ocurrencia'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_ocurrencia'])->format('Y-m-d'):null,
                'tipo_siniestro_inicial' => $row['tipo_de_siniestro_inicial'],
                'deducible' => $deducible,
                'recuperacion_aplicada' => $recuperacion_aplicada,
                'nombre_agente' => $row['nombre_agente'],
                'modelo' => $row['modelo'],
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];
            SiniestroDina::insert($data);

        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('siniestro.catalogodina');
    }

}