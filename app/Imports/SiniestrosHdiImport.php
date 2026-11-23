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
            // dd($row);
            $estimacion_reserva_dm = ($row['estimacion_reserva_dm'] === null || $row['estimacion_reserva_dm'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['estimacion_reserva_dm']);
            $estimacion_reserva_rt = ($row['estimacion_reserva_rt'] === null || $row['estimacion_reserva_rt'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['estimacion_reserva_rt']);
            $estimacion_reserva_gm = ($row['estimacion_reserva_gm'] === null || $row['estimacion_reserva_gm'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['estimacion_reserva_gm']);
            $estimacion_reserva_rc = ($row['estimacion_reserva_rc'] === null || $row['estimacion_reserva_rc'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['estimacion_reserva_rc']);
            $reserva_otras_coberturas = ($row['reserva_otras_coberturas'] === null || $row['reserva_otras_coberturas'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['reserva_otras_coberturas']);
            $reserva_vigente = ($row['reserva_vigente'] === null || $row['reserva_vigente'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['reserva_vigente']);
            $reserva_anterior = ($row['reserva_anterior'] === null || $row['reserva_anterior'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['reserva_anterior']);
            $avance = ($row['avance'] === null || $row['avance'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['avance']);
            $ingresos_o_recuperaciones = ($row['ingresos_o_recuperaciones'] === null || $row['ingresos_o_recuperaciones'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['ingresos_o_recuperaciones']);
            $deducible = ($row['deducible'] === null || $row['deducible'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['deducible']);
            $pagos_realizados_por_hdi = ($row['pagos_realizados_por_hdi'] === null || $row['pagos_realizados_por_hdi'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['pagos_realizados_por_hdi']);
            $salvamento = ($row['salvamento'] === null || $row['salvamento'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['salvamento']);
            $total_ocurrido = ($row['total_ocurrido'] === null || $row['total_ocurrido'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['total_ocurrido']);
            $neto_ocurrido = ($row['neto_ocurrido'] === null || $row['neto_ocurrido'] === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $row['neto_ocurrido']);

            $registro_base = SiniestroHdi::where('numero_siniestro', $row['numero_siniestro'])->first();
            if($registro_base != null)
            {

                $data = [
                    'reporte_cabina' => $row['reporte_cabina'],
                    'numero_siniestro' => $row['numero_siniestro'],
                    'fecha_ocurrido' => $row['fecha_ocurrido'],
                    'year_ocurrido' => $row['ano_ocurrido'],
                    'numero_poliza' => $row['numero_de_poliza'],
                    'estatus_poliza' => $row['estatus_de_poliza'],
                    'inciso' => $row['inciso'],
                    'proyecto' => $row['proyecto'],
                    'inicio_vigencia' => $row['inicio_de_vigencia'],
                    'termino_vigencia' => $row['termino_vigencia'],
                    'estado' => $row['estado'],
                    'ciudad' => $row['ciudad'],
                    'conductor' => $row['conductor'],
                    'telefono' => $row['telefono_reporta'],
                    'vehiculo' => $row['vehiculo'],
                    'year' => $row['ano'],
                    'serie' => $row['serie'],
                    'placa' => $row['placa'],
                    'causa_siniestro' => $row['causa_de_siniestro'],
                    'hora_reporte' => $row['hora_reporte'],
                    'responsable' => $row['responsable'],
                    'evento_cabina' => $row['evento_en_cabina'],
                    'tipo_siniestro' => $row['tipo_de_siniestro'],
                    'estatus_siniestro' => $row['estatus_de_siniestro'],
                    'con_costo' => $row['con_o_sin_costo'],
                    'equipo_pesado' => $row['equipo_pesado'],
                    'estimacion_reserva_dm' => $estimacion_reserva_dm,
                    'estimacion_reserva_rt' => $estimacion_reserva_rt,
                    'estimacion_reserva_gm' => $estimacion_reserva_gm,
                    'estimacion_reserva_rc' => $estimacion_reserva_rc,
                    'reserva_otras' => $reserva_otras_coberturas,
                    'reserva_vigente' => $reserva_vigente,
                    'reserva_anterior' => $reserva_anterior,
                    'avance' => $avance,
                    'ingresos_recuperaciones' => $ingresos_o_recuperaciones,
                    'deducible' => $deducible,
                    'pagos_realizados_dhi' => $pagos_realizados_por_hdi,
                    'salvamento' => $salvamento,
                    'total_ocurrido' => $total_ocurrido,
                    'neto_ocurrido' => $neto_ocurrido,
                    'contratante' => $row['contratante'],
                    'cobertura' => $row['cobertura'],
                    'legal' => $row['legal'],
                    'taller' => $row['taller'],
                    'perdida_total' => $row['perdida_total'],
                    'robo_localizado' => $row['robo_localizado'],
                    'pt_indemnizada' => $row['pt_indemnizada'],
                    'comentarios' => $row['comentarios'],
                    'primas_no_denegadas' => $row['primas_no_devengadas_devueltas'],
                    'iduserUpdated' =>auth()->user()->id,
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                SiniestroHdi::where('id', $registro_base->id)->update($data);

            }else{

                $folio = SiniestroFolioHdi::with('folio')->max('folio');
                $folio = $folio ? ++$folio : 1;
                $folioModel = new SiniestroFolioHdi();
                $folioModel->folio = $folio;
                $folioModel->anio = date('Y');
                $folioModel->save();
                $folio = "H-".str_pad($folio,5,"0", STR_PAD_LEFT);

                $data = [
                    'no_folio' => $folio, 
                    'siniestros_agencia_id' => 3,
                    'reporte_cabina' => $row['reporte_cabina'],
                    'numero_siniestro' => $row['numero_siniestro'],
                    'fecha_ocurrido' => $row['fecha_ocurrido'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_ocurrido'])->format('Y-m-d'):null,
                    'year_ocurrido' => $row['ano_ocurrido'] ? Carbon::createFromFormat('d/m/Y', $row['ano_ocurrido'])->format('Y-m-d'):null,
                    'numero_poliza' => $row['numero_de_poliza'],
                    'estatus_poliza' => $row['estatus_de_poliza'],
                    'inciso' => $row['inciso'],
                    'proyecto' => $row['proyecto'],
                    'inicio_vigencia' => $row['inicio_de_vigencia'] ? Carbon::createFromFormat('d/m/Y', $row['inicio_de_vigencia'])->format('Y-m-d'):null,
                    'termino_vigencia' => $row['termino_vigencia'] ? Carbon::createFromFormat('d/m/Y', $row['termino_vigencia'])->format('Y-m-d'):null,
                    'estado' => $row['estado'],
                    'ciudad' => $row['ciudad'],
                    'conductor' => $row['conductor'],
                    'telefono' => $row['telefono_reporta'],
                    'vehiculo' => $row['vehiculo'],
                    'year' => $row['ano'],
                    'serie' => $row['serie'],
                    'placa' => $row['placa'],
                    'causa_siniestro' => $row['causa_de_siniestro'],
                    'hora_reporte' => $row['hora_reporte'],
                    'responsable' => $row['responsable'],
                    'evento_cabina' => $row['evento_en_cabina'],
                    'tipo_siniestro' => $row['tipo_de_siniestro'],
                    'estatus_siniestro' => $row['estatus_de_siniestro'],
                    'con_costo' => $row['con_o_sin_costo'],
                    'equipo_pesado' => $row['equipo_pesado'],
                    'estimacion_reserva_dm' => $estimacion_reserva_dm,
                    'estimacion_reserva_rt' => $estimacion_reserva_rt,
                    'estimacion_reserva_gm' => $estimacion_reserva_gm,
                    'estimacion_reserva_rc' => $estimacion_reserva_rc,
                    'reserva_otras' => $reserva_otras_coberturas,
                    'reserva_vigente' => $reserva_vigente,
                    'reserva_anterior' => $reserva_anterior,
                    'avance' => $avance,
                    'ingresos_recuperaciones' => $ingresos_o_recuperaciones,
                    'deducible' => $deducible,
                    'pagos_realizados_dhi' => $pagos_realizados_por_hdi,
                    'salvamento' => $salvamento,
                    'total_ocurrido' => $total_ocurrido,
                    'neto_ocurrido' => $neto_ocurrido,
                    'contratante' => $row['contratante'],
                    'cobertura' => $row['cobertura'],
                    'legal' => $row['legal'],
                    'taller' => $row['taller'],
                    'perdida_total' => $row['perdida_total'],
                    'robo_localizado' => $row['robo_localizado'],
                    'pt_indemnizada' => $row['pt_indemnizada'],
                    'comentarios' => $row['comentarios'],
                    'primas_no_denegadas' => $row['primas_no_devengadas_devueltas'],
                    'op_deducible' => 0,
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s')
                ];

                SiniestroHdi::insert($data);                
            }
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('siniestro.catalogohdi');
    }

}