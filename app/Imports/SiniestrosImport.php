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
use App\Models\Unidad\TramiteBajavehiculoSiniestroInfo;
use App\Models\Unidad\Unidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class SiniestrosImport implements ToCollection, WithHeadingRow
{
    use Importable, SkipsFailures;


    public function  __construct()
    {
        // $this->licitacion = $licitacion;
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $row){
            
            $no_serie = Unidad::where('no_serie', $row['no_serie'])->first();
            $upd_info_tenencia = TramiteBajaVehiculoSiniestroInfo::where('unidad_id', $no_serie->id)->where('op_estatus', 1)->get();
            // dd($upd_info_tenencia);
            foreach ($upd_info_tenencia as $key => $value) {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteBajaVehiculoSiniestroInfo::where('id', $value->id)->update($data);
            }


            $data = [
                'unidad_id' => $no_serie->id,
                'unidad_tramite_gestor_id' => $row['gestor'],
                'id_propietario' => $row['propietario'],
                'estatus_id' => 1,
                'op_estatus' => 1,
                'id_propietario' => 1,
                'unidad_tramite_bajavehiculo_siniestro_tipo_id' => $row['tipo_siniestro'],
                'fecha_ocurrencia' => $row['fecha_ocurrencia'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_ocurrencia'])->format('Y-m-d') : null,   
                'cia_seguros' => $row['cia_seguros'],
                'no_siniestro' => $row['no_siniestro'],
                'no_reporte' => $row['no_reporte'],
                'conductor' => $row['conductor'],
                'estado_id_estado' => $row['estado'],
                'municipio_id_municipio' => $row['ciudad'],
                'autoridad_participante' => $row['autoridad_participante'],
                'no_carpeta' => $row['no_carpeta'],
                'importe' => $row['importe'],
                'fecha_tramite' => $row['fecha_tramite'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_tramite'])->format('Y-m-d') : null, 
                'unidad_tramite_gestor_id'=>$row['responsable_proceso'],
                'fecha_conclusion'=> $row['fecha_conclusion'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_conclusion'])->format('Y-m-d') : null,
                'observaciones'=>$row['observaciones'],
                'id_status_delete'=>1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];
            // dd($data);
            TramiteBajavehiculoSiniestroInfo::insert($data);


        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

}