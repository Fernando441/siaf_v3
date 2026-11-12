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
use App\Models\Siniestros\SiniestroSicurezza;
use App\Models\Siniestros\SiniestroFolioSicurezza;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class SiniestrosSicuezzaImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;

    public function  __construct()
    {

    }

    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row){

            $registro_base = SiniestroSicurezza::where('siniestro_completo', $row['siniestro_completo'])->first();

            if($registro_base != null)
            {
                if (preg_match('/^[\s$-]*$/', $row['deducibles'])) {
                   $deducible = '0.00';
                } else {
                   $deducible = str_replace(['$', '.', ','], ['', '', '.'],  $row['deducibles']);
                }

                if (preg_match('/^[\s$-]*$/', $row['recuperacion_aplicada'])) {
                   $recuperacion_aplicada = '0.00';
                } else {
                   $recuperacion_aplicada = str_replace(['$', '.', ','], ['', '', '.'],  $row['recuperacion_aplicada']);
                }

                $data = [
                    'siniestro_completo' => $row['siniestro_completo'],
                    'proyecto' => $row['proyecto'],
                    'fecha_ocurrencia' => $row['fecha_ocurrencia'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_ocurrencia'])->format('Y-m-d'):null,
                    'causa_enfermedad' => $row['causa_enfermedad_2'],
                    'recuperacion_aplicada' => $recuperacion_aplicada,
                    'deducibles' => $deducible,
                    'nombre_agente' => $row['nombre_agente'],
                    'asegurado' => $row['asegurado'],
                    'modelo' => $row['modelo'],
                    'serie' => $row['serie'],
                    'descripcion_auto' => $row['descripcion_auto'],
                    'iduserUpdated' =>auth()->user()->id,
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                SiniestroSicurezza::where('id', $registro_base->id)->update($data);

            }else{
                // "Inserta"
                $folio = SiniestroFolioSicurezza::with('folio')->max('folio');
                $folio = $folio ? ++$folio : 1;
                $folioModel = new SiniestroFolioSicurezza();
                $folioModel->folio = $folio;
                $folioModel->anio = date('Y');
                $folioModel->save();
                $folio = "S-".str_pad($folio,5,"0", STR_PAD_LEFT);

                if (preg_match('/^[\s$-]*$/', $row['deducibles'])) {
                   $deducible = '0.00';
                } else {
                   $deducible = str_replace(['$', '.', ','], ['', '', '.'],  $row['deducibles']);
                }

                if (preg_match('/^[\s$-]*$/', $row['recuperacion_aplicada'])) {
                   $recuperacion_aplicada = '0.00';
                } else {
                   $recuperacion_aplicada = str_replace(['$', '.', ','], ['', '', '.'],  $row['recuperacion_aplicada']);
                }

                $data = [
                    'no_folio' => $folio, 
                    'siniestros_agencia_id' => 2,
                    'siniestro_completo' => $row['siniestro_completo'],
                    'proyecto' => $row['proyecto'],
                    'fecha_ocurrencia' => $row['fecha_ocurrencia'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_ocurrencia'])->format('Y-m-d'):null,
                    'causa_enfermedad' => $row['causa_enfermedad_2'],
                    'recuperacion_aplicada' => $recuperacion_aplicada,
                    'deducibles' => $deducible,
                    'nombre_agente' => $row['nombre_agente'],
                    'asegurado' => $row['asegurado'],
                    'modelo' => $row['modelo'],
                    'serie' => $row['serie'],
                    'descripcion_auto' => $row['descripcion_auto'],
                    'op_modificado' => 0,
                    'op_deducible' => 0,
                    'op_recuperacion_aplicada' => 0,
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                SiniestroSicurezza::insert($data);
            }

        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('siniestro.catalogosicurezza');
    }

}