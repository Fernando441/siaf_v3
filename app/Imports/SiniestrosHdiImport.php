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
use App\Models\Siniestros\SiniestroHdi;
use App\Models\Siniestros\SiniestroFolioHdi;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class SiniestrosHdiImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;

    public function  __construct()
    {

    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            dd($row);
            $registro_base = SiniestroHdi::where('numero_siniestro', $row['numero_siniestro'])->first();
            if($registro_base != null)
            {

                $estimacion_reserva_dm = $row['estimacion_reserva_dm'];
                $estimacion_reserva_dm = ($estimacion_reserva_dm === null || $estimacion_reserva_dm === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $estimacion_reserva_dm);
                $recuperacion_aplicada = $row['recuperacion_aplicada'];
                $recuperacion_aplicada = ($recuperacion_aplicada === null || $recuperacion_aplicada === '')? 0: (float) str_replace(['.', ','], ['', '.'], $recuperacion_aplicada);


                $data = [
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
                    'iduserUpdated' =>auth()->user()->id,
                    'updated_at' =>date('Y-m-d H:i:s')
                ];
                // SiniestroDina::where('id', $registro_base->id)->update($data);

            }else{
                // $folio = SiniestroFolioHdi::with('folio')->max('folio');
                // $folio = $folio ? ++$folio : 1;
                // $folioModel = new SiniestroFolioHdi();
                // $folioModel->folio = $folio;
                // $folioModel->anio = date('Y');
                // $folioModel->save();
                // $folio = "D-".str_pad($folio,5,"0", STR_PAD_LEFT);

                $estimacion_reserva_dm = $row['estimacion_reserva_dm'];
                $estimacion_reserva_dm = ($estimacion_reserva_dm === null || $estimacion_reserva_dm === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $estimacion_reserva_dm);


                dd($estimacion_reserva_dm);

                $recuperacion_aplicada = $row['recuperacion_aplicada'];
                $recuperacion_aplicada = ($recuperacion_aplicada === null || $recuperacion_aplicada === '')? 0: (float) str_replace(['.', ','], ['', '.'], $recuperacion_aplicada);


                $data = [
                    'no_folio' => $folio, 
                    'siniestros_agencia_id' => 3,
                    'reporte_cabina' => $row['reporte_cabina'],
                    'numero_siniestro' => $row['numero_siniestro'],
                    'fecha_ocurrido' => $row['fecha_ocurrido'],





                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];
                // SiniestroDina::insert($data);                
            }
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('siniestro.catalogodina');
    }

}