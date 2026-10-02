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
use App\Models\Unidad\TramiteVerificacionInfo;
use App\Models\Unidad\Unidad;
use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithHeadingRow, WithValidation, SkipsFailures};

class VerificacionImport implements ToCollection, WithHeadingRow
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
            $upd_info_tenencia = TramiteVerificacionInfo::where('unidad_id', $no_serie->id)->where('op_estatus', 1)->get();
            
            foreach ($upd_info_tenencia as $key => $value) {
                $data = [
                    'op_estatus' => 2,
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,        
                ];
                TramiteVerificacionInfo::where('id', $value->id)->update($data);
            }

            $data = [
                'unidad_id' => $no_serie->id,
                'unidad_tramite_gestor_id' => $row['gestor'],
                'id_propietario' => $row['propietario'],
                'tipo_reporte' => $row['tipo_reporte'],
                'entidad_id' => $row['entidad'],
                'fecha_tramite' => $row['fecha_expedicion'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_expedicion'])->format('Y-m-d') : null,
                'fecha_vencimiento' => $row['fecha_vencimiento'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_vencimiento'])->format('Y-m-d') : null,
                'fecha_entrega' => $row['fecha_entrega'] ? Carbon::createFromFormat('d/m/Y', $row['fecha_entrega'])->format('Y-m-d') : null,
                'nombre_receptor' => $row['nombre_receptor'],
                'importe' => $row['importe'],
                'op_estatus' => 1,
                'observaciones'=>$row['observaciones'],
                'id_status_delete'=>1,
                'iduserCreated' =>auth()->user()->id,
                'iduserUpdated' =>auth()->user()->id,
                'created_at' =>date('Y-m-d H:i:s'),
                'updated_at' =>date('Y-m-d H:i:s')
            ];

            TramiteVerificacionInfo::insert($data);
        }

        session()->flash('success', 'La información se cargo correctamente');
        return redirect()->route('unidad.catalogounidad');
    }

}