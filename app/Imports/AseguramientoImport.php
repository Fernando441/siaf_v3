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
use App\Models\Unidad\TramiteAseguramientoInfo;
use App\Models\Unidad\Unidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class AseguramientoImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row){
            
            $no_serie = Unidad::where('no_serie', $row['no_serie'])->first();
            $upd_info_tenencia = TramiteAseguramientoInfo::where('unidad_id', $no_serie->id)->where('op_estatus', 1)->get();
            
            foreach ($upd_info_tenencia as $key => $value) {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteAseguramientoInfo::where('id', $value->id)->update($data);
            }

            $data = [
                'unidad_id' => $no_serie->id,
                'unidad_tramite_gestor_id' => $row['gestor'],
                'unidad_informacion_propietario_id' => $row['propietario'],
                'fecha_inicial_seguro' => $row['inicio_vigencia'] ? Carbon::createFromFormat('d/m/Y', $row['inicio_vigencia'])->format('Y-m-d') : null,
                'fecha_final_seguro' => $row['fin_vigencia'] ? Carbon::createFromFormat('d/m/Y', $row['fin_vigencia'])->format('Y-m-d') : null,
                'importe' => $row['suma_asegurada_unidad'],
                'tipo_cobertura_id' => $row['tipo_cobertura_id'], 
                'aseguradora_id'  => $row['aseguradora_id'],
                'descripcion' => $row['descripcion'], 
                'modelo' => $row['modelo'],  
                'no_poliza' => $row['no_poliza'], 
                'serie' => $row['serie'],  
                'uso_unidad_poliza' => $row['uso_unidad_poliza'],  
                'valor_eq_esp' => $row['valor_eq_esp'],  
                'valor_adaptacion' => $row['valor_adaptacion'], 
                'nombre_archivo_poliza' => $row['nombre_archivo_poliza'], 
                'inciso' => $row['inciso'],
                'prima_neta' => $row['prima_neta'],
                'recargos' => $row['recargos'],
                'gastos_exp' => $row['gastos_exp'],
                'sub_total' => $row['sub_total'],
                'iva' => $row['iva'],
                'prima_total' => $row['prima_total'],
                'primer_recibo' => $row['1er_recibo'],
                'recibos_sub' => $row['recibos_subsecuentes'],
                'op_estatus' => 1,
                'observaciones'=>$row['observaciones'],
                'id_status_delete'=>1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            TramiteAseguramientoInfo::insert($data);
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

}