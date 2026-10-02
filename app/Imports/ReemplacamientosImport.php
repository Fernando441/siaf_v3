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
use App\Models\Unidad\TramiteReemplacamientoInfo;
use App\Models\Unidad\TramiteEmplacamientoInfo;
use App\Models\Unidad\Unidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class ReemplacamientosImport implements ToCollection, WithHeadingRow
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
            $upd_info_emplacamiento = TramiteEmplacamientoInfo::where('unidad_id', $no_serie->id)->first();
            if($upd_info_emplacamiento->op_estatus == 1)
            {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteEmplacamientoInfo::where('id', $upd_info_emplacamiento->id)->update($data);          
            }

            $upd_info_tenencia = TramiteReemplacamientoInfo::where('unidad_id', $row['unidad_id'])->where('op_estatus', 1)->get();
            
            foreach ($upd_info_tenencia as $key => $value) {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteReemplacamientoInfo::where('id', $value->id)->update($data);
            }

            $data = [
                'unidad_id' => $no_serie->id,
                'unidad_tramite_gestor_id' => $row['gestor'],
                'id_propietario' => $row['propietario'],
                'unidad_tramite_tipo_placas_id' => $row['tipo_placa'],
                'op_estatus' => 1,
                'fecha_tramite' => $row['fecha_tramite'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_tramite'])->format('Y-m-d') : null, 
                'fecha_expedicion' => $row['fecha_expedicion'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_expedicion'])->format('Y-m-d') : null, 
                'fecha_vencimiento_tarjeta' => $row['fecha_vencimiento'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_vencimiento'])->format('Y-m-d') : null,  
                'importe' => $row['importe'],
                'numero_placas' => $row['no_placas'],
                'entidad_placas' => $row['entidad'],
                'engomado' => $row['engomado'],
                'holograma' => $row['holograma'],
                'verificacion_op' => $row['verifica'],
                'observaciones'=>$row['observaciones'],
                'id_status_delete'=>1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            TramiteReemplacamientoInfo::insert($data);


        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

}